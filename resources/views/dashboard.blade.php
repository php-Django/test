@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h3>Welcome, {{ $user->name }}!</h3>

<div class="row mt-4">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Account Email</h6>
                <h5>{{ $user->email }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Education Qualifications</h6>
                <h5>{{ $totalEducation }}</h5>
            </div>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{ route('profile') }}" class="btn btn-primary">
        Update Profile
    </a>

    <a href="{{ route('education.index') }}" class="btn btn-success">
        Manage Education
    </a>
</div>

@endsection