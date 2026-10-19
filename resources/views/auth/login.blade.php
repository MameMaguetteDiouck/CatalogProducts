@extends('layouts.auth')

@section('content')
<div class="container-fluid p-0 min-vh-100 d-flex flex-column justify-content-center">
    <div class="row g-0 min-vh-100">
        <!-- Panneau Visuel Gauche (Showcase Attrayant & Immersion Produit) -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative overflow-hidden" 
             style="background: radial-gradient(circle at 15% 20%, rgba(99, 102, 241, 0.28) 0%, transparent 45%), radial-gradient(circle at 85% 75%, rgba(147, 51, 234, 0.22) 0%, transparent 50%), linear-gradient(150deg, #090d16 0%, #0f172a 40%, #1e1b4b 100%);">
            
            <!-- Éléments d'ambiance géométriques -->
            <div class="position-absolute rounded-circle" 
                 style="width: 500px; height: 500px; background: radial-gradient(circle, rgba(79, 70, 229, 0.12) 0%, rgba(0,0,0,0) 70%); top: -120px; right: -120px; pointer-events: none;"></div>

            <!-- Header du panneau : Marque & Badge Solution -->
            <div class="position-relative z-1 d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-white text-decoration-none">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 shadow-lg" 
                          style="width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="bi bi-box-seam fs-5"></i>
                    </span>
                    <span class="fs-4 fw-bold tracking-tight">Catalog<span style="color: #818cf8;">Pro</span></span>
                </a>
                <span class="badge rounded-pill px-3 py-2 text-white fw-semibold" 
                      style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); font-size: 0.78rem;">
                    <i class="bi bi-stars text-warning me-1"></i> Solution Multi-Univers
                </span>
            </div>

            <!-- Contenu central : Proposition de valeur & Carte Showcase -->
            <div class="position-relative z-1 my-auto py-4" style="max-width: 540px;">
                <h1 class="display-6 fw-bold text-white mb-3" style="line-height: 1.22; font-weight: 700;">
                    Pilotez vos gammes, stocks et fiches produits en toute clarté.
                </h1>
                <p class="text-white-50 lead mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                    La plateforme centrale pensée pour les distributeurs et entreprises régionales : gestion unifiée de vos références, suivi des approvisionnements et tarification en Franc CFA.
                </p>

                <!-- Carte Démonstrateur Glassmorphism (Aperçu Produit Réel) -->
                <div class="p-3 p-xl-4 rounded-4 shadow-lg mb-4" 
                     style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); backdrop-filter: blur(16px);">
                    
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom border-white border-opacity-10">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                            <span class="small fw-semibold text-white">Catalogue en direct</span>
                        </div>
                        <span class="badge bg-white bg-opacity-10 text-white-50 font-monospace" style="font-size: 0.72rem;">
                            {{ App\Models\Product::count() }} fiches actives
                        </span>
                    </div>

                    <!-- Mini Aperçu Produit Sénégalais -->
                    <div class="d-flex align-items-center gap-3 bg-black bg-opacity-20 p-3 rounded-3 border border-white border-opacity-10">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white fw-bold shadow-sm flex-shrink-0" 
                             style="width: 52px; height: 52px; background: linear-gradient(135deg, #10b981 0%, #047857 100%); font-size: 1.1rem;">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <h6 class="fw-bold text-white mb-0 text-truncate" style="font-size: 0.95rem;">Café Touba Bio Prestige</h6>
                                <span class="badge bg-success-subtle text-success" style="font-size: 0.7rem;">En stock</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-1 small text-white-50">
                                <span><i class="bi bi-tag me-1"></i>Alimentaire</span>
                                <span>&bull;</span>
                                <span class="fw-semibold text-warning">2 500 FCFA</span>
                            </div>
                        </div>
                    </div>

                    <!-- Puces de réassurance clés -->
                    <div class="row g-2 mt-3 text-white-50" style="font-size: 0.8rem;">
                        <div class="col-6 d-flex align-items-center gap-2">
                            <i class="bi bi-check2-circle text-primary"></i> 5 Univers sectoriels
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success"></i> Rôles Admin & Gestion
                        </div>
                    </div>
                </div>

                <!-- Tags des univers couverts -->
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2 py-1"><i class="bi bi-egg-fried me-1 text-warning"></i> Alimentaire</span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2 py-1"><i class="bi bi-bricks me-1 text-info"></i> Matériaux & BTP</span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2 py-1"><i class="bi bi-scissors me-1 text-danger"></i> Textile & Mode</span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2 py-1"><i class="bi bi-flower1 me-1 text-success"></i> Cosmétique</span>
                    <span class="badge bg-white bg-opacity-10 text-white-50 px-2 py-1"><i class="bi bi-cpu me-1 text-primary"></i> Équipement</span>
                </div>
            </div>

            <!-- Footer sobre et soigné -->
            <div class="position-relative z-1 small text-white-50 d-flex justify-content-between align-items-center border-top border-white border-opacity-10 pt-3">
                <span>&copy; {{ date('Y') }} CatalogPro. Conçu pour le commerce d'entreprise.</span>
                <span class="text-white-50"><i class="bi bi-geo-alt me-1"></i> Dakar, Sénégal</span>
            </div>
        </div>

        <!-- Panneau Droit (Formulaire de Connexion Élégant) -->
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
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Retour à la vitrine</span>
                    </a>
                </div>
            </div>

            <div class="mx-auto w-100" style="max-width: 410px;">
                <div class="mb-4">
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1 mb-2">Espace Collaborateur</span>
                    <h3 class="fw-bold text-dark mb-1">Connexion à la Console</h3>
                    <p class="text-muted small">Accédez aux fiches techniques, stocks et administration des prix.</p>
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
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>{{ session('error') }}
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
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="exemple@entreprise.sn">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-muted text-uppercase">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="password" type="password" class="form-control bg-light border-start-0 border-end-0 @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="••••••••">
                            <button class="btn btn-light border border-start-0 text-muted" type="button" 
                                    onclick="togglePasswordVisibility()" title="Afficher ou masquer le mot de passe">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Mémoriser ma session
                            </label>
                        </div>
                    </div>

                    <!-- Bouton Submit -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-brand py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                        </button>
                    </div>

                    <!-- Note discrète pour mot de passe oublié -->
                    <div class="p-3 rounded-3 bg-light border text-center small text-muted">
                        <i class="bi bi-info-circle me-1 text-primary"></i>
                        Identifiants perdus ? Contactez votre administrateur pour l'émission d'un mot de passe temporaire.
                    </div>
                </form>
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
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection
