<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guideline;
use App\Services\ClinicalSummaryService;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function index()
    {
        $guidelines = Guideline::paginate(20);
        return view('admin.guidelines.index', compact('guidelines'));
    }

    public function create()
    {
        $guideline = new Guideline();
        return view('admin.guidelines.create', compact('guideline'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'source_org' => 'required|string|max:255',
            'summary_original' => 'nullable|string',
            'status' => 'required|in:draft,in_review,approved,published,rejected',
            'verification_tier' => 'required|integer',
        ]);

        $guideline = Guideline::create($data);
        return redirect()->route('admin.guidelines.edit', $guideline)->with('success', 'Rehber taslağı oluşturuldu. Şimdi AI ile özet hazırlayabilirsiniz.');
    }

    public function edit(Guideline $guideline)
    {
        return view('admin.guidelines.edit', compact('guideline'));
    }

    public function update(Request $request, Guideline $guideline)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_tr' => 'nullable|string|max:255',
            'summary_tr' => 'nullable|string',
            'status' => 'required|in:draft,in_review,approved,published,rejected',
            'verification_tier' => 'required|integer',
        ]);

        $guideline->update($data);
        return redirect()->route('admin.guidelines.index')->with('success', 'Rehber başarıyla güncellendi.');
    }

    public function generateAiSummary(Guideline $guideline, ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($guideline->title, $guideline->summary_original, 'clinical guideline');
        if ($result && !isset($result['error'])) {
            $summary = $result['summary_patient'] . "\n\n---\n\n**Doktor Özeti:**\n" . $result['summary_doctor'] . "\n\n**Önemli Maddeler:**\n" . implode("\n", $result['key_takeaways']);
            
            // Clean markdown and markers
            $summary = str_replace('**', '', $summary);
            $titleTr = str_replace('**', '', $result['title_tr'] ?? '');

            $guideline->update([
                'title_tr' => $titleTr,
                'summary_tr' => $summary
            ]);
            return response()->json(['success' => true, 'data' => $result]);
        }
        return response()->json(['success' => false, 'message' => $result['error'] ?? 'AI Error'], 500);
    }

    public function destroy(Guideline $guideline)
    {
        $guideline->delete();
        return redirect()->route('admin.guidelines.index')->with('success', 'Rehber silindi.');
    }
}
