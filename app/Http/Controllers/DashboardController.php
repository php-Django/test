<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalEducation = $user->educationQualifications()->count();

        return view('dashboard', compact(
            'user',
            'totalEducation'
        ));
    }
}