<header>
    <nav>
        <ul>
            <a href="{{ route('index') }}">Home</a>
            @if (!Auth::check())
            <a href="{{ route('admin.login') }}">Admin</a>
            @else
                <a href="{{ route('admin.logout') }}">Logout</a>
            @endif
            <a href="/admin/quotes">Quotes</a>
            <a href="/admin/dashboard">Dashboard</a>
        </ul>
    </nav>
</header>