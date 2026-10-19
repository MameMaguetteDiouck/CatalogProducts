@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Espace Gestion</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">Équipe & Rôles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifier {{ $user->name }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>Modifier le Collaborateur
                        </h5>
                        <p class="text-muted small mb-0">Ajustez le profil, le rôle ou réinitialisez les accès d'authentification.</p>
                    </div>
                    <span class="badge {{ $user->role->badgeClass() }} px-3 py-2">
                        {{ $user->roleLabel() }}
                    </span>
                </div>

                <div class="card-body p-4 p-lg-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                            <strong class="small">Erreurs de validation :</strong>
                            <ul class="mb-0 mt-2 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nom complet -->
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-semibold text-muted text-uppercase">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required placeholder="Ex : Fatou Diop">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse e-mail -->
                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold text-muted text-uppercase">Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required placeholder="Ex : f.diop@entreprise.sn">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rôle & Permissions -->
                            <div class="col-md-6">
                                <label for="role" class="form-label small fw-semibold text-muted text-uppercase">Rôle & Permissions <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->value }}" {{ old('role', $user->role->value) === $role->value ? 'selected' : '' }}>
                                            {{ $role->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small">
                                    <strong>Administrateur</strong> : accès total + gestion équipe.<br>
                                    <strong>Gestionnaire</strong> : ajout et modification des fiches sans suppression.
                                </div>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nouveau mot de passe (optionnel) -->
                            <div class="col-md-6">
                                <label for="password" class="form-label small fw-semibold text-muted text-uppercase">Nouveau mot de passe</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                       minlength="8" placeholder="Laisser vide pour ne pas modifier">
                                <div class="form-text small">Minimum 8 caractères si renseigné.</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Actions -->
                            <div class="col-12 d-flex justify-content-between align-items-center pt-3 border-top mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-brand btn-sm">
                                    <i class="bi bi-check2-circle me-1"></i> Mettre à jour le Collaborateur
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
