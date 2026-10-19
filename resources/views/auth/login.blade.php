@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <!-- Logo & Titre -->
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center justify-content-center text-white rounded-3 shadow-sm mb-3 text-decoration-none" 
                   style="width: 44px; height: 44px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                    <i class="bi bi-box-seam fs-5"></i>
                </a>
                <h4 class="fw-bold text-dark mb-1">CatalogPro</h4>
                <p class="text-muted small">Connexion à la console d'administration</p>
            </div>

            <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-muted text-uppercase">Adresse e-mail</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', 'admin@catalog.local') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1 small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-muted text-uppercase">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                                       name="password" value="Password123!" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block mt-1 small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : 'checked' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-brand">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Retour à la vitrine
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light border-top p-3 text-center small text-muted">
                    <span>Identifiants démo : <code>admin@catalog.local</code> / <code>Password123!</code></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
