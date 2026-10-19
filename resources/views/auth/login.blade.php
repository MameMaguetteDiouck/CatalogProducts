@extends('layouts.auth')

@section('content')
<div class="container-fluid p-0 min-vh-100 d-flex flex-column justify-content-center">
    <div class="row g-0 min-vh-100">
        <!-- Panneau Visuel Gauche (Branding & Sécurité) -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative overflow-hidden" 
             style="background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);">
            
            <!-- Cercles décoratifs d'arrière-plan -->
            <div class="position-absolute rounded-circle" 
                 style="width: 480px; height: 480px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(0,0,0,0) 70%); top: -100px; right: -100px; pointer-events: none;"></div>
            <div class="position-absolute rounded-circle" 
                 style="width: 360px; height: 360px; background: radial-gradient(circle, rgba(79, 70, 229, 0.12) 0%, rgba(0,0,0,0) 70%); bottom: -50px; left: -50px; pointer-events: none;"></div>

            <!-- Header du panneau -->
            <div class="position-relative z-1">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-white text-decoration-none">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 shadow" 
                          style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                        <i class="bi bi-box-seam fs-5"></i>
                    </span>
                    <span class="fs-4 fw-bold tracking-tight">Catalog<span style="color: #818cf8;">Pro</span></span>
                </a>
            </div>

            <!-- Contenu central -->
            <div class="position-relative z-1 my-5" style="max-width: 520px;">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-4" 
                     style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); font-size: 0.8rem;">
                    <span class="badge rounded-pill bg-primary" style="font-size: 0.7rem;">SÉCURISÉ</span>
                    <span class="text-white-50">Architecture JWT & Contrôle d'accès RBAC</span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-3" style="line-height: 1.25;">
                    La référence centrale pour vos catalogues produits.
                </h1>
                <p class="text-white-50 lead mb-5" style="font-size: 1.05rem;">
                    Accédez à la console de gestion, suivez les disponibilités de stocks en temps réel et orchestrez vos fiches techniques conformes aux normes du marché.
                </p>

                <!-- Points forts -->
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white bg-opacity-10" style="width: 34px; height: 34px;">
                            <i class="bi bi-shield-lock text-info"></i>
                        </div>
                        <div class="small text-white-50">
                            <strong class="text-white">Authentification par jeton JWT</strong> stocké en cookie sécurisé HttpOnly.
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white bg-opacity-10" style="width: 34px; height: 34px;">
                            <i class="bi bi-person-check text-success"></i>
                        </div>
                        <div class="small text-white-50">
                            <strong class="text-white">Gouvernance stricte</strong> : comptes managés et mots de passe temporaires protégés.
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-white bg-opacity-10" style="width: 34px; height: 34px;">
                            <i class="bi bi-cash-stack text-warning"></i>
                        </div>
                        <div class="small text-white-50">
                            <strong class="text-white">Marché Sénégalais</strong> : tarification intégrée en Franc CFA (FCFA).
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer du panneau -->
            <div class="position-relative z-1 small text-white-50 d-flex justify-content-between align-items-center border-top border-white border-opacity-10 pt-3">
                <span>&copy; {{ date('Y') }} CatalogPro Enterprise.</span>
                <span>Plateforme B2B Sécurisée</span>
            </div>
        </div>

        <!-- Panneau Droit (Formulaire de Connexion) -->
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

            <div class="mx-auto w-100" style="max-width: 440px;">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark mb-1">Connexion à la Console</h3>
                    <p class="text-muted small">Renseignez vos identifiants pour accéder à votre espace de travail.</p>
                </div>

                <!-- Messages Flash -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="bi bi-shield-x me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Formulaire -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- E-mail -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-muted text-uppercase">Adresse e-mail professionnelle</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input id="email" type="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', 'admin@catalog.local') }}" required autocomplete="email" autofocus
                                   placeholder="nom@entreprise.sn">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    <!-- Mot de passe avec toggle visibilité -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-muted text-uppercase">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="password" type="password" class="form-control bg-light border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   name="password" value="Password123!" required autocomplete="current-password"
                                   placeholder="••••••••">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" id="togglePasswordBtn" 
                                    onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    <!-- Se souvenir de moi -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : 'checked' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Mémoriser ma session
                            </label>
                        </div>
                    </div>

                    <!-- Bouton Submit -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-brand py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Accéder à la plateforme
                        </button>
                    </div>

                    <!-- Note d'assistance pour mot de passe oublié sans SMTP -->
                    <div class="card border rounded-3 bg-light p-3 mb-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-info-circle text-primary mt-1"></i>
                            <div class="small text-muted">
                                <strong class="text-dark">Mot de passe oublié ?</strong><br>
                                Conformément à la politique interne, la réinitialisation est assurée par votre administrateur d'équipe. Contactez votre superviseur pour l'émission d'un mot de passe temporaire.
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Comptes pré-configurés de test -->
                <div class="border-top pt-3 text-center">
                    <span class="small text-muted d-block mb-2">Comptes de test disponibles :</span>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <button type="button" class="btn btn-xs btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;" 
                                onclick="fillCredentials('admin@catalog.local', 'Password123!')">
                            <i class="bi bi-shield-check text-primary me-1"></i> Admin
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;" 
                                onclick="fillCredentials('demo@catalog.local', 'Password123!')">
                            <i class="bi bi-person text-secondary me-1"></i> Gestionnaire
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2" style="font-size: 0.75rem;" 
                                onclick="fillCredentials('nouveau@catalog.local', 'Password123!')">
                            <i class="bi bi-key text-warning me-1"></i> Premier accès (Reset)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer minimal -->
            <div class="text-center text-muted small mt-4">
                <span>CatalogPro &copy; {{ date('Y') }} — Solution certifiée multi-secteurs.</span>
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
        icon.classList.add('bi-eye-warning');
        icon.classList.add('bi-eye');
    }
}

function fillCredentials(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
