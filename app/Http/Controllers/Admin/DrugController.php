<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Services\ClinicalSummaryService;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index(Request $request)
    {
        $query = Drug::with('regionalStatuses')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $drugs = $query->paginate(15);
        return view('admin.drugs.index', compact('drugs'));
    }

    public function create()
    {
        return view('admin.drugs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'generic_name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'indication' => 'nullable|string',
            'is_approved_fda' => 'boolean',
            'is_approved_ema' => 'boolean',
            'is_approved_titck' => 'boolean',
            'verification_tier' => 'required|integer|min:1|max:3',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['generic_name']);
        
        $drug = Drug::create($validated);

        return redirect()->route('admin.drugs.edit', $drug)->with('success', 'İlaç oluşturuldu, detayları düzenleyebilirsiniz.');
    }

    public function edit(Drug $drug)
    {
        $drug->load('regionalStatuses');
        return view('admin.drugs.edit', compact('drug'));
    }

    public function update(Request $request, Drug $drug)
    {
        $validated = $request->validate([
            'generic_name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'indication' => 'nullable|string',
            'description_original' => 'nullable|string',
            'description_tr' => 'nullable|string',
            'ai_summary' => 'nullable|string',
            'is_approved_fda' => 'boolean',
            'is_approved_ema' => 'boolean',
            'is_approved_titck' => 'boolean',
            'fda_link' => 'nullable|url',
            'ema_link' => 'nullable|url',
            'price_info' => 'nullable|string',
            'accessibility_info' => 'nullable|string',
            'status' => 'required|in:draft,in_review,approved,rejected,published',
            'verification_tier' => 'required|integer|min:1|max:3',
        ]);

        // Fix boolean values from checkbox
        $validated['is_approved_fda'] = $request->has('is_approved_fda');
        $validated['is_approved_ema'] = $request->has('is_approved_ema');
        $validated['is_approved_titck'] = $request->has('is_approved_titck');

        if (isset($validated['description_tr'])) {
            $validated['description_tr'] = str_replace('**', '', $validated['description_tr']);
        }

        $drug->update($validated);

        return redirect()->route('admin.drugs.index')->with('success', 'İlaç güncellendi.');
    }

    public function toggleStatus(Drug $drug)
    {
        $drug->status = $drug->status === 'published' ? 'draft' : 'published';
        $drug->save();
        return response()->json(['success' => true, 'status' => $drug->status]);
    }

    public function generateAiSummary(Drug $drug, ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($drug->generic_name, $drug->description_original, 'drug development');
        if ($result && !isset($result['error'])) {
            $summary = ($result['summary_patient'] ?? '') . "\n\n---\n\nTeknik Detay:\n" . ($result['summary_doctor'] ?? '') . "\n\nKritik Bilgi:\n" . implode("\n", $result['key_takeaways'] ?? []);
            
            $drug->update([
                'description_tr' => str_replace('**', '', $summary)
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => $result['error'] ?? 'AI Error'], 500);
    }

    public function destroy(Drug $drug)
    {
        $drug->delete();
        return redirect()->route('admin.drugs.index')->with('success', 'İlaç kaydı silindi.');
    }
}
