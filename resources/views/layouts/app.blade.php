<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CatalogPro') }} — Gestion du Catalogue</title>

    <!-- Polices & Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Principale -->
    <header class="catalog-navbar sticky-top py-2">
        <div class="container-fluid px-lg-5 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <a class="navbar-brand d-flex align-items-center gap-2 m-0 text-decoration-none" href="{{ route('products.index') }}">
                    <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
                          style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                        <i class="bi bi-box-seam"></i>
                    </span>
                    <span class="fs-5 fw-bold text-dark">Catalog<span style="color: #4f46e5;">Pro</span></span>
                </a>

                <nav class="d-none d-md-flex align-items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-shop me-1"></i> Vitrine
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="bi bi-grid me-1"></i> Catalogue Produits
                    </a>
                    <a href="{{ route('products.create') }}" class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle me-1"></i> Nouveau Produit
                    </a>
                </nav>
            </div>

            <!-- Espace Utilisateur -->
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
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="px-3 py-1 text-muted small border-bottom">
                                Connecté en tant que<br><strong>{{ Auth::user()->email }}</strong>
                            </li>
                            <li><a class="dropdown-item py-2" href="{{ route('products.index') }}"><i class="bi bi-grid me-2"></i>Gestion des produits</a></li>
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
            <div class="text-muted">
                Statut système : <span class="badge bg-success-subtle text-success">Opérationnel</span>
            </div>
        </div>
    </footer>

    @yield('insertJS')
</body>
</html>
