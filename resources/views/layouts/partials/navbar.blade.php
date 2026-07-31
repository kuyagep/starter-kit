<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu Component -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell fa-fw"></i>
                @if ($unreadNotificationsCount > 0)
                    <span
                        class="badge badge-warning navbar-badge font-weight-bold">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 320px;">
                <span class="dropdown-item dropdown-header font-weight-bold text-secondary">
                    {{ $unreadNotificationsCount }} Unread Notifications
                </span>
                <div class="dropdown-divider"></div>

                @forelse($unreadNotifications as $notification)
                    <a href="{{ $notification->data['action_url'] ?? '#' }}"
                        class="dropdown-item d-flex align-items-start p-3 text-wrap notification-item"
                        data-id="{{ $notification->id }}">
                        <div class="mr-3 mt-1">
                            <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} fa-fw"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 text-sm font-weight-bold text-dark">{{ $notification->data['title'] }}</p>
                            <p class="mb-0 text-xs text-muted">{{ $notification->data['message'] }}</p>
                            <span class="text-xs text-secondary">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <div class="dropdown-item text-center p-3 text-muted text-sm">
                        <i class="fas fa-check-circle text-success mb-2 d-block fa-lg"></i>
                        All caught up! Clear queue.
                    </div>
                    <div class="dropdown-divider"></div>
                @endforelse

                @if ($unreadNotificationsCount > 0)
                    <a href="#" id="mark-all-read"
                        class="dropdown-item dropdown-footer font-weight-bold text-info text-center py-2">
                        <i class="fas fa-check-double mr-1"></i> Mark All as Read
                    </a>
                @endif
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" id="btnLogout">
                <i class="fas fa-sign-out-alt text-primary"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>
