@extends('layouts.auth')

@section('content')
<div class="container-fluid p-0 min-vh-100 d-flex flex-column justify-content-center">
    <div class="row g-0 min-vh-100">
        <!-- Panneau Visuel Gauche : Présentation du Projet -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 text-white" 
             style="background: linear-gradient(160deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);">
            
            <!-- Logo Marque -->
            <div>
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-white text-decoration-none">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 shadow" 
                          style="width: 40px; height: 40px; background: #4f46e5;">
                        <i class="bi bi-box-seam fs-5"></i>
                    </span>
                    <span class="fs-4 fw-bold tracking-tight">Catalog<span style="color: #818cf8;">Pro</span></span>
                </a>
            </div>

            <!-- Présentation du Projet -->
            <div style="max-width: 520px;">
                <h1 class="display-6 fw-bold text-white mb-3" style="line-height: 1.25;">
                    Plateforme centrale de gestion et de diffusion de catalogues produits
                </h1>

                <p class="text-white-50 lead mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                    CatalogPro unifie la gestion de vos gammes commerciales et de vos stocks à travers cinq secteurs d'activité : Agroalimentaire, BTP & Matériaux, Textile, Cosmétique et Équipement.
                </p>

                <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                    Conçu pour les équipes commerciales et logistiques, l'outil permet d'administrer les fiches techniques certifiées, d'actualiser les disponibilités en temps réel et d'harmoniser les tarifications en Franc CFA.
                </p>

                <!-- Points clés fonctionnels -->
                <div class="d-flex flex-column gap-3 pt-3 border-top border-white border-opacity-10 text-white-50 small">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check2 text-primary fs-5 mt-n1"></i>
                        <div>
                            <strong class="text-white">Centralisation multi-secteurs :</strong> gestion des spécificités techniques (garanties, dimensions, conditionnements et marques).
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check2 text-primary fs-5 mt-n1"></i>
                        <div>
                            <strong class="text-white">Suivi des disponibilités :</strong> visibilité directe sur les niveaux de stock par référence et alertes de rupture.
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check2 text-primary fs-5 mt-n1"></i>
                        <div>
                            <strong class="text-white">Gouvernance d'accès :</strong> séparation stricte des rôles entre administrateurs et gestionnaires de catalogue.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer gauche -->
            <div class="small text-white-50 border-top border-white border-opacity-10 pt-3">
                &copy; {{ date('Y') }} CatalogPro. Solution de gestion de catalogue d'entreprise.
            </div>
        </div>

        <!-- Panneau Droit : Formulaire de Connexion -->
        <div class="col-lg-6 d-flex flex-column justify-content-between p-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-lg-none">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-dark text-decoration-none">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary text-white" style="width: 32px; height: 32px;">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <span class="fw-bold fs-5">CatalogPro</span>
                    </a>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la vitrine
                    </a>
                </div>
            </div>

            <div class="mx-auto w-100" style="max-width: 400px;">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Connexion à votre espace</h3>
                    <p class="text-muted small">Entrez vos identifiants professionnels pour vous connecter.</p>
                </div>

                <!-- Messages Flash -->
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

                    <!-- Bouton Submit -->
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

            <!-- Footer droit -->
            <div class="text-center text-muted small mt-4">
                <span>CatalogPro &copy; {{ date('Y') }}</span>
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
