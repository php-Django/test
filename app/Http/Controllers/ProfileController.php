<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $educations = $user->educationQualifications()
            ->latest()
            ->get();

        return view('profile.index', compact(
            'user',
            'educations'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:2000',
        ]);

        Auth::user()->update($validated);

        return back()->with(
            'success',
            'Profile updated successfully!'
        );
    }
}