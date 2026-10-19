@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Espace Gestion</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mon Profil Personnel</li>
        </ol>
    </nav>

    <!-- Messages Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Colonne Gauche : Résumé Profil & Rôle -->
        <div class="col-lg-4">
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden text-center p-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold mx-auto mb-3 shadow-sm" 
                     style="width: 72px; height: 72px; font-size: 1.75rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }}</p>

                <div class="mb-3">
                    <span class="badge {{ $user->role->badgeClass() }} px-3 py-2">
                        {{ $user->roleLabel() }}
                    </span>
                </div>

                <div class="border-top pt-3 text-start small text-muted">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Statut :</span>
                        <span class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>Actif</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Périmètre :</span>
                        <span class="text-dark fw-semibold">
                            {{ $user->isAdmin() ? 'Administration & Équipe' : 'Gestion du catalogue' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Formulaires de modification -->
        <div class="col-lg-8">
            <!-- Formulaire 1 : Informations générales -->
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-person me-2 text-primary"></i>Informations Personnelles
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-semibold text-muted text-uppercase">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold text-muted text-uppercase">Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 text-end pt-2">
                                <button type="submit" class="btn btn-brand btn-sm">
                                    <i class="bi bi-check2-circle me-1"></i> Enregistrer mes Coordonnées
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulaire 2 : Sécurité & Mot de passe -->
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-shield-lock me-2 text-primary"></i>Modifier mon Mot de Passe
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label small fw-semibold text-muted text-uppercase">Mot de passe actuel <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" id="current_password" 
                                       class="form-control @error('current_password') is-invalid @enderror" required placeholder="Votre mot de passe actuel">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label small fw-semibold text-muted text-uppercase">Nouveau mot de passe <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" required minlength="8" placeholder="Minimum 8 caractères">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label small fw-semibold text-muted text-uppercase">Confirmation <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control" required minlength="8" placeholder="Répétez le mot de passe">
                            </div>

                            <div class="col-12 text-end pt-2">
                                <button type="submit" class="btn btn-brand btn-sm">
                                    <i class="bi bi-key me-1"></i> Mettre à jour mon Mot de Passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
