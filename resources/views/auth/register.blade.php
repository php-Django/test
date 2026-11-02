@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Create Account</h4>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <p class="mt-3 text-center">
                    Already registered?
                    <a href="{{ route('login') }}">Login</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection