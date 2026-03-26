<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchArticle;
use Illuminate\Http\Request;
use App\Services\ClinicalSummaryService;
use App\Services\Adapters\PubMedAdapter;

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

    public function create()
    {
        return view('admin.research.create');
    }

    public function store(Request $request, PubMedAdapter $adapter)
    {
        $validated = $request->validate([
            'pmid' => 'required|string|unique:research_articles,pmid',
        ]);

        $data = $adapter->fetch($validated['pmid']);

        if (!$data) {
            return redirect()->back()->with('error', 'PubMed üzerinden veri çekilemedi.');
        }

        // Automatically detect source and tier
        $source = \App\Models\SourceRegistry::where('source_name', 'PubMed')->first();
        $tier = $source ? $source->verification_tier : 1;

        $article = ResearchArticle::create([
            'pmid' => $data['pmid'],
            'doi' => $data['doi'] ?? null,
            'title' => $data['title'],
            'abstract_original' => $data['abstract'],
            'authors_json' => $data['authors'] ?? [],
            'journal' => $data['journal'] ?? null,
            'publication_date' => $data['published_at'] ?? null,
            'status' => 'draft',
            'verification_tier' => $tier,
        ]);

        return redirect()->route('admin.research.edit', $article->id)->with('success', 'Veri çekildi.');
    }

    public function edit(ResearchArticle $research)
    {
        return view('admin.research.edit', ['article' => $research]);
    }

    public function update(Request $request, ResearchArticle $research)
    {
        $data = $request->validate([
            'title' => 'required|string|max:500',
            'turkish_title' => 'nullable|string|max:500',
            'abstract_tr' => 'nullable|string',
            'doi' => 'nullable|string|max:255',
            'journal' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'status' => 'required|in:draft,in_review,approved,published,rejected',
            'verification_tier' => 'required|integer',
        ]);

        // Strip ** markdown bolding
        if (isset($data['abstract_tr'])) {
            $data['abstract_tr'] = str_replace('**', '', $data['abstract_tr']);
        }

        $research->update($data);
        return redirect()->route('admin.research.index')->with('success', 'Araştırma güncellendi.');
    }

    public function destroy(ResearchArticle $research)
    {
        $research->delete();
        return redirect()->route('admin.research.index')->with('success', 'Araştırma silindi.');
    }

    public function generateAiSummary(ResearchArticle $researchArticle, ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($researchArticle->title, $researchArticle->abstract_original, 'research article');
        if ($result && !isset($result['error'])) {
            $summary = ($result['summary_patient'] ?? '') . "\n\n---\n\nDoktor Özeti:\n" . ($result['summary_doctor'] ?? '') . "\n\nÖnemli Bulgular:\n" . implode("\n", $result['key_takeaways'] ?? []);
            
            // Strip ** from the title as well if needed
            $titleTr = isset($result['title_tr']) ? str_replace('**', '', $result['title_tr']) : $researchArticle->turkish_title;

            $researchArticle->update([
                'turkish_title' => $titleTr,
                'abstract_tr' => str_replace('**', '', $summary)
            ]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => $result['error'] ?? 'AI Error'], 500);
    }
}
