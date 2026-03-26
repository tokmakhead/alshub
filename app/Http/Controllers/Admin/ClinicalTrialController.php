<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicalTrial;
use Illuminate\Http\Request;

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

    public function destroy(ClinicalTrial $trial)
    {
        $trial->delete();
        return redirect()->route('admin.trials.index')->with('success', 'Klinik çalışma silindi.');
    }
}
