<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ExpertCenter;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('center')->paginate(20);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $centers = ExpertCenter::all();
        return view('admin.doctors.create', compact('centers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'expert_center_id' => 'nullable|exists:expert_centers,id',
            'title' => 'nullable|string',
            'specialty' => 'nullable|string',
            'biography' => 'nullable|string',
            'orcid_id' => 'nullable|string|unique:doctors',
            'is_verified' => 'boolean',
        ]);

        Doctor::create($data);
        return redirect()->route('admin.doctors.index')->with('success', 'Doktor başarıyla eklendi.');
    }

    public function edit(Doctor $doctor)
    {
        $centers = ExpertCenter::all();
        return view('admin.doctors.edit', compact('doctor', 'centers'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'expert_center_id' => 'nullable|exists:expert_centers,id',
            'title' => 'nullable|string',
            'specialty' => 'nullable|string',
            'biography' => 'nullable|string',
            'is_verified' => 'boolean',
        ]);

        $doctor->update($data);
        return redirect()->route('admin.doctors.index')->with('success', 'Doktor başarıyla güncellendi.');
    }
}
