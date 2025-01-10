@extends('layouts.main')
@section('content')


    <div class="container py-5">
        <h2 class="fw-bold mb-2">Featured Users</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach ($featuredUsers as $user)
                <div class="col">
                    <x-card :friendId="$user->id" :name="$user->name" :imageUrl="$user->profile_picture_url" :age="$user->age" />
                </div>
            @endforeach
        </div>
    </div>
@endsection
