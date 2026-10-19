@extends('layouts.app')

@section('content')
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
                        <a href="#catalogue" class="btn btn-brand">
                            <i class="bi bi-grid me-1"></i> Explorer le catalogue
                        </a>
                        @auth
                            <a href="{{ route('products.index') }}" class="btn btn-brand-outline">
                                <i class="bi bi-speedometer2 me-1"></i> Espace Gestion
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border rounded-4 p-3 shadow-sm bg-light">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div>
                                <div class="fs-4 fw-bold text-dark">{{ $totalCount }}</div>
                                <div class="small text-muted">Références actives</div>
                            </div>
                            <div class="text-end">
                                <div class="fs-4 fw-bold text-success">{{ $availabilityRate }}%</div>
                                <div class="small text-muted">Disponibilité</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small text-muted">
                            <span><i class="bi bi-shield-check text-primary me-1"></i> Fiches certifiées</span>
                            <span><i class="bi bi-arrow-repeat text-primary me-1"></i> Données en direct</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu Principal Vitrine -->
    <div class="container py-5 flex-grow-1" id="catalogue">
        <!-- Filtres rapides par Univers -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4 pb-2">
            <a href="{{ route('home') }}" class="filter-pill {{ empty($selectedCategory) ? 'active' : '' }}">
                Tous <span class="pill-count">{{ App\Models\Product::count() }}</span>
            </a>
            @foreach ($categories as $cat)
                @php 
                    $catCount = App\Models\Product::countForType($cat->value);
                @endphp
                <a href="{{ route('home', array_filter(['category' => $cat->value, 'search' => $searchTerm])) }}" 
                   class="filter-pill {{ $selectedCategory === $cat->value ? 'active' : '' }}">
                    <i class="bi {{ $cat->icon() }}"></i> {{ $cat->label() }}
                    <span class="pill-count">{{ $catCount }}</span>
                </a>
            @endforeach

            @if ($searchTerm || $selectedCategory)
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                    <i class="bi bi-x-circle me-1"></i> Réinitialiser les filtres
                </a>
            @endif
        </div>

        <!-- Grille des Produits par Catégorie -->
        @php $hasAny = false; @endphp
        @foreach ($categories as $cat)
            @php $products = $productsByCategory[$cat->value] ?? collect(); @endphp
            @if ($products->count() > 0)
                @php $hasAny = true; @endphp
                <div class="category-block mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <h4 class="fw-bold mb-0 text-dark">{{ $cat->label() }}</h4>
                            <span class="badge-category cat-{{ $cat->value }} ms-2">
                                <i class="bi {{ $cat->icon() }}"></i> {{ $cat->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="product-card h-100">
                                    <div class="product-card-thumb">
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}">
                                        <span class="badge-category cat-{{ $product->type }} position-absolute top-0 start-0 m-3">
                                            {{ ucfirst($product->type) }}
                                        </span>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <h6 class="fw-bold text-dark text-truncate mb-1" title="{{ $product->libelle }}">
                                            {{ $product->libelle }}
                                        </h6>
                                        <p class="text-muted small text-truncate mb-2">
                                            {{ $product->description ?? 'Référence certifiée conforme au catalogue.' }}
                                        </p>

                                        <!-- Attributs spécifiques -->
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
                                            <div class="fs-5 fw-bold text-dark">
                                                {{ $product->formattedPrice() }}
                                            </div>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-brand btn-sm">
                                                <i class="bi bi-eye me-1"></i> Détails
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

        @if (!$hasAny)
            <div class="card border rounded-4 text-center py-5 shadow-sm bg-white">
                <div class="card-body">
                    <i class="bi bi-search display-4 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Aucun produit ne correspond à votre recherche</h5>
                    <p class="text-muted small mb-4">
                        Modifiez vos critères de recherche ou explorez un autre univers de produits.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-brand btn-sm">
                        Voir tout le catalogue
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
