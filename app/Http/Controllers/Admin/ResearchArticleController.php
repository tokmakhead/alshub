<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchArticle;
use Illuminate\Http\Request;
use App\Services\ClinicalSummaryService;

class ResearchArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = ResearchArticle::latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $articles = $query->paginate(15);
        return view('admin.research.index', compact('articles'));
    }

    public function edit(ResearchArticle $research)
    {
        return view('admin.research.edit', ['article' => $research]);
    }

    public function update(Request $request, ResearchArticle $research)
    {
        $data = $request->validate([
            'title' => 'required|string|max:500',
            'abstract_tr' => 'nullable|string',
            'status' => 'required|in:draft,in_review,approved,published,rejected',
            'verification_tier' => 'required|integer',
        ]);

        $research->update($data);
        return redirect()->route('admin.research.index')->with('success', 'Araştırma güncellendi.');
    }

    public function generateAiSummary(ResearchArticle $researchArticle, ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($researchArticle->title, $researchArticle->abstract_original, 'research article');
        if ($result && !isset($result['error'])) {
            $researchArticle->update([
                'abstract_tr' => $result['summary_patient'] . "\n\n---\n\n**Doktor Özeti:**\n" . $result['summary_doctor'] . "\n\n**Önemli Bulgular:**\n" . implode("\n", $result['key_takeaways'])
            ]);
            return response()->json(['success' => true, 'data' => $result]);
        }
        return response()->json(['success' => false, 'message' => $result['error'] ?? 'AI Error'], 500);
    }
}
