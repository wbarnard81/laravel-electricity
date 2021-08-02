<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/images/logo.png" alt="logo" style="height: 50px;">
        </a>
        <ul class="navbar-nav mb-2 mb-lg-0 flex-row align-self- justify-content-end">
            @guest
                <li class="nav-item">
                    <a class="nav-link me-4" aria-current="page" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/register">Register</a>
                </li>
            @else
            @if (auth()->user()->email == 'wbarnard81@gmail.com')
                <li class="nav-item">
                    <a class="nav-link me-4" aria-current="page" href="/houses/meters/all-readings">All Readings</a>
                </li>
            @endif
                <li class="nav-item me-4">
                    <a class="nav-link">{{ auth()->user()->name }}</a>
                </li>
                <li class="nav-item me-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn nav-link" type="submit">Logout</button>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
            @endguest
        </ul>
  </div>
</nav>