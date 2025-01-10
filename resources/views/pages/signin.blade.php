<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h4>Sign In</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.sign-in') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" required />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group form-check mb-3">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary w-100">Sign In</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p>Don't have an account? <a href="{{ route('user.create') }}">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
