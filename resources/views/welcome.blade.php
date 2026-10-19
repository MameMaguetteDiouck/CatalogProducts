<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CatalogPro — Plateforme Centrale de Produits</title>
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Supérieure Moderne -->
    <header class="catalog-navbar sticky-top py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <a class="navbar-brand d-flex align-items-center gap-2 m-0 text-decoration-none" href="{{ route('home') }}">
                    <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow-sm" 
                          style="width: 36px; height: 36px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                        <i class="bi bi-box-seam"></i>
                    </span>
                    <span class="fs-5 fw-bold text-dark">Catalog<span style="color: #4f46e5;">Pro</span></span>
                </a>

                <nav class="d-none d-md-flex align-items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link active">Vitrine Produits</a>
                    <a href="{{ route('products.index') }}" class="nav-link">Espace Gestion</a>
                </nav>
            </div>

            <!-- Barre de recherche rapide -->
            <div class="d-none d-lg-block" style="width: 380px;">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" name="search" class="form-control bg-light border-start-0" 
                               placeholder="Rechercher une référence, marque, désignation..." aria-label="Rechercher">
                    </div>
                </form>
            </div>

            <!-- Authentification & Actions -->
            <div class="d-flex align-items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-brand btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                    </a>
                @endguest
                @auth
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1 text-primary"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
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

    <!-- Section Hero -->
    <section class="py-4 py-lg-5 bg-white border-bottom">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="text-uppercase fw-bold small" style="color: #4f46e5; letter-spacing: 1.5px; font-size: 0.75rem;">
                        PLATEFORME CENTRALE DE CATALOGUE
                    </span>
                    <h1 class="display-6 fw-bold text-dark mt-2 mb-3">
                        Explorez notre sélection multi-secteurs
                    </h1>
                    <p class="text-muted lead mb-4" style="max-width: 640px; font-size: 1.05rem;">
                        Accédez aux fiches techniques, disponibilités de stock et conditionnements de nos 5 univers professionnels.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-brand">
                            <i class="bi bi-grid me-1"></i> Voir tout le catalogue
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-brand-outline">
                            <i class="bi bi-plus-lg me-1"></i> Ajouter un produit
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border rounded-4 p-3 shadow-sm bg-light">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <div class="fs-4 fw-bold text-dark">{{ App\Models\Product::count() }}</div>
                                <div class="small text-muted">Références actives</div>
                            </div>
                            <div class="text-end">
                                <div class="fs-4 fw-bold text-success">100%</div>
                                <div class="small text-muted">Disponibilité</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small text-muted">
                            <span><i class="bi bi-shield-check text-primary me-1"></i> Fiches certifiées</span>
                            <span><i class="bi bi-arrow-repeat text-primary me-1"></i> Temps réel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu Principal Vitrine -->
    <main class="container py-5 flex-grow-1">
        <!-- Sélecteur d'Univers / Filtres rapides -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4 pb-2">
            <a href="#tous" class="filter-pill active" data-filter="all">
                Tous <span class="pill-count">{{ App\Models\Product::count() }}</span>
            </a>
            @foreach ($categories as $cat)
                @php 
                    $catCount = App\Models\Product::countForType($cat->value);
                @endphp
                <a href="#{{ $cat->value }}" class="filter-pill" data-filter="{{ $cat->value }}">
                    <i class="bi {{ $cat->icon() }}"></i> {{ $cat->label() }}
                    <span class="pill-count">{{ $catCount }}</span>
                </a>
            @endforeach
        </div>

        <!-- Grille des Produits par Catégorie -->
        @foreach ($categories as $cat)
            @php $products = $productsByCategory[$cat->value] ?? collect(); @endphp
            @if ($products->count() > 0)
                <div class="category-block mb-5" id="section-{{ $cat->value }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <h4 class="fw-bold mb-0 text-dark">{{ $cat->label() }}</h4>
                            <span class="badge-category cat-{{ $cat->value }} ms-2">
                                <i class="bi {{ $cat->icon() }}"></i> {{ $cat->label() }}
                            </span>
                        </div>
                        <a href="{{ route('products.index', ['category' => $cat->value]) }}" class="btn btn-sm btn-link text-decoration-none fw-semibold" style="color: #4f46e5;">
                            Consulter le rayon ({{ App\Models\Product::countForType($cat->value) }}) <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-card h-100">
                                    <div class="product-card-thumb">
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}">
                                        <span class="badge-category cat-{{ $product->type }} position-absolute top-0 start-0 m-3">
                                            {{ $cat->label() }}
                                        </span>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $product->libelle }}">
                                            {{ $product->libelle }}
                                        </h6>
                                        <p class="text-muted small text-truncate mb-2">
                                            {{ $product->description ?? 'Référence certifiée conforme au catalogue.' }}
                                        </p>

                                        <!-- Attributs spécifiques dynamiques -->
                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            @if ($product->garantie)
                                                <span class="spec-tag"><i class="bi bi-shield-check me-1"></i>{{ $product->garantie }}</span>
                                            @endif
                                            @if ($product->marque)
                                                <span class="spec-tag"><i class="bi bi-tag me-1"></i>{{ $product->marque }}</span>
                                            @endif
                                            @if ($product->taille)
                                                <span class="spec-tag"><i class="bi bi-aspect-ratio me-1"></i>{{ $product->taille }}</span>
                                            @endif
                                            @if ($product->unite)
                                                <span class="spec-tag"><i class="bi bi-box me-1"></i>{{ $product->quantite ? $product->quantite . ' ' : '' }}{{ $product->unite }}</span>
                                            @endif
                                            @if ($product->categorie)
                                                <span class="spec-tag">{{ $product->categorie }}</span>
                                            @endif
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            @if ($product->stock > 0)
                                                <span class="stock-dot in-stock"></span>
                                                <span class="small fw-semibold text-success">En stock ({{ $product->stock }})</span>
                                            @else
                                                <span class="stock-dot out-of-stock"></span>
                                                <span class="small fw-semibold text-danger">Rupture de stock</span>
                                            @endif
                                        </div>

                                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fs-5 fw-bold text-dark mb-0">
                                                    {{ number_format($product->prix, 2, ',', ' ') }} €
                                                </div>
                                            </div>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-brand btn-sm">
                                                Détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </main>

    <!-- Footer Corporate Professionnel -->
    <footer class="catalog-footer py-4 mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center text-white rounded-2" 
                      style="width: 24px; height: 24px; background: #4f46e5; font-size: 0.75rem;">
                    <i class="bi bi-box-seam"></i>
                </span>
                <span class="fw-bold text-dark">CatalogPro</span>
                <span class="text-muted ms-2">&copy; {{ date('Y') }} Tous droits réservés.</span>
            </div>
            <div class="d-flex align-items-center gap-3 small">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none">Vitrine</a>
                <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Catalogue</a>
                <a href="{{ route('products.create') }}" class="text-muted text-decoration-none">Nouveau produit</a>
            </div>
        </div>
    </footer>
</body>
</html>
