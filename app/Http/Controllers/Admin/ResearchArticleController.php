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

        return redirect()->route('admin.research.index')->with('success', 'Makale güncellendi.');
    }
}
