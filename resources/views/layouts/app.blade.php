<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'User Portal')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            User Portal
        </a>

        @auth
            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('profile') }}" class="text-white">
                    Profile
                </a>

                <a href="{{ route('education.index') }}" class="text-white">
                    Education
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>

            </div>
        @endauth

    </div>
</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</div>

</body>
</html>