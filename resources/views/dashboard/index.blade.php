@extends('layouts.main')

@section('title', 'Dashboard')
@section('content-header', 'Dashboard')

@section('content')
    <div class="container-fluid">
        {{-- Welcome --}}
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            Welcome back, <b>{{ auth()->user()->name }}!</b>
                        </h4>

                        <p class="text-muted mb-0">
                            <i class="fas fa-regular fa-calendar"></i>
                            <span id="currentSystemTime"></span>
                        </p>

                    </div>
                </div>
            </div>
        </div>

        @role('Super Admin')
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <x-stat-card title="Users" :value="$users" icon="fas fa-users" color="info" />
                </div>

                <div class="col-lg-3 col-md-6">
                    <x-stat-card title="Roles" :value="$roles" icon="fas fa-user-shield" color="purple" />
                </div>

                <div class="col-lg-3 col-md-6">

                    <x-stat-card title="Permissions" :value="$permissions" icon="fas fa-key" color="teal" />

                </div>

                <div class="col-lg-3 col-md-6">

                    <x-stat-card title="Online Users" :value="1" icon="fas fa-solid fa-chart-pie" color="dark" />

                </div>

            </div>

            {{-- Tables --}}

            <div class="row">

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-header">

                            <strong>

                                Recent Users

                            </strong>

                        </div>

                        <div class="card-body table-responsive">

                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Created</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($recentUsers as $user)
                                        <tr>

                                            <td>{{ $user->name }}</td>

                                            <td>{{ $user->email }}</td>

                                            <td>{{ $user->created_at->diffForHumans() }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Links</h3>
                        </div>
                        <div class="card-body">

                            <a class="btn btn-app">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-app">
                                <i class="fas fa-play"></i> Play
                            </a>
                            <a class="btn btn-app">
                                <i class="fas fa-pause"></i> Pause
                            </a>
                            <a class="btn btn-app">
                                <i class="fas fa-save"></i> Save
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-warning">3</span>
                                <i class="fas fa-bullhorn"></i> Notifications
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-success">300</span>
                                <i class="fas fa-barcode"></i> Products
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-purple">891</span>
                                <i class="fas fa-users"></i> Users
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-teal">67</span>
                                <i class="fas fa-inbox"></i> Orders
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-info">12</span>
                                <i class="fas fa-envelope"></i> Inbox
                            </a>
                            <a class="btn btn-app">
                                <span class="badge bg-danger">531</span>
                                <i class="fas fa-heart"></i> Likes
                            </a>

                            <p>Application Buttons with Custom Colors</p>
                            <a class="btn btn-app bg-secondary">
                                <span class="badge bg-success">300</span>
                                <i class="fas fa-barcode"></i> Products
                            </a>
                            <a class="btn btn-app bg-success">
                                <span class="badge bg-purple">891</span>
                                <i class="fas fa-users"></i> Users
                            </a>
                            <a class="btn btn-app bg-danger">
                                <span class="badge bg-teal">67</span>
                                <i class="fas fa-inbox"></i> Orders
                            </a>
                            <a class="btn btn-app bg-warning">
                                <span class="badge bg-info">12</span>
                                <i class="fas fa-envelope"></i> Inbox
                            </a>
                            <a class="btn btn-app bg-info">
                                <span class="badge bg-danger">531</span>
                                <i class="fas fa-heart"></i> Likes
                            </a>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>

            </div>
        @endrole

        @if (isset($announcements) && $announcements->isNotEmpty())
            <div class="mb-4">
                @foreach ($announcements as $announcement)
                    @php
                        $icon = match ($announcement->type) {
                            'warning' => 'fa-exclamation-triangle',
                            'danger' => 'fa-bell',
                            'success' => 'fa-check-circle',
                            default => 'fa-info-circle',
                        };
                    @endphp

                    <div class="alert alert-{{ $announcement->type }} alert-dismissible fade show border-0 shadow-sm mb-3"
                        role="alert">
                        <div class="d-flex align-items-start">
                            <div class="me-3 mr-3 fs-4 h4 mb-0 align-self-center">
                                <i class="fas {{ $icon }}"></i>
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="alert-heading fw-bold font-weight-bold mb-1">{{ $announcement->title }}</h6>

                                {{-- Render rich text HTML safely --}}
                                <div class="announcement-body small mb-0">
                                    {!! $announcement->content !!}
                                </div>

                                <small class="text-muted extra-small mt-1 d-block">
                                    <i class="far fa-clock me-1 mr-1"></i> Posted
                                    {{ $announcement->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <button type="button" class="close btn-close opacity-75" data-dismiss="alert"
                                data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" class="d-md-none">&times;</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div><!--/. container-fluid -->


@endsection
