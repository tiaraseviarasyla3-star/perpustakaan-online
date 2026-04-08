<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard') | E-Lib</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f5ff; /* Biru sangat muda */
        }
        
        /* Navbar Styling Senada Landing Page */
        .navbar-user {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-weight: 700;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(30, 58, 138, 0.15);
        }

        .btn-logout-user {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            border-radius: 10px;
            padding: 5px 15px;
            transition: 0.3s;
        }

        .btn-logout-user:hover {
            background: #ef4444; /* Merah saat hover agar tegas */
            border-color: #ef4444;
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-user sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('landing') }}">
            <i class="bi bi-book-half me-2"></i> PERPUSTAKAAN
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                {{-- NOTIFICATION DROPDOWN --}}
                <li class="nav-item dropdown me-2">
                    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ auth()->user()->unreadNotifications->count() }}
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0 overflow-hidden" aria-labelledby="notificationDropdown" style="width: 300px; border-radius: 12px;">
                        <li class="bg-primary p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-white mb-0 fw-bold">Notifikasi</h6>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('notifications.markAsRead') }}" class="text-white-50 small text-decoration-none hover-white">Tandai Baca</a>
                                @endif
                            </div>
                        </li>
                        
                        <div style="max-height: 350px; overflow-y: auto;">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li>
                                    <div class="dropdown-item p-3 border-bottom border-light">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="bi bi-info-circle"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0 small text-dark" style="white-space: normal;">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                <small class="text-muted" style="font-size: 0.7rem;">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-4 text-center">
                                    <i class="bi bi-bell-slash text-muted fs-1 opacity-25 d-block mb-2"></i>
                                    <span class="text-muted small">Tidak ada notifikasi baru</span>
                                </li>
                            @endforelse
                        </div>

                        @if(auth()->user()->notifications->count() > 0)
                            <li>
                                <a class="dropdown-item text-center py-2 small fw-bold text-primary bg-light" href="#">
                                    Lihat Semua Notifikasi
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <style>
                    .hover-white:hover { color: white !important; }
                    #notificationDropdown::after { display: none; } /* Hilangkan panah dropdown */
                </style>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="bi bi-house-door me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}" 
                       href="{{ route('books.index') }}">
                        <i class="bi bi-journal-bookmark me-1"></i> Katalog Buku
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.loans.index') ? 'active' : '' }}" 
                       href="{{ route('user.loans.index') }}">
                        <i class="bi bi-clock-history me-1"></i> Riwayat Pinjam
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <span class="text-white opacity-75 d-none d-lg-block">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-logout-user btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container pb-5">
    {{-- Flash Message dengan Desain Lebih Clean --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="animate__animated animate__fadeIn">
        @yield('content')
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>