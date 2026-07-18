<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Inventory System')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="brand">
            Inventory System
        </div>

        <nav>
            <a
                href="{{ route('inventory.index') }}"
                class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}"
            >
                Inventory
            </a>

            @can('can_print')
                <a
                    href="{{ route('reports.inventory') }}"
                    class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"
                >
                    Print Report
                </a>
            @endcan

            @if(auth()->user()?->hasRole('system-administrator'))
                <a
                    href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                >
                    User Management
                </a>
            @endif

            <span class="user-label">
                {{ auth()->user()->name }}
                ({{ auth()->user()->role?->name ?? 'No Role' }})
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn-link">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    <main class="container">
        @if(session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>