@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Login</h4>
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

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
                        <input type="checkbox" name="remember" value="1">
                        Remember Me
                    </div>

                    <button class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

                <p class="mt-3 text-center">
                    New user?
                    <a href="{{ route('register') }}">Register</a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection