@extends('layouts.auth')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            
            <!-- Logo & En-tête sobre -->
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-white shadow-sm" 
                          style="width: 40px; height: 40px; background: #4f46e5;">
                        <i class="bi bi-box-seam fs-5"></i>
                    </span>
                    <span class="fs-4 fw-bold text-dark">Catalog<span style="color: #4f46e5;">Pro</span></span>
                </a>
                <h1 class="h4 fw-bold text-dark mb-1">Connexion à votre espace</h1>
                <p class="text-muted small mb-0">Entrez vos identifiants pour accéder au catalogue.</p>
            </div>

            <!-- Carte Formulaire -->
            <div class="card border rounded-4 shadow-sm bg-white">
                <div class="card-body p-4 p-sm-5">
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3 small" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3 small" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-3 small" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-secondary">Adresse e-mail</label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="nom@entreprise.sn">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-secondary">Mot de passe</label>
                            <div class="input-group">
                                <input id="password" type="password" 
                                       class="form-control border-end-0 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="••••••••">
                                <button class="btn btn-outline-secondary border-start-0 text-muted" type="button" 
                                        onclick="togglePasswordVisibility()" title="Afficher ou masquer le mot de passe">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mémoriser -->
                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        <!-- Bouton -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-brand py-2 fw-semibold">
                                Se connecter
                            </button>
                        </div>

                        <!-- Aide mot de passe -->
                        <p class="text-center text-muted small mb-0 pt-2 border-top">
                            Mot de passe oublié ? Contactez votre administrateur.
                        </p>
                    </form>
                </div>
            </div>

            <!-- Lien retour vitrine -->
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Retour à la vitrine publique
                </a>
            </div>

        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection
