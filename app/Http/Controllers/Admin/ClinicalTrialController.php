<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicalTrial;
use Illuminate\Http\Request;
use App\Services\IngestionManager;

class ClinicalTrialController extends Controller
{
    public function index(Request $request)
    {
        $query = ClinicalTrial::latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $trials = $query->paginate(15);
        return view('admin.trials.index', compact('trials'));
    }

    public function edit(ClinicalTrial $trial)
    {
        return view('admin.trials.edit', compact('trial'));
    }

    public function update(Request $request, ClinicalTrial $trial)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,in_review,approved,rejected,published',
            'verification_tier' => 'required|integer|min:1|max:3',
        ]);

        $trial->update($validated);

        // Audit Log
        \App\Models\ReviewDecisionLog::create([
            'content_type' => 'trial',
            'content_id' => $trial->id,
            'decision' => $validated['status'],
            'reviewer_id' => auth()->id(),
            'notes' => 'Status updated via admin panel.',
        ]);

        return redirect()->route('admin.trials.index')->with('success', 'Klinik çalışma güncellendi.');
    }

    public function toggleStatus(ClinicalTrial $trial)
    {
        $newStatus = $trial->status === 'published' ? 'draft' : 'published';
        $trial->update(['status' => $newStatus]);
        
        return response()->json(['success' => true, 'new_status' => $newStatus]);
    }

    public function fetchSingle(ClinicalTrial $trial, IngestionManager $manager)
    {
        $updatedTrial = $manager->syncSingleTrial($trial->nct_id);
        
        if ($updatedTrial) {
            return response()->json(['success' => true, 'message' => 'Veri güncellendi.']);
        }
        
        return response()->json(['success' => false, 'message' => 'API hata verdi.'], 500);
    }

    public function generateAiSummary(ClinicalTrial $trial, \App\Services\ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($trial->title, $trial->summary, 'clinical trial');
        
        if ($result && !isset($result['error'])) {
            // Format the composite summary
            $formatted = "### Hasta Özeti\n" . ($result['summary_patient'] ?? '') . "\n\n";
            $formatted .= "### Teknik Özet (Hekim)\n" . ($result['summary_doctor'] ?? '') . "\n\n";
            
            if (!empty($result['key_takeaways'])) {
                $formatted .= "### Önemli Notlar\n- " . implode("\n- ", $result['key_takeaways']);
            }

            $trial->update([
                'summary' => $formatted,
            ]);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'AI özeti oluşturulamadı veya servis yanıt vermedi.'], 500);
    }

    public function destroy(ClinicalTrial $trial)
    {
        $trial->delete();
        return redirect()->route('admin.trials.index')->with('success', 'Klinik çalışma silindi.');
    }
}
