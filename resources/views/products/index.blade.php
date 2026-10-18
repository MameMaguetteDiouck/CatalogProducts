@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Messages Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- En-tête & Barre d'outils -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Catalogue Produits</h3>
            <p class="text-muted mb-0 small">
                Gestion des collections NoSQL ({{ $totalCount }} produit{{ $totalCount > 1 ? 's' : '' }} au total)
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.create', ['type' => $selectedCategory]) }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Nouveau Produit
            </a>
        </div>
    </div>

    <!-- Filtres par catégorie (Onglets NoSQL) -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('products.index', array_filter(['search' => $searchTerm])) }}" 
           class="btn btn-sm {{ empty($selectedCategory) ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill">
            Tous les produits ({{ $totalCount }})
        </a>
        @foreach ($categories as $category)
            @php $count = $categoryCounts[$category->value]['count'] ?? 0; @endphp
            <a href="{{ route('products.index', array_filter(['category' => $category->value, 'search' => $searchTerm])) }}" 
               class="btn btn-sm {{ $selectedCategory === $category->value ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill">
                {{ $category->label() }} ({{ $count }})
            </a>
        @endforeach
    </div>

    <!-- Barre de recherche -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('products.index') }}" method="GET" class="row g-2">
                @if ($selectedCategory)
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="search" name="search" class="form-control border-start-0" 
                               placeholder="Rechercher par libellé, description, marque..." 
                               value="{{ $searchTerm ?? '' }}">
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    @if ($searchTerm || $selectedCategory)
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary" title="Réinitialiser">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Grille des produits -->
    @if ($products->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                        <div class="position-relative bg-light text-center p-2 rounded-top">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" 
                                 class="card-img-top rounded" style="height: 160px; object-fit: contain;">
                            <span class="position-absolute top-0 start-0 m-2 badge bg-primary text-uppercase small">
                                {{ $product->type }}
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="card-title fw-bold text-dark text-truncate mb-1" title="{{ $product->libelle }}">
                                {{ $product->libelle }}
                            </h6>
                            <p class="text-primary fw-bold fs-5 mb-2">
                                {{ number_format($product->prix, 0, ',', ' ') }} FCFA
                            </p>

                            <!-- Attributs NoSQL spécifiques sous forme de badges -->
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @if ($product->garantie)
                                    <span class="badge bg-info text-dark small">Garantie: {{ $product->garantie }}</span>
                                @endif
                                @if ($product->marque)
                                    <span class="badge bg-secondary small">{{ $product->marque }}</span>
                                @endif
                                @if ($product->taille)
                                    <span class="badge bg-warning text-dark small">Taille: {{ $product->taille }}</span>
                                @endif
                                @if ($product->unite)
                                    <span class="badge bg-light text-dark border small">{{ $product->unite }}</span>
                                @endif
                            </div>

                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                @if ($product->stock > 0)
                                    <span class="text-success small fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i>En stock ({{ $product->stock }})
                                    </span>
                                @else
                                    <span class="text-danger small fw-bold">
                                        <i class="bi bi-x-circle-fill me-1"></i>Rupture
                                    </span>
                                @endif

                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                          onsubmit="return confirm('Supprimer ce produit ?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
        <!-- État vide -->
        <div class="card shadow-sm border-0 text-center py-5">
            <div class="card-body">
                <i class="bi bi-box-seam display-3 text-muted mb-3 d-block"></i>
                <h5 class="fw-bold">Aucun produit trouvé</h5>
                <p class="text-muted small mb-4">
                    Aucun élément ne correspond à vos critères de recherche ou à cette catégorie.
                </p>
                <a href="{{ route('products.create', ['type' => $selectedCategory]) }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un premier produit
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
