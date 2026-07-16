@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card" style="max-width: 420px; margin: 40px auto;">
    <h1>Create an Account</h1>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select id="role_id" name="role_id" required>
                <option value="">-- Select a role --</option>
                @foreach (\App\Models\Role::where('slug', '!=', 'system-administrator')->get() as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Register</button>
    </form>

    <p style="margin-top: 16px;">
        Already have an account? <a href="{{ route('login') }}">Log in</a>
    </p>
</div>
@endsection