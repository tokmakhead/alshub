<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guideline;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function index()
    {
        $guidelines = Guideline::paginate(20);
        return view('admin.guidelines.index', compact('guidelines'));
    }

    public function edit(Guideline $guideline)
    {
        return view('admin.guidelines.edit', compact('guideline'));
    }

    public function update(Request $request, Guideline $guideline)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary_tr' => 'nullable|string',
            'status' => 'required|in:draft,in_review,approved,published,rejected',
            'verification_tier' => 'required|integer',
        ]);

        $guideline->update($data);
        return redirect()->route('admin.guidelines.index')->with('success', 'Rehber başarıyla güncellendi.');
    }

    public function destroy(Guideline $guideline)
    {
        $guideline->delete();
        return redirect()->route('admin.guidelines.index')->with('success', 'Rehber silindi.');
    }
}
