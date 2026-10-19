@if ($paginator->hasPages())
    {{-- Vue Mobile : compacte, centrée et tactile --}}
    <div class="d-flex d-md-none align-items-center justify-content-between w-100 gap-2">
        @if ($paginator->onFirstPage())
            <span class="btn btn-sm btn-light text-muted border disabled px-3">
                <i class="bi bi-chevron-left me-1"></i> Précédent
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary px-3" rel="prev">
                <i class="bi bi-chevron-left me-1"></i> Précédent
            </a>
        @endif

        <span class="small fw-bold text-dark text-nowrap">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary px-3" rel="next">
                Suivant <i class="bi bi-chevron-right ms-1"></i>
            </a>
        @else
            <span class="btn btn-sm btn-light text-muted border disabled px-3">
                Suivant <i class="bi bi-chevron-right ms-1"></i>
            </span>
        @endif
    </div>

    {{-- Vue Desktop : pagination moderne numérotée --}}
    <nav class="modern-pagination d-none d-md-flex align-items-center justify-content-end gap-1" role="navigation" aria-label="Pagination Navigation">
        {{-- Bouton Précédent --}}
        @if ($paginator->onFirstPage())
            <span class="modern-page-item disabled" aria-disabled="true" aria-label="Précédent" title="Page précédente">
                <i class="bi bi-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="modern-page-item" rel="prev" aria-label="Précédent" title="Page précédente">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif

        {{-- Éléments de pagination --}}
        @foreach ($elements as $element)
            {{-- Séparateur "..." --}}
            @if (is_string($element))
                <span class="modern-page-separator" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Liens de pages numérotées --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="modern-page-item active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="modern-page-item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Bouton Suivant --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="modern-page-item" rel="next" aria-label="Suivant" title="Page suivante">
                <i class="bi bi-chevron-right"></i>
            </a>
        @else
            <span class="modern-page-item disabled" aria-disabled="true" aria-label="Suivant" title="Page suivante">
                <i class="bi bi-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif
