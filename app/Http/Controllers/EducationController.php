<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Auth::user()
            ->educationQualifications()
            ->latest()
            ->get();

        return view('profile.education', compact('educations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'nullable|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100',
            'grade' => 'nullable|string|max:100',
        ]);

        Auth::user()->educationQualifications()->create($validated);

        return back()->with('success', 'Qualification added!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_year' => 'nullable|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100',
            'grade' => 'nullable|string|max:100',
        ]);

        $education = Auth::user()
            ->educationQualifications()
            ->findOrFail($id);

        $education->update($validated);

        return back()->with('success', 'Qualification updated!');
    }

    public function destroy($id)
    {
        $education = Auth::user()
            ->educationQualifications()
            ->findOrFail($id);

        $education->delete();

        return back()->with('success', 'Qualification deleted!');
    }
}