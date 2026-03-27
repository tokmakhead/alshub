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

    public function cleanupTitles()
    {
        // 0. EMERGENCY DB SCHEMA PATCH (Because 'migrate' says nothing to migrate)
        if (!\Illuminate\Support\Facades\Schema::hasColumn('drugs', 'fda_link')) {
            \Illuminate\Support\Facades\Schema::table('drugs', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->text('indication')->nullable()->after('brand_name');
                $table->string('fda_link')->nullable()->after('is_approved_fda');
                $table->string('ema_link')->nullable()->after('is_approved_ema');
                $table->text('price_info')->nullable();
                $table->text('accessibility_info')->nullable();
            });
        }

        $drugs = Drug::all();
        $count = 0;
        foreach ($drugs as $drug) {
            $current = $drug->generic_name;
            $updated = false;

            // 1. Force sync and fix fda_link from regional status (Using correct set_id)
            $status = $drug->regionalStatuses()->where('region', 'US')->first();
            if ($status && !empty($status->raw_payload_json)) {
                $raw = $status->raw_payload_json;
                $setId = $raw['set_id'] ?? null;
                if ($setId) {
                    $correctLink = "https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=" . $setId;
                    // Overwrite if empty or if it points to the old labels.fda.gov domain
                    if (empty($drug->fda_link) || str_contains($drug->fda_link, 'labels.fda.gov')) {
                        $drug->fda_link = $correctLink;
                        $drug->is_approved_fda = true;
                        $status->label_url = $correctLink;
                        $status->save();
                        $updated = true;
                    }
                }
            }

            // 2. Heavy Cleaning for titles that are actually sentences
            // Pattern: starts with "X is indicated for..." or is very long
            if (strlen($current) > 40 && str_contains(strtolower($current), 'indicated for')) {
                // Move current title to description_original if empty
                if (empty($drug->description_original)) {
                    $drug->description_original = $current;
                }
                
                // Extract real generic name (usually first word or two)
                // e.g. "Riluzole is indicated for..." -> "Riluzole"
                $parts = explode(' ', $current);
                $drug->generic_name = $parts[0] ?? $current;
                $updated = true;
            }

            // 3. Remove "INDICATIONS" prefixes (standard cleanup)
            $clean = preg_replace('/^(\d+\.?\s+)?INDICATIONS\s+AND\s+USAGE\s+/i', '', $drug->generic_name);
            if ($drug->generic_name !== $clean) {
                $drug->generic_name = trim($clean);
                $updated = true;
            }
            
            if ($updated) {
                $drug->save();
                $count++;
            }
        }
        return "Refined $count drugs and synced metadata. Page 17 should be cleaner now.";
    }

    public function destroy(Drug $drug)
    {
        $drug->delete();
        return redirect()->route('admin.drugs.index')->with('success', 'İlaç kaydı silindi.');
    }
}
