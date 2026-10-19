@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Vitrine</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Catalogue</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier {{ $product->libelle }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Modifier la Fiche : {{ $product->libelle }}
                        </h5>
                        <p class="text-muted small mb-0">Mettez à jour les prix, stocks et caractéristiques de cette référence.</p>
                    </div>
                </div>
                <div class="card-body p-4 p-lg-5">
                    @include('products.partials.form', ['product' => $product])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
