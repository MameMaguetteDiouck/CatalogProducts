<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyCatalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    <header class="navbar container-fluid bg-black">
        <div class="text-white text-center ms-5">
            <h4>MyCatalog</h4>
        </div>
        <div class="me-5">
            {{-- <form class="d-flex" role="search" action="{{ route('products.search', 'products.index')}}" method="GET">
                <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
            <a href="{{url('/')}}" class="btn btn-outline-danger">Retour</a>
            @guest
                <a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Connexion</a>
            @endguest
            @auth
                <a class="btn btn-outline-primary ms-2" href="{{ route('products.index') }}">Acueill</a>
            @endauth
        </div>
    </header>
    @if ($searches)
    <div class="container mt-5 text-black d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4 class="text-uppercase">{{$type}}</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($searches as $search)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($search->image) }}" class="card-img-top" alt="Non disponible..." style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $search->libelle }}</h5>
                                    {{-- <p class="card-text">{{ $product->description }}</p> --}}
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
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal" data-bs-target="#exampleModalCenter-{{ $product->id }}"></i>
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
                                        <p>Catégorie : {{ $search->categorie }} {{$search->categorie}}</p>
                                        <p>Quantité : {{ $search->quantite }} {{$search->unite}}</p>
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
        </div>
    @else
        <div class="container mt-5 text-black d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex align-items-center justify-content-center m-3">
                <h4 class="text-uppercase">{{$type}}</h4>
            </div>
            <div class="container sectionBody">
                <div class="row justify-content-center">
                    @foreach ($products as $product)
                        <div class="col-6 col-lg-3 d-flex justify-content-center mb-4">
                            <div class="card" style="width: 18rem; height: 20em;">
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="Non disponible..." style="height:10em;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->libelle }}</h5>
                                    {{-- <p class="card-text">{{ $product->description }}</p> --}}
                                    <p>{{ $product->prix }} FrancCFA</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($product->stock != 0)
                                            <button class="btn btn-success">
                                                disponible
                                            </button>
                                        @else
                                            <button class="btn btn-danger">
                                                Indisponible
                                            </button>
                                        @endif
                                        <i class="bi bi-eye me-3 text-primary fs-3" data-bs-toggle="modal" data-bs-target="#exampleModalCenter-{{ $product->id }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter-{{ $product->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header justify-content-between">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $product->libelle }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src="{{ $product->image }}" alt="Non disponible" width="150px">
                                        </div>
                                        <p>Catégorie : {{ $product->categorie }} {{$product->categorie}}</p>
                                        <p>Quantité : {{ $product->quantite }} {{$product->unite}}</p>
                                        <p>Prix : {{ $product->prix }} FrancCFA</p>
                                        <p>Description : {{ $product->description }}</p>
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
        </div>
    @endif
    <footer class="w-100 bg-body-tertiary border-0 mt-4">
        <p class="text-black text-center">&copy; {{ date('Y') }} MameDI. Tous droits réservés.</p>
    </footer>
</body>

</html>
