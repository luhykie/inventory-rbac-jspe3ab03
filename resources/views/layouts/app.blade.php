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
        <div class="brand">Inventory System</div>
        <nav>
            <a href="{{ route('inventory.index') }}">Inventory</a>
            @can('can_print')
                <a href="{{ route('reports.inventory') }}">Print Report</a>
            @endcan
            <span class="user-label">
                {{ auth()->user()->name }} ({{ auth()->user()->role?->name ?? 'No Role' }})
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-link">Logout</button>
            </form>
        </nav>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>