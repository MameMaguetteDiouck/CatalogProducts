@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Nouveau Produit au Catalogue
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('products.partials.form', ['product' => new \App\Models\Product()])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
