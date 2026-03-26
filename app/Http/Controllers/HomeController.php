<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestContents = \App\Models\Content::where('status', 'published')->latest()->take(6)->get();
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
