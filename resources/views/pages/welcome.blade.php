@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-2">Featured Users</h2>

        <form method="GET" action="{{ route('index') }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <select name="gender" class="form-select" aria-label="Gender">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <input type="text" name="hobbies" class="form-control" placeholder="Search by hobbies"
                        value="{{ request('hobbies') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff; border: none;">
                        Filter</button>
                </div>
            </div>
        </form>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach ($featuredUsers as $user)
                <div class="col">
                    <x-card :user="$user" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
