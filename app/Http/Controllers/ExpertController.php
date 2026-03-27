<?php

namespace App\Http\Controllers;

use App\Models\ExpertCenter;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    public function index(Request $request)
    {
        $query = ExpertCenter::withCount('doctors');

        if ($request->has('q') && !empty($request->q)) {
            $term = $request->q;
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('location_city', 'like', "%{$term}%")
                  ->orWhere('location_country', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $centers = $query->orderBy('is_verified', 'desc')
                         ->orderBy('location_country', 'asc')
                         ->paginate(12);

        return view('frontend.experts.index', compact('centers'));
    }

    public function show($slug)
    {
        $center = ExpertCenter::with('doctors')->where('slug', $slug)->firstOrFail();
        return view('frontend.experts.show', compact('center'));
    }
}
