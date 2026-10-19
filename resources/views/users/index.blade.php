@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <!-- Messages Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Équipe & Gestion des Accès</h2>
            <p class="text-muted mb-0 small">
                Attribuez les rôles et administrez les comptes autorisés sur la plateforme.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Espace Catalogue
            </a>
            <a href="{{ route('users.create') }}" class="btn btn-brand btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Ajouter un Collaborateur
            </a>
        </div>
    </div>

    <!-- Tableau des Collaborateurs -->
    <div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Collaborateur</th>
                        <th class="py-3">Adresse e-mail</th>
                        <th class="py-3">Rôle & Permissions</th>
                        <th class="py-3">Date d'accès</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <!-- Nom & Avatar -->
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm"
                                          style="width: 38px; height: 38px; background: {{ $user->isAdmin() ? '#4f46e5' : '#64748b' }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        @if (auth()->id() === $user->id)
                                            <span class="badge bg-light text-primary border small">Votre compte actif</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- E-mail -->
                            <td class="py-3">
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>

                            <!-- Rôle -->
                            <td class="py-3">
                                @if ($user->isAdmin())
                                    <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1 rounded-pill">
                                        <i class="bi bi-shield-lock-fill me-1"></i> Administrateur
                                    </span>
                                    <div class="text-muted small mt-1" style="font-size: 0.75rem;">Accès complet, suppression & utilisateurs</div>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary fw-semibold px-2 py-1 rounded-pill">
                                        <i class="bi bi-person-gear me-1"></i> Gestionnaire
                                    </span>
                                    <div class="text-muted small mt-1" style="font-size: 0.75rem;">Ajout & modification catalogue</div>
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="py-3 small text-muted">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Actif' }}
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4 py-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Confirmez-vous la révocation du compte de {{ $user->name }} ?');" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer bg-white border-top p-3 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
