<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCatalog - Catalogue Produits NoSQL</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light min-vh-100 d-flex flex-column">
    <!-- Navbar supérieure -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-box-seam me-2 text-primary"></i>MyCatalog
            </a>

            <div class="d-flex flex-grow-1 mx-lg-5 my-2 my-lg-0">
                <form class="d-flex w-100" role="search" action="{{ route('products.index') }}" method="GET">
                    <input class="form-control me-2" name="search" type="search" placeholder="Rechercher un produit, une marque..." aria-label="Rechercher" />
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-2">
                @guest
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">
                        <i class="bi bi-person me-1"></i> Connexion
                    </a>
                @endguest
                @auth
                    <a class="btn btn-primary" href="{{ route('products.index') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Bannière Hero -->
    <section class="bg-primary text-white py-5 shadow-sm">
        <div class="container text-center py-3">
            <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">
                Architecture NoSQL • Laravel 11 & MongoDB
            </span>
            <h1 class="display-5 fw-bold mb-3">Catalogue de Produits Dynamique</h1>
            <p class="lead mb-4 mx-auto" style="max-width: 650px;">
                Chaque catégorie embarque ses propres attributs modulaires (garantie, taille, unités) stockés de manière flexible dans des documents MongoDB.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-light text-primary fw-bold px-4 py-2">
                    <i class="bi bi-grid me-1"></i> Explorer le catalogue
                </a>
            </div>
        </div>
    </section>

    <!-- Sections par Catégorie -->
    <main class="container my-5 flex-grow-1">
        @foreach ($categories as $cat)
            @php $products = $productsByCategory[$cat->value] ?? collect(); @endphp
            @if ($products->count() > 0)
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <h4 class="fw-bold mb-0 text-dark">
                            <i class="bi {{ $cat->icon() }} me-2 text-primary"></i>{{ $cat->label() }}
                        </h4>
                        <a href="{{ route('products.index', ['category' => $cat->value]) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Voir plus ({{ App\Models\Product::countForType($cat->value) }}) <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="bg-white p-3 text-center rounded-top position-relative">
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" 
                                             class="img-fluid rounded" style="height: 150px; object-fit: contain;">
                                    </div>
                                    <div class="card-body d-flex flex-column p-3">
                                        <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $product->libelle }}">
                                            {{ $product->libelle }}
                                        </h6>
                                        <p class="text-primary fw-bold fs-5 mb-2">
                                            {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                                        </p>

                                        <!-- Spécificités NoSQL -->
                                        <div class="small text-muted mb-3">
                                            @if ($product->garantie)
                                                <div>Garantie : <span class="fw-bold text-dark">{{ $product->garantie }}</span></div>
                                            @endif
                                            @if ($product->taille)
                                                <div>Taille : <span class="fw-bold text-dark">{{ $product->taille }}</span></div>
                                            @endif
                                            @if ($product->unite)
                                                <div>Unité : <span class="fw-bold text-dark">{{ $product->unite }}</span></div>
                                            @endif
                                            @if ($product->marque)
                                                <div>Marque : <span class="fw-bold text-dark">{{ $product->marque }}</span></div>
                                            @endif
                                        </div>

                                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                            @if ($product->stock > 0)
                                                <span class="badge bg-success-subtle text-success small">En stock</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger small">Rupture</span>
                                            @endif
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
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

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-1 small">Projet Portfolio GitHub — <strong>CatalogProducts</strong></p>
            <p class="text-white-50 small mb-0">Développé sous Laravel 11 & Base Documentaire NoSQL MongoDB</p>
        </div>
    </footer>
</body>
</html>
