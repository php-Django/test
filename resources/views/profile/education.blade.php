@extends('layouts.app')

@section('title', 'Education')

@section('content')

<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h4>Add Education Qualification</h4>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('education.store') }}">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Degree</label>
                    <input type="text" name="degree"
                           class="form-control" required
                           placeholder="B.Tech, MCA, MBA">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Institution</label>
                    <input type="text" name="institution"
                           class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Field of Study</label>
                    <input type="text" name="field_of_study"
                           class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>Start Year</label>
                    <input type="number" name="start_year"
                           class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label>End Year</label>
                    <input type="number" name="end_year"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Grade / Percentage</label>
                    <input type="text" name="grade"
                           class="form-control">
                </div>

            </div>

            <button class="btn btn-primary">
                Add Qualification
            </button>

        </form>

    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header">
        <h4>My Qualifications</h4>
    </div>

    <div class="card-body">

        @forelse($educations as $education)

            <div class="border rounded p-3 mb-3">

                <h5>{{ $education->degree }}</h5>

                <p class="mb-1">
                    {{ $education->institution }}
                </p>

                <p class="text-muted mb-2">
                    {{ $education->field_of_study }}
                    |
                    {{ $education->start_year }} -
                    {{ $education->end_year }}
                </p>

                <p>Grade: {{ $education->grade }}</p>

                <form method="POST"
                      action="{{ route('education.destroy', $education->id) }}"
                      onsubmit="return confirm('Delete this qualification?')">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>

                </form>

            </div>

        @empty

            <p class="text-muted">
                No education qualifications added yet.
            </p>

        @endforelse

    </div>
</div>

@endsection