<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background: #0f172a; /* Navy Dark */
            min-height: 100vh;
            color: white;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background: #3b82f6; /* Blue Accent */
            color: white;
        }

        .sidebar-brand {
            padding: 25px 20px;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 1px;
            color: #3b82f6;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        /* Content Area */
        .main-content {
            margin-left: 16.66667%; /* Offset for col-md-2 */
            padding: 0;
        }

        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border-bottom: 1px solid #e2e8f0;
        }

        .content-body {
            padding: 30px;
        }

        .card-admin {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar { position: relative; min-height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar d-none d-md-block">
            <div class="sidebar-brand d-flex align-items-center">
                <i class="bi bi-shield-lock-fill me-2"></i> ADMIN HUB
            </div>
            
            <div class="p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.books.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                            <i class="bi bi-book me-2"></i> Data Buku
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags me-2"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.loans.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
                            <i class="bi bi-cart-check me-2"></i> Peminjaman
                        </a>
                    </li>

                    <li class="nav-item">
                            <a href="{{ route('admin.loans.report') }}" class="nav-link {{ request()->routeIs('admin.loans.report') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-bar-graph me-2"></i>
                                <span>Laporan </span>
                            </a>
                        </li>

                    <hr class="text-secondary opacity-25">

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-logout w-100 text-start px-3 py-2 rounded-3">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-md-10 main-content">
            
            {{-- Top Navbar --}}
<nav class="top-navbar d-flex justify-content-between align-items-center">
    <h5 class="m-0 fw-bold text-dark">@yield('title')</h5>
    
    <div class="d-flex align-items-center gap-3">
        
        {{-- NOTIFICATION DROPDOWN --}}
        <div class="dropdown me-2">
            <a class="text-decoration-none position-relative" href="#" id="notifAdmin" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-5 text-secondary"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.25em 0.4em;">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0 overflow-hidden mt-3" aria-labelledby="notifAdmin" style="width: 300px; border-radius: 12px;">
                <li class="p-3 border-bottom bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold small">Notifikasi Admin</h6>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.markAsRead') }}" class="text-primary small text-decoration-none" style="font-size: 0.7rem;">Tandai Baca</a>
                        @endif
                    </div>
                </li>
                
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <li>
                            <div class="dropdown-item p-3 border-bottom">
                                <p class="mb-1 small text-dark" style="white-space: normal; line-height: 1.4;">
                                    {{ $notification->data['message'] }}
                                </p>
                                <small class="text-muted" style="font-size: 0.65rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-center">
                            <span class="text-muted small">Tidak ada pengajuan baru</span>
                        </li>
                    @endforelse
                </div>
            </ul>
        </div>

        <div class="vr opacity-25" style="height: 20px;"></div>

        {{-- PROFIL --}}
        <div class="d-flex align-items-center gap-2">
            <div class="text-end d-none d-sm-block">
                <p class="m-0 small fw-bold text-dark">Admin</p>
                <p class="m-0 text-muted" style="font-size: 0.7rem;">Administrator</p>
            </div>
            <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="rounded-circle border" width="35" alt="profile">
        </div>
    </div>
</nav>

            {{-- Body Content --}}
            <div class="content-body">
                
                {{-- Flash Message --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="animate__animated animate__fadeIn">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>