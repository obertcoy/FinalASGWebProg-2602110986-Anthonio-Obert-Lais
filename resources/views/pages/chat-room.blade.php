@extends('layouts.main')

@section('content')
    <div class="container py-5">

        {{-- @dd($friend) --}}
        <h2>Chat with {{ $friend->name }}</h2>

        <div class="chat-box my-4">
            @foreach ($messages as $message)
                <div class="message my-2">
                    <strong>{{ $message->sender->name }}:</strong> {{ $message->message }}
                    <small class="ms-1 text-muted">({{ $message->created_at->diffForHumans() }})</small>
                </div>
            @endforeach
        </div>
        
        <form method="POST" action="{{ route('chat.store', ['chatRoom' => $chatRoom->id, 'friend' => $friend->id]) }}">
            @csrf
            <div class="form-group">
                <textarea name="message" rows="3" class="form-control" placeholder="Type your message..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Send</button>
        </form>
    </div>
@endsection
