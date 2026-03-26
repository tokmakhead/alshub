<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
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
            'status' => 'required|in:draft,in_review,approved,rejected,published',
            'verification_tier' => 'required|integer|min:1|max:3',
        ]);

        $drug->update($validated);

        return redirect()->route('admin.drugs.index')->with('success', 'İlaç güncellendi.');
    }

    public function destroy(Drug $drug)
    {
        $drug->delete();
        return redirect()->route('admin.drugs.index')->with('success', 'İlaç kaydı silindi.');
    }
}
