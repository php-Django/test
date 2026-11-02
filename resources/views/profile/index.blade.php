@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h4>Update Profile</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('profile.update') }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" value="{{ $user->email }}"
                       class="form-control" disabled>
                <small class="text-muted">
                    Email cannot be changed here.
                </small>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $user->phone) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth"
                       value="{{ old('date_of_birth', $user->date_of_birth) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address"
                          class="form-control">{{ old('address', $user->address) }}</textarea>
            </div>

            <button class="btn btn-primary">
                Update Profile
            </button>

        </form>

    </div>
</div>

<div class="mt-3">
    <a href="{{ route('education.index') }}" class="btn btn-success">
        Manage Education Qualifications
    </a>
</div>

@endsection