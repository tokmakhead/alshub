<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Fetch stable content
        $latestContents = \App\Models\Content::where('status', 'published')->latest()->limit(10)->get();

        try {
            // 2. Fetch research articles safely
            $research = \App\Models\ResearchArticle::where('status', 'published')->latest()->limit(5)->get();
            
            if ($research->count() > 0) {
                // 3. Merge them
                foreach($research as $item) {
                    $latestContents->push($item);
                }
                
                // 4. Sort and take latest 6
                $latestContents = $latestContents->sortByDesc('created_at')->values()->take(6);
            } else {
                $latestContents = $latestContents->take(6);
            }
        } catch (\Exception $e) {
            // If anything fails, fallback to standard behavior to avoid 403/500
            $latestContents = $latestContents->take(6);
        }

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
