@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Vitrine</a></li>
            @auth
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Espace Gestion</a></li>
            @endauth
            <li class="breadcrumb-item active" aria-current="page">{{ $product->libelle }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="row g-0">
                    <!-- Visuel Produit -->
                    <div class="col-md-5 d-flex align-items-center justify-content-center p-4" style="background-color: #f8fafc; border-right: 1px solid #e2e8f0;">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" 
                             class="img-fluid rounded-3" style="max-height: 320px; object-fit: contain;">
                    </div>

                    <!-- Fiche Technique Détaillée -->
                    <div class="col-md-7">
                        <div class="card-body p-4 p-lg-5 d-flex flex-column h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-category cat-{{ $product->type }}">
                                    {{ ucfirst($product->type) }}
                                </span>
                                @if ($product->stock > 0)
                                    <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> En stock ({{ $product->stock }} unités)
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle-fill me-1"></i> Rupture de stock
                                    </span>
                                @endif
                            </div>

                            <h2 class="fw-bold text-dark mb-2">{{ $product->libelle }}</h2>
                            <div class="fs-3 fw-bold text-dark mb-3">
                                {{ $product->formattedPrice() }}
                            </div>

                            <p class="text-muted mb-4 lead" style="font-size: 0.95rem;">
                                {{ $product->description ?? 'Référence certifiée conforme au catalogue.' }}
                            </p>

                            <!-- Spécifications Techniques -->
                            <div class="rounded-3 p-3 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="fw-bold text-dark mb-3 small text-uppercase" style="letter-spacing: 0.5px;">
                                    Caractéristiques Techniques
                                </h6>
                                <div class="row g-2 small">
                                    @if ($product->marque)
                                        <div class="col-6">
                                            <span class="text-muted d-block">Marque :</span>
                                            <strong class="text-dark">{{ $product->marque }}</strong>
                                        </div>
                                    @endif
                                    @if ($product->garantie)
                                        <div class="col-6">
                                            <span class="text-muted d-block">Garantie :</span>
                                            <strong class="text-dark">{{ $product->garantie }}</strong>
                                        </div>
                                    @endif
                                    @if ($product->taille)
                                        <div class="col-6">
                                            <span class="text-muted d-block">Taille / Format :</span>
                                            <strong class="text-dark">{{ $product->taille }}</strong>
                                        </div>
                                    @endif
                                    @if ($product->unite)
                                        <div class="col-6">
                                            <span class="text-muted d-block">Unité / Conditionnement :</span>
                                            <strong class="text-dark">{{ $product->unite }}</strong>
                                        </div>
                                    @endif
                                    @if ($product->categorie)
                                        <div class="col-6">
                                            <span class="text-muted d-block">Sous-catégorie :</span>
                                            <strong class="text-dark">{{ $product->categorie }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions de navigation (pure consultation de détails) -->
                            <div class="mt-auto pt-3 border-top d-flex align-items-center gap-2">
                                <a href="{{ route('home') }}" class="btn btn-brand btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Retour à la vitrine
                                </a>
                                @auth
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-grid me-1"></i> Retour à l'espace gestion
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
