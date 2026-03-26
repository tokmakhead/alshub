<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Standart haberleri çek
        $latestContents = \App\Models\Content::where('status', 'published')->latest()->take(6)->get();
        
        // Araştırmaları ayrı bir değişken olarak çek (Risk yok)
        $latestResearch = \App\Models\ResearchArticle::where('status', 'published')->latest()->take(6)->get();

        return view('frontend.home', compact('latestContents', 'latestResearch'));
    }

    public function aboutAls()
    {
        return view('frontend.pages.about_als');
    }

    public function aboutUs()
    {
        return view('frontend.pages.about_us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function policy()
    {
        return view('frontend.pages.policy');
    }
}
