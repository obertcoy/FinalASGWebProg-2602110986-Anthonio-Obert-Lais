@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <h2>Your Notifications</h2>

        @if ($notifications->isEmpty())
            <p>You have no notifications.</p>
        @else
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item">
                        <strong>{{ $notification->data['title'] }}</strong><br>
                        <p>{{ $notification->data['message'] }}</p>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </ul>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
