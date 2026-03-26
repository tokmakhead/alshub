<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get contents
        $contents = \App\Models\Content::where('status', 'published')->latest()->take(6)->get();
        // Get research
        $research = \App\Models\ResearchArticle::where('status', 'published')->latest()->take(6)->get();
        
        // Merge them. Since ResearchArticle now has 'translated_title' etc. accessors, 
        // it will work perfectly in the generic home page loop.
        $latestContents = $contents->concat($research)->sortByDesc('created_at')->take(6);

        return view('frontend.home', compact('latestContents'));
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
