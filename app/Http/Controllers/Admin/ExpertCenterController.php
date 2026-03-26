<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertCenter;
use Illuminate\Http\Request;

class ExpertCenterController extends Controller
{
    public function index()
    {
        $centers = ExpertCenter::withCount('doctors')->paginate(20);
        return view('admin.expert-centers.index', compact('centers'));
    }

    public function create()
    {
        return view('admin.expert-centers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location_city' => 'nullable|string',
            'location_country' => 'nullable|string',
            'website_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_verified' => 'boolean',
        ]);

        ExpertCenter::create($data);
        return redirect()->route('admin.expert-centers.index')->with('success', 'Merkez başarıyla eklendi.');
    }

    public function edit(ExpertCenter $expertCenter)
    {
        return view('admin.expert-centers.edit', ['center' => $expertCenter]);
    }

    public function update(Request $request, ExpertCenter $expertCenter)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location_city' => 'nullable|string',
            'location_country' => 'nullable|string',
            'website_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_verified' => 'boolean',
        ]);

        $expertCenter->update($data);
        return redirect()->route('admin.expert-centers.index')->with('success', 'Merkez başarıyla güncellendi.');
    }

    public function destroy(ExpertCenter $expertCenter)
    {
        $expertCenter->delete();
        return redirect()->route('admin.expert-centers.index')->with('success', 'Merkez silindi.');
    }
}
