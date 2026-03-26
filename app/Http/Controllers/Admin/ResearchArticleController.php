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
            return redirect()->back()->with('error', 'PubMed üzerinden veri çekilemedi. Lütfen PMID numarasını kontrol edin.');
        }

        $article = ResearchArticle::create([
            'pmid' => $data['pmid'],
            'doi' => $data['doi'] ?? null,
            'title' => $data['title'],
            'abstract_original' => $data['abstract'],
            'authors_json' => $data['authors'] ?? [],
            'journal_name' => $data['journal'] ?? null,
            'publication_date' => $data['published_at'] ?? null,
            'status' => 'draft',
            'verification_tier' => 1,
        ]);

        return redirect()->route('admin.research.edit', $article->id)->with('success', 'Makale başarıyla çekildi. Şimdi AI özeti oluşturabilirsiniz.');
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

    public function destroy(ResearchArticle $research)
    {
        $research->delete();
        return redirect()->route('admin.research.index')->with('success', 'Araştırma silindi.');
    }

    public function generateAiSummary(ResearchArticle $researchArticle, ClinicalSummaryService $ai)
    {
        $result = $ai->summarize($researchArticle->title, $researchArticle->abstract_original, 'research article');
        if ($result && !isset($result['error'])) {
            $summary = $result['summary_patient'] . "\n\n---\n\n**Doktor Özeti:**\n" . $result['summary_doctor'] . "\n\n**Önemli Bulgular:**\n" . implode("\n", $result['key_takeaways']);
            
            $researchArticle->update([
                'abstract_tr' => $summary
            ]);
            return response()->json(['success' => true, 'data' => $result]);
        }
        return response()->json(['success' => false, 'message' => $result['error'] ?? 'AI Error'], 500);
    }
}
