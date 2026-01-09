a<div class="sidebar" id="sidebar">
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house me-3"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.calendar') ? 'active' : '' }}"
                href="{{ route('bookings.calendar') }}">
                <i class="bi bi-calendar3 me-3"></i> Booking Calendar
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                <i class="bi bi-building me-3"></i> Room Management
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings.report') ? 'active' : '' }}"
                href="{{ route('bookings.report') }}"><i class="bi bi-people me-3"></i> Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}"
                href="{{ route('reports.index') }}">
                <i class="bi bi-graph-up me-3"></i> Reports
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}"><i
                    class="bi bi-gear me-3"></i> Settings</a>
        </li>
    </ul>
</div>
