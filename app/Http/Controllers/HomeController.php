<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\ResearchArticle;

class HomeController extends Controller
{
    public function index()
    {
        // Get contents
        $contents = Content::where('status', 'published')->latest()->take(6)->get();
        // Get research articles
        $research = ResearchArticle::where('status', 'published')->latest()->take(6)->get();
        
        // Merge and sort them by date
        $latestContents = $contents->concat($research)->sortByDesc(function ($item) {
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
