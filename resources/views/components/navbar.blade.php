<header class="bg-primary text-light py-4">
    <div class="container">
        <h1 class="display-4 fw-bold">ConnectFriend</h1>
        <p class="mt-2">Connect with friends and make new ones!</p>
        @guest
            <div class="mt-4">
                <a href="{{ route('auth.index') }}" class="btn btn-light me-2">Sign In</a>
                <a href="{{ route('user.create') }}" class="btn btn-outline-light">Register</a>
            </div>
        @endguest
        @auth
        <div class="mt-4">
            <form action="{{ route('auth.sign-out') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light">Sign Out</button>
            </form>
        </div>
        @endauth
    </div>
</header>
