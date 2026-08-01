<div class="sidebar">


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            {{-- Dashboard --}}
            @can('dashboard.view')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-chart-pie"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            @endcan

            {{-- Administration --}}
            @if (auth()->user()->canAny(['users.view', 'roles.view', 'permissions.view']))
                <li class="nav-item {{ request()->routeIs('users.*', 'roles.*', 'permissions.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('users.*', 'roles.*', 'permissions.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Administration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-fw fa-user-shield"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}"
                                class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-fw fa-key"></i>
                                <p>Permissions</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            {{-- Unified Master Data Management --}}
            @if (auth()->user()->canAny(['schools.view', 'districts.view', 'offices.view']))
                <li class="nav-item">
                    <a href="{{ route('master-data.index') }}"
                        class="nav-link {{ request()->routeIs('master-data.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Data Management</p>
                    </a>
                </li>
            @endif
            {{-- Reports --}}
            @can('reports.view')
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}"
                        class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reports</p>
                    </a>
                </li>
            @endcan

            {{-- Settings --}}

            <li class="nav-item">
                <a href="{{ route('profile.index') }}"
                    class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>My Profile</p>
                </a>
            </li>

            @can('settings.manage')
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}"
                        class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>
            @endcan

            @can('announcements.manage')
                <li class="nav-item">
                    <a href="{{ route('announcements.index') }}"
                        class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn text-warning"></i>
                        <p>
                            Announcements
                            @php
                                $activeAnnouncementsCount = \App\Models\Announcement::where('is_active', true)->count();
                            @endphp
                            @if ($activeAnnouncementsCount > 0)
                                <span class="badge bg-warning text-dark float-end">{{ $activeAnnouncementsCount }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endcan

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
