<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CatalogPro') }}</title>

    <!-- Polices & Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Principale -->
    <header class="catalog-navbar sticky-top py-2">
        <div class="container-fluid px-3 px-lg-5 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 gap-md-4">
                <!-- Bouton Menu Mobile (Offcanvas) -->
                <button class="btn btn-sm btn-light border d-md-none text-muted p-1 px-2" type="button" 
                        data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-controls="mobileNavDrawer" aria-label="Menu principal">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <a class="navbar-brand d-flex align-items-center gap-2 m-0 text-decoration-none" href="{{ route('home') }}">
                    <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
                          style="width: 34px; height: 34px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                        <i class="bi bi-box-seam"></i>
                    </span>
                    <span class="fs-5 fw-bold text-dark">Catalog<span style="color: #4f46e5;">Pro</span></span>
                </a>

                <!-- Menu de navigation Desktop : visible UNIQUEMENT si l'utilisateur est connecté -->
                @auth
                    <nav class="d-none d-md-flex align-items-center gap-1">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="bi bi-shop me-1"></i> Vitrine
                        </a>
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                            <i class="bi bi-grid me-1"></i> Espace Gestion
                        </a>
                        @can('manage-users')
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people me-1"></i> Équipe & Rôles
                            </a>
                        @endcan
                    </nav>
                @endauth
            </div>

            <!-- Barre de recherche rapide de la vitrine (Desktop) -->
            @if (request()->routeIs('home'))
                <div class="d-none d-lg-block" style="width: 340px;">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="search" name="search" class="form-control bg-light border-start-0" 
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher une référence..." aria-label="Rechercher">
                        </div>
                    </form>
                </div>
            @endif

            <!-- Espace Utilisateur & Connexion -->
            <div class="d-flex align-items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-brand btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                    </a>
                @endguest
                @auth
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle fw-semibold d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="px-3 py-2 text-muted small border-bottom">
                                <div>Connecté en tant que</div>
                                <div class="fw-bold text-dark text-truncate">{{ Auth::user()->email }}</div>
                                <div class="mt-1">
                                    <span class="badge {{ Auth::user()->role->badgeClass() }}">{{ Auth::user()->roleLabel() }}</span>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2" href="{{ route('products.index') }}"><i class="bi bi-grid me-2"></i>Espace Gestion</a></li>
                            @can('manage-users')
                                <li><a class="dropdown-item py-2" href="{{ route('users.index') }}"><i class="bi bi-people me-2"></i>Équipe & Rôles</a></li>
                            @endcan
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i>Mon Profil</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('home') }}"><i class="bi bi-shop me-2"></i>Voir la vitrine</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Offcanvas Tiroir Mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavDrawer" aria-labelledby="mobileNavDrawerLabel">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center gap-2" id="mobileNavDrawerLabel">
                <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
                      style="width: 32px; height: 32px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                    <i class="bi bi-box-seam"></i>
                </span>
                <span class="fs-5 fw-bold text-dark">Catalog<span style="color: #4f46e5;">Pro</span></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('home') }}" class="nav-link px-3 py-2 rounded-3 {{ request()->routeIs('home') ? 'bg-primary-subtle text-primary fw-bold' : 'text-dark' }}">
                    <i class="bi bi-shop me-2"></i> Vitrine publique
                </a>
                @auth
                    <a href="{{ route('products.index') }}" class="nav-link px-3 py-2 rounded-3 {{ request()->routeIs('products.index') ? 'bg-primary-subtle text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-grid me-2"></i> Espace Gestion
                    </a>
                    @can('manage-users')
                        <a href="{{ route('users.index') }}" class="nav-link px-3 py-2 rounded-3 {{ request()->routeIs('users.*') ? 'bg-primary-subtle text-primary fw-bold' : 'text-dark' }}">
                            <i class="bi bi-people me-2"></i> Équipe & Rôles
                        </a>
                    @endcan
                    <a href="{{ route('profile.edit') }}" class="nav-link px-3 py-2 rounded-3 {{ request()->routeIs('profile.*') ? 'bg-primary-subtle text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-gear me-2"></i> Mon Profil
                    </a>
                @endauth
            </div>
            @auth
                <div class="pt-3 border-top">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold" style="width: 36px; height: 36px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <div class="overflow-hidden">
                            <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name }}</div>
                            <div class="text-muted small text-truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-top">
                    <a href="{{ route('login') }}" class="btn btn-brand btn-sm w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Conteneur Principal -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="catalog-footer py-3 mt-auto">
        <div class="container-fluid px-lg-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small">
            <div>
                <span class="fw-semibold text-dark">CatalogPro</span> &copy; {{ date('Y') }} — Plateforme Centrale de Produits.
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none">Vitrine</a>
                @auth
                    <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Espace Gestion</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none">Connexion</a>
                @endguest
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('insertJS')
</body>
</html>
