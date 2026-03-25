<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchArticle;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'abstract_tr' => 'required|string',
            'status' => 'required|in:draft,in_review,approved,rejected,published',
            'verification_tier' => 'required|integer|min:1|max:3',
        ]);

        $research->update($validated);

        // Audit Log
        \App\Models\ReviewDecisionLog::create([
            'content_type' => 'research',
            'content_id' => $research->id,
            'decision' => $validated['status'],
            'reviewer_id' => auth()->id(),
            'notes' => 'Status updated via admin panel.',
        ]);

        return redirect()->route('admin.research.index')->with('success', 'Makale güncellendi.');
    }
}
