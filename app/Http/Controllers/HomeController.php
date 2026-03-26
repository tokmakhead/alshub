<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get general contents
        $contents = \App\Models\Content::where('status', 'published')->latest()->take(6)->get();
        
        // Get research articles
        $research = \App\Models\ResearchArticle::where('status', 'published')->latest()->take(6)->get();
        
        // Merge them into one collection and sort by latest date
        $latestContents = $contents->concat($research)->sortByDesc(function ($item) {
            // Using created_at as fallback for sorting
            return $item->published_at ?? $item->created_at;
        })->take(6);

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
