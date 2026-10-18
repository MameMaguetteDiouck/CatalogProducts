@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="row g-0">
                    <div class="col-md-5 d-flex align-items-center justify-content-center bg-light p-3">
                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" class="img-fluid rounded shadow-sm" style="max-height: 280px; object-fit: contain;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary text-uppercase">{{ $product->type }}</span>
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">En stock ({{ $product->stock }})</span>
                                @else
                                    <span class="badge bg-danger">Rupture de stock</span>
                                @endif
                            </div>

                            <h4 class="card-title fw-bold text-dark mb-2">{{ $product->libelle }}</h4>
                            <h3 class="text-primary fw-bold mb-3">{{ number_format($product->prix, 0, ',', ' ') }} FCFA</h3>

                            <p class="text-muted mb-4">{{ $product->description }}</p>

                            <!-- Attributs spécifiques NoSQL -->
                            <div class="bg-light p-3 rounded mb-4">
                                <h6 class="fw-bold text-secondary mb-2">Caractéristiques NoSQL :</h6>
                                <ul class="list-unstyled mb-0 small">
                                    @if ($product->garantie)
                                        <li><strong>Garantie :</strong> {{ $product->garantie }}</li>
                                    @endif
                                    @if ($product->marque)
                                        <li><strong>Marque :</strong> {{ $product->marque }}</li>
                                    @endif
                                    @if ($product->taille)
                                        <li><strong>Taille :</strong> {{ $product->taille }}</li>
                                    @endif
                                    @if ($product->unite)
                                        <li><strong>Unité :</strong> {{ $product->unite }}</li>
                                    @endif
                                    @if ($product->quantite)
                                        <li><strong>Quantité :</strong> {{ $product->quantite }}</li>
                                    @endif
                                    @if ($product->categorie)
                                        <li><strong>Sous-catégorie :</strong> {{ $product->categorie }}</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning text-dark btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Modifier
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash me-1"></i> Supprimer
                                    </button>
                                </form>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                                    Retour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
