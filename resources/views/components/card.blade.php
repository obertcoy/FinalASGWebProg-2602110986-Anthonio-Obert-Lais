<div class="card overflow-hidden">
    <img src="{{ $imageUrl }}" alt="{{ $name }}'s profile picture" class="card-img-top img-fluid"
        style="max-height: 200px; object-fit: cover; width: 100%;" />
    <div class="card-body">
        <h3 class="card-title fw-bold" style="font-size: 1.2em;">{{ $name }} ({{ $gender }})</h3>
        <p class="card-text text-muted">{{ $age }} years old</p>

        <h4 class="mt-2 fw-bold" style="font-size: 1em;">Hobbies:</h4>
        <ul style="list-style-type: disc; padding-left: 20px;">
            @foreach ($hobbies as $hobby)
                <li>{{ $hobby->name }}</li>
            @endforeach
        </ul>

        <div class="mt-3">
            @if ($status === 'Requested')
                <p class="text-warning">Friend request sent</p>
            @elseif ($status === null)
                <form action="{{ route('friend.store', ['id' => $userId]) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Send Friend Request</button>
                </form>
            @endif
        </div>

    </div>
</div>
