<div class="sidebar bg-primary">
    <div class="titleProject d-flex justify-content-center align-items-center">
        <div class="text-white">
            <h2>MyCatalog</h2>
        </div>
    </div>
    <div class="menu">
        <nav class="nav flex-column text-white">
            <a class="nav-link " href="{{route('products.index')}}">Home</a>
            <a class="nav-link " href="{{route('home')}}">Accueil Client</a>
            <button class="btn btn-primary text-start ms-1 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#contenu"
                aria-expanded="false" aria-controls="contenu">
                Produits
            </button>

            <div class="collapse" id="contenu">
                <a class="card border-0 nav-link card-body bg-primary" href="{{route('aliments.index')}}">
                    Alimentations
                </a>
                <a class="card border-0 nav-link card-body bg-primary" href="{{route('electroniques.index')}}">
                    Electroniques
                </a>
                <a class="card border-0 nav-link card-body bg-primary" href="{{route('cosmetiques.index')}}">
                    Cosmétiques
                </a>
                <a class="card border-0 card-body nav-link bg-primary" href="{{route('habillements.index')}}">
                    Vestimentaires
                </a>
                <a class="card border-0 card-body nav-link bg-primary" href="{{route('btps.index')}}">
                    BTP
                </a>

            </div>
            <a class="nav-link" href="#"></a>
            <a class="nav-link" aria-disabled="true"></a>
        </nav>
    </div>
    <div class=" d-flex align-items-center justify-content-center">
        <a href="#" class="text-white nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        {{-- <a href="{{ route('logout') }}" class="text-white nav-link">Déconnexion</a> --}}
    </div>
</div>