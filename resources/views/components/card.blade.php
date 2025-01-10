
<div class="card overflow-hidden">
    <img src="{{ $imageUrl }}" alt="{{ $name }}'s profile picture" class="card-img-top img-fluid"
        style="max-height: 200px; object-fit: cover; width: 100%;" />
    <div class="card-body">
        <h3 class="card-title text-lg fw-bold">{{ $name }}</h3>
        <p class="card-text text-muted">{{ $age }} years old</p>

        @if ($status === 'Requested')
            <p class="text-warning mt-2">Friend request sent</p>
        @elseif ($status === null)
            <form action="{{ route('friend.store', ['id' => $friendId]) }}" method="POST">
                @csrf
                <button class="btn btn-primary mt-2">Send Friend Request</button>
            </form>
        @endif

    </div>
</div>
