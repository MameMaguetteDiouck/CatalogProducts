@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <!-- Messages d'Alerte Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- En-tête & KPIs -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Gestion du Catalogue</h2>
            <p class="text-muted mb-0 small">
                Consultez, filtrez et administrez l'ensemble des références de la plateforme.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-eye me-1"></i> Voir la vitrine
            </a>
            <a href="{{ route('products.create', ['type' => $selectedCategory]) }}" class="btn btn-brand btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Nouveau Produit
            </a>
        </div>
    </div>

    <!-- KPIs Synthétiques -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', array_filter(['category' => $selectedCategory, 'search' => $searchTerm])) }}" 
               class="text-decoration-none d-block h-100">
                <div class="kpi-card {{ empty($stockStatus) ? 'border-primary shadow-sm' : '' }}">
                    <div class="text-muted small fw-semibold text-uppercase">Total Références</div>
                    <div class="fs-3 fw-bold text-dark mt-1">{{ $totalCount }}</div>
                    <div class="text-muted small mt-1"><i class="bi bi-layers me-1"></i>Toutes disponibilités</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', array_filter(['category' => $selectedCategory, 'search' => $searchTerm, 'stock_status' => 'in_stock'])) }}" 
               class="text-decoration-none d-block h-100">
                <div class="kpi-card {{ $stockStatus === 'in_stock' ? 'border-success shadow-sm' : '' }}">
                    <div class="text-muted small fw-semibold text-uppercase">En Stock</div>
                    <div class="fs-3 fw-bold text-success mt-1">{{ $inStockCount }}</div>
                    <div class="text-muted small mt-1"><i class="bi bi-check2-circle text-success me-1"></i>Prêts à l'expédition</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', array_filter(['category' => $selectedCategory, 'search' => $searchTerm, 'stock_status' => 'out_of_stock'])) }}" 
               class="text-decoration-none d-block h-100">
                <div class="kpi-card {{ $stockStatus === 'out_of_stock' ? 'border-danger shadow-sm' : '' }}">
                    <div class="text-muted small fw-semibold text-uppercase">Ruptures</div>
                    <div class="fs-3 fw-bold text-danger mt-1">{{ $outOfStockCount }}</div>
                    <div class="text-muted small mt-1"><i class="bi bi-exclamation-circle text-danger me-1"></i>À réapprovisionner</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card">
                <div class="text-muted small fw-semibold text-uppercase">Filtre Actif</div>
                <div class="fs-5 fw-bold text-dark mt-1 text-truncate">
                    @if ($stockStatus === 'out_of_stock')
                        <span class="text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i>Ruptures</span>
                    @elseif ($stockStatus === 'in_stock')
                        <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>En stock</span>
                    @else
                        {{ $selectedCategory ? ucfirst($selectedCategory) : 'Tous les rayons' }}
                    @endif
                </div>
                <div class="text-muted small mt-1">{{ $products->total() }} résultat{{ $products->total() > 1 ? 's' : '' }}</div>
            </div>
        </div>
    </div>

    <!-- Barre d'actions & Filtres -->
    <div class="card border rounded-3 p-3 shadow-sm bg-white mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <!-- Onglets Catégories -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products.index', array_filter(['search' => $searchTerm, 'stock_status' => $stockStatus])) }}" 
                   class="filter-pill {{ empty($selectedCategory) ? 'active' : '' }}">
                    Tous <span class="pill-count">{{ $totalCount }}</span>
                </a>
                @foreach ($categories as $category)
                    @php $count = $categoryCounts[$category->value]['count'] ?? 0; @endphp
                    <a href="{{ route('products.index', array_filter(['category' => $category->value, 'search' => $searchTerm, 'stock_status' => $stockStatus])) }}" 
                       class="filter-pill {{ $selectedCategory === $category->value ? 'active' : '' }}">
                        <i class="bi {{ $category->icon() }}"></i> {{ $category->label() }}
                        <span class="pill-count">{{ $count }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Recherche -->
            <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
                @if ($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                @if ($stockStatus)
                    <input type="hidden" name="stock_status" value="{{ $stockStatus }}">
                @endif
                <div class="input-group input-group-sm" style="min-width: 260px;">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" name="search" class="form-control bg-light border-start-0" 
                           placeholder="Rechercher par référence, marque..." value="{{ $searchTerm ?? '' }}">
                </div>
                <button type="submit" class="btn btn-sm btn-brand">Filtrer</button>
                @if ($searchTerm || $selectedCategory || $stockStatus)
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary" title="Réinitialiser tous les filtres">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Grille des Produits -->
    @if ($products->count() > 0)
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
                                    <span class="small fw-semibold text-danger">Rupture</span>
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <div class="fs-5 fw-bold text-dark">
                                    {{ $product->formattedPrice() }}
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary" title="Consulter">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @can('delete-product')
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                              onsubmit="return confirm('Confirmez-vous la suppression de ce produit ?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @else
        <div class="card border rounded-4 text-center py-5 shadow-sm bg-white">
            <div class="card-body">
                <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold text-dark">Aucune référence trouvée</h5>
                <p class="text-muted small mb-4">
                    Aucun produit ne correspond à votre recherche ou à ce rayon.
                </p>
                <a href="{{ route('products.create', ['type' => $selectedCategory]) }}" class="btn btn-brand btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter une référence
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
