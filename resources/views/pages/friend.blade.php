@extends('layouts.main')

@section('content')
    <div class="container mt-4">

        <!-- Friend Requests Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h3>Friend Requests</h3>
            </div>
            <div class="card-body">
                @if ($friendRequests->isEmpty())
                    <p>No friend requests at the moment.</p>
                @else
                    <ul class="list-group">
                        @foreach ($friendRequests as $request)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $request->user->name }}

                                <div class="d-flex justify-content-end gap-2 align-items-center">

                                    <form action="{{ route('friend.update', ['friend' => $request->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="accept" value="1">
                                        <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                    </form>

                                    <form action="{{ route('friend.update',  ['friend' => $request->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="accept" value="0">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- All Friends Section -->
        <div class="card">
            <div class="card-header">
                <h3>All Friends</h3>
            </div>
            <div class="card-body">
                @if ($friends->isEmpty())
                    <p>You don't have any friends yet.</p>
                @else
                    <ul class="list-group">
                        @foreach ($friends as $friend)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $friend->user->name }}
                                <span class="badge bg-success">
                                    Friend
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    </div>
@endsection
