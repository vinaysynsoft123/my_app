<header id="app-header">
<nav class="navbar navbar-expand navbar-light bg-white fixed-top">
    <div class="container-fluid">
        <button class="btn btn-primary me-3 d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
          Welcome Admin
        </a>

        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 text-muted d-none d-md-block">
                Welcome, {{ auth()->user()->name ?? 'Admin' }}
            </span>
            <div class="dropdown">
                <a class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                    <img src="https://i.pinimg.com/736x/3f/94/70/3f9470b34a8e3f526dbdb022f9f19cf7.jpg" alt="Profile" class="rounded-circle" width="40">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('settings') }}">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
</header>