<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_content' => \App\Models\Content::count(),
            'drafts' => \App\Models\Content::where('status', 'draft')->count(),
            'review' => \App\Models\Content::where('status', 'review')->count(),
            'published' => \App\Models\Content::where('status', 'published')->count(),
            'sources' => \App\Models\Source::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
