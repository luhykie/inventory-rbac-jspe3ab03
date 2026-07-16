<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inventory System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Inventory System Login</h1>

            @if ($errors->any())
                <p class="error">{{ $errors->first() }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Login</button>
            </form>

            <p style="margin-top: 16px;">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>