<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyCatalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-vh-100">
    <header class="navbar container-fluid bg-black">
        <div class="text-white text-center ms-5">
            <h4>MyCatalog</h4>
        </div>
        <div class="me-5">
            <form class="d-flex" role="search" action="{{ route('products.search', 'welcome') }}" method="POST">
                @csrf
                <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
                @guest
                    <a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Connexion</a>
                @endguest
                @auth
                    <a class="btn btn-outline-primary ms-2" href="{{ route('products.index') }}">Acueill</a>
                @endauth
            </form>
        </div>
    </header>
    @if ($searches)
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary text-black w-100">
            <div class="container w-100">
                <ul class="navbar-nav flex-row w-100 justify-content-start">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{url('/')}}">Home</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="d-flex align-items-center justify-content-center m-3">
            <h4>Résultat de la recherche</h4>
        </div>
        <div class="container sectionBody">
            <div class="row justify-content-center">
                @foreach ($searches as $search)
                    <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                        <div class="card" style="width: 18rem; height: 20em;">
                            <img src="{{ asset($search->image) }}" class="card-img-top" alt="Non disponible..."
                                style="height:10em;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $search->libelle }}</h5>
                                {{-- <p class="card-text">{{ $aliment->description }}</p> --}}
                                <p>{{ $search->prix }} FrancCFA</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    @if ($search->stock != 0)
                                        <button class="btn btn-success">
                                            disponible
                                        </button>
                                    @else
                                        <button class="btn btn-danger">
                                            Indisponible
                                        </button>
                                    @endif
                                    <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter-{{ $search->id }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter-{{ $search->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header justify-content-between">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $search->libelle }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ $search->image }}" alt="Non disponible" width="150px">
                                    </div>
                                    <p>Catégorie : {{ $search->categorie }} {{ $search->categorie }}</p>
                                    <p>Quantité : {{ $search->quantite }} {{ $search->unite }}</p>
                                    <p>Prix : {{ $search->prix }} FrancCFA</p>
                                    <p>Description : {{ $search->description }}</p>
                                </div>
                                <div class="modal-footer justify-content-end">
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @else
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary text-black w-100">
            <div class="container w-100">
                <ul class="navbar-nav flex-row w-100 justify-content-start">
                    <li class="nav-item">
                        <a class="nav-link active" href="#aliments">Aliments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#habits">Habillements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#electros">Electroniques</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#cosmos">Cosmétiques</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#btps">BTPs</a>
                    </li>
                </ul>
            </div>
        </nav>
        <section id="aliments" class="container mt-2">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4>Aliments</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($aliments as $aliment)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($aliment->image) }}" class="card-img-top" alt="Non disponible..."
                                    style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $aliment->libelle }}</h5>
                                    {{-- <p class="card-text">{{ $aliment->description }}</p> --}}
                                    <p>{{ $aliment->prix }} FrancCFA</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($aliment->stock != 0)
                                            <button class="btn btn-success">
                                                disponible
                                            </button>
                                        @else
                                            <button class="btn btn-danger">
                                                Indisponible
                                            </button>
                                        @endif
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter-{{ $aliment->id }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $aliment->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $aliment->libelle }}
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ $aliment->image }}" alt="Non disponible" width="150px">
                                        </div>
                                        <p>Catégorie : {{ $aliment->categorie }} {{ $aliment->categorie }}</p>
                                        <p>Quantité : {{ $aliment->quantite }} {{ $aliment->unite }}</p>
                                        <p>Prix : {{ $aliment->prix }} FrancCFA</p>
                                        <p>Description : {{ $aliment->description }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="d-flex align-items-end justify-content-end bottom-0">
                <a class="btn btn-primary" href="{{ route('products.seeMore', ['aliments']) }}">Voir plus... </a>
            </div>
        </section>
        <section id="habits" class="container mt-2">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4>Habillements</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($habits as $habit)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($habit->image) }}" class="card-img-top h-50" alt="...">
                                <div class="card-body h-50">
                                    <h6 class="card-title" style="height: 30px;">{{ $habit->libelle }}</h6>
                                    {{-- <p class="card-text">{{ $habit->description }}</p> --}}
                                    <div class="">
                                        <p class="">{{ $habit->prix }} FrancCFA</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($habit->stock != 0)
                                                <button class="btn btn-success">
                                                    disponible
                                                </button>
                                            @else
                                                <button class="btn btn-danger">
                                                    Indisponible
                                                </button>
                                            @endif
                                            <i class="bi bi-eye text-primary ms-3 fs-3"
                                                data-bs-target="#exampleModalCenter-{{ $habit->id }}"
                                                data-bs-toggle="modal"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $habit->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $habit->libelle }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-bs-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ asset($habit->image) }}" alt="Non disponible"
                                                width="150px">
                                        </div>
                                        <p>Marque : {{ $habit->marque }}</p>
                                        <p>Unité : {{ $habit->unite }}</p>
                                        <p>Prix : {{ $habit->prix }}</p>
                                        <p>Description : {{ $habit->description }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-end bottom-0">
                <a class="btn btn-primary" href="{{ route('products.seeMore', ['habillements']) }}">Voir plus... </a>
            </div>
        </section>
        <section id="electros" class="container mt-2">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4>Electroniques</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($electros as $electro)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($electro->image) }}" class="card-img-top" alt="..."
                                    style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $electro->libelle }}</h5>
                                    <p>{{ $electro->prix }} FrancCFA</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($electro->stock != 0)
                                            <button class="btn btn-success">
                                                disponible
                                            </button>
                                        @else
                                            <button class="btn btn-danger">
                                                Indisponible
                                            </button>
                                        @endif
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter-{{ $electro->id }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $electro->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $electro->libelle }}
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-bs-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ asset($electro->image) }}" alt="Non disponible"
                                                width="150px">
                                        </div>
                                        <p>Garantie : {{ $electro->garantie }}</p>
                                        <p>Prix : {{ $electro->prix }} FrancCFA</p>
                                        <p>Description : {{ $electro->description }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-end bottom-0">
                <a class="btn btn-primary" href="{{ route('products.seeMore', ['electronique']) }}">Voir plus... </a>
            </div>
        </section>
        <section id="cosmos" class="container mt-2">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4>Cosmétiques</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($cosmos as $cosmo)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($cosmo->image) }}" class="card-img-top"
                                    alt="Image non disponible!!!" style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cosmo->libelle }}</h5>
                                    <p>{{ $cosmo->prix }} FrancCFA</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($cosmo->stock != 0)
                                            <button class="btn btn-success">
                                                disponible
                                            </button>
                                        @else
                                            <button class="btn btn-danger">
                                                Indisponible
                                            </button>
                                        @endif
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter-{{ $cosmo->id }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $cosmo->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $cosmo->libelle }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-bs-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ asset($cosmo->image) }}" alt="Non disponible"
                                                width="150px">
                                        </div>
                                        <p>Quantité : {{ $cosmo->quantite }} {{ $cosmo->unite }}</p>
                                        <p>Marque : {{ $cosmo->marque }}</p>
                                        <p>Prix : {{ $cosmo->prix }} FrancCFA</p>
                                        <p>Description : {{ $cosmo->description }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-end bottom-0">
                <a class="btn btn-primary" href="{{ route('products.seeMore', ['cosmetiques']) }}">Voir plus... </a>
            </div>
        </section>
        <section id="btps" class="container">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4>BTPs</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($btps as $btp)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($btp->image) }}" class="card-img-top" alt="Non disponible..."
                                    style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $btp->libelle }}</h5>
                                    <p class="card-text">{{ $btp->description }}</p>
                                    <p>{{ $btp->prix }} FrancCFA</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($btp->stock != 0)
                                            <button class="btn btn-success">
                                                disponible
                                            </button>
                                        @else
                                            <button class="btn btn-danger">
                                                Indisponible
                                            </button>
                                        @endif
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalCenter-{{ $btp->id }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $btp->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $btp->libelle }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-bs-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ asset($btp->image) }}" alt="Non disponible" width="150px">
                                        </div>
                                        <p>Catégorie : {{ $btp->categorie }} {{ $aliment->categorie }}</p>
                                        <p>Quantité : {{ $btp->quantite }} {{ $aliment->unite }}</p>
                                        <p>Prix : {{ $btp->prix }} FrancCFA</p>
                                        <p>Description : {{ $btp->description }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex align-items-end justify-content-end bottom-0">
                <a class="btn btn-primary" href="{{ route('products.seeMore', ['btps']) }}">Voir plus... </a>
            </div>
        </section>
    @endif
    <footer class="mt-auto">
        <p class="text-black text-center">&copy; {{ date('Y') }} MameDI. Tous droits réservés.</p>
    </footer>
</body>

</html>
