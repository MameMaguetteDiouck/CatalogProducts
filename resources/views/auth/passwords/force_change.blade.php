@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Brand -->
            <div class="text-center mb-4">
                <span class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow mb-2" 
                      style="width: 44px; height: 44px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="bi bi-shield-lock fs-5"></i>
                </span>
                <h4 class="fw-bold text-dark mb-1">Sécurisation de votre Compte</h4>
                <p class="text-muted small">Première connexion ou réinitialisation d'accès</p>
            </div>

            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-header bg-warning bg-opacity-10 border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                        <span class="small fw-semibold text-dark">Changement de mot de passe obligatoire</span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                            <span class="small">{{ session('warning') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <p class="text-muted small mb-4">
                        Votre compte <strong>{{ Auth::user()->email }}</strong> est actuellement configuré avec un mot de passe temporaire. Définissez votre mot de passe personnel pour activer votre session.
                    </p>

                    <form action="{{ route('password.first_login.update') }}" method="POST">
                        @csrf

                        <!-- Mot de passe actuel/temporaire -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label small fw-semibold text-muted text-uppercase">
                                Mot de passe temporaire actuel <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                <input type="password" name="current_password" id="current_password" 
                                       class="form-control bg-light border-start-0 @error('current_password') is-invalid @enderror" 
                                       required placeholder="Mot de passe reçu">
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-muted text-uppercase">
                                Nouveau mot de passe personnel <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" 
                                       class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                                       required minlength="8" placeholder="Minimum 8 caractères">
                            </div>
                            <div class="form-text small">Doit comporter au moins 8 caractères.</div>
                            @error('password')
                                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-semibold text-muted text-uppercase">
                                Confirmez le nouveau mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control bg-light border-start-0" 
                                       required minlength="8" placeholder="Répétez le mot de passe">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-brand py-2">
                                <i class="bi bi-shield-check me-1"></i> Valider et Activer mon Compte
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light p-3 text-center border-top">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none small">
                            <i class="bi bi-box-arrow-right me-1"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
