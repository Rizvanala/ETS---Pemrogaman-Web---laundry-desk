<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Home') | Laundry Desk</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="wrap topbar-inner">
            <a href="{{ route('home') }}" class="brand">Laundry<span>Desk</span></a>
            <nav class="menu">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Price list</a>
                @auth
                    @if (auth()->user()->isStaff())
                        <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">Customers</a>
                        <a href="{{ route('bills.index') }}" class="{{ request()->routeIs('bills.index', 'bills.show') ? 'active' : '' }}">Bills</a>
                        <a href="{{ route('bills.create') }}" class="{{ request()->routeIs('bills.create') ? 'active' : '' }}">New bill</a>
                    @else
                        <a href="{{ route('my-bills') }}" class="{{ request()->routeIs('my-bills') ? 'active' : '' }}">My bills</a>
                    @endif
                @endauth
            </nav>
            <div class="account">
                @auth
                    <span class="who">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-small">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-small">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-small">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="wrap content">
        @if (session('success'))
            <div class="flash flash-ok">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash flash-bad">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="footer">
        <div class="wrap footer-inner">
            <span>Laundry Desk &middot; Surabaya</span>
        </div>
    </footer>
</body>
</html>
