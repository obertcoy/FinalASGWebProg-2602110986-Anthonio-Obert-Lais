<header class="bg-primary text-light py-4">
    <div class="container">
        <h1 class="display-4 fw-bold">
            <a href="{{ route('index') }}" style="text-decoration: none; color: inherit;">
                ConnectFriend
            </a>
        </h1>
        <p class="mt-2">Connect with friends and make new ones!</p>
        @guest
            <div class="mt-4">
                <a href="{{ route('auth.index') }}" class="btn btn-light me-2">Sign In</a>
                <a href="{{ route('user.create') }}" class="btn btn-outline-light">Register</a>
            </div>
        @endguest
        @auth


            <div class="d-flex justify-content-between w-100 mt-4 align-items-center">

                <div class="">
                    <form action="{{ route('auth.sign-out') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-light">Sign Out</button>
                    </form>
                </div>

                <div class="text-end ms-auto">

                    <a href="{{ route('friend.index') }}" class="btn btn-light me-2">Friends</a>
                    <a href="{{ route('notification.index') }}" class="btn btn-light ">Notifications</a>
                    <span class="ms-3">Hi {{$name}}!</span>
                </div>
            </div>


        @endauth
    </div>
</header>
