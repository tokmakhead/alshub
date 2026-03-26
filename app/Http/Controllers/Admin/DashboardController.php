<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchArticle;
use App\Models\ClinicalTrial;
use App\Models\Drug;
use App\Models\Guideline;
use App\Models\Content;
use App\Models\Source;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $models = [
            ResearchArticle::class,
            ClinicalTrial::class,
            Drug::class,
            Guideline::class,
            Content::class
        ];

        $totalContent = 0;
        $drafts = 0;
        $inReview = 0;
        $published = 0;

        foreach ($models as $model) {
            $totalContent += $model::count();
            $drafts += $model::where('status', 'draft')->count();
            $inReview += $model::whereIn('status', ['review', 'in_review'])->count();
            $published += $model::where('status', 'published')->count();
        }

        $stats = [
            'total_content' => $totalContent,
            'drafts' => $drafts,
            'review' => $inReview,
            'published' => $published,
            'sources' => \App\Models\SourceRegistry::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
