@extends('layouts.app')

@section('content')
    <div class="w-100 content">
        <form class="w-100 text-black mt-5 mb-5" method="POST" action="{{ route('habillements.update', $habit->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-4 d-flex me-3 justify-content-center">
                        <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                            alt="example placeholder" style="width: 150px; height: 150px" />
                    </div>
                    <div class="d-flex ms-3 justify-content-center">
                        <div data-mdb-ripple-init class="btn btn-primary btn-rounded">
                            <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                            <input type="file" name="image" class="form-control d-none" id="customFile1"
                                onchange="displaySelectedImage(event, 'selectedImage')" />
                        </div>
                        @error('image')
                            <span class="text-danger ms-3 me-3">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                    <label for="libelle">Libelle</label>
                    <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="libelle"
                        name="libelle" value="{{ old('libelle', $habit->libelle) }}"
                        placeholder="Pull en Cuire Luis Vuitton">
                    @error('libelle')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group w-50 m-1">
                    <label for="prix">Prix</label>
                    <input type="number" class="form-control mt-2 @error('prix') is-invalid @enderror" name="prix"
                        id="prix" value="{{ old('prix', $habit->prix) }}" placeholder="600">
                    @error('prix')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                    <label for="taille">Taille</label>
                    <select name="taille" class="form-control mt-2 @error('taille') is-invalid @enderror" id="taille">
                        <option value="">Choisir la taille...</option>
                        <option value="L" {{ old('taille', $habit->taille) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="S" {{ old('taille', $habit->taille) == 'S' ? 'selected' : '' }}>S</option>
                        <option value="M" {{ old('taille', $habit->taille) == 'M' ? 'selected' : '' }}>M</option>
                        <option value="XL" {{ old('taille', $habit->taille) == 'XL' ? 'selected' : '' }}>XL</option>
                        <option value="XXL" {{ old('taille', $habit->taille) == 'XXL' ? 'selected' : '' }}>XXL</option>
                    </select>
                    @error('taille')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group w-50 m-1">
                    <label for="unite">Unité</label>
                    <select class="form-control mt-2 @error('unite') is-invalid @enderror" name="unite" id="unite">
                        <option value="">Choisir l'unité</option>
                        <option value="piece" {{ old('unite', $habit->unite) == 'piece' ? 'selected' : '' }}>pièce
                        </option>
                        <option value="ensemble" {{ old('unite', $habit->unite) == 'ensemble' ? 'selected' : '' }}>ensemble
                        </option>
                    </select>
                    @error('unite')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" class="form-control mt-2 @error('stock') is-invalid @enderror"
                        id="stock" value="{{ old('stock', $habit->stock) }}" placeholder="50">
                    @error('stock')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group w-50 m-1">
                    <label for="marque">Marque</label>
                    <select class="form-control mt-2 @error('marque') is-invalid @enderror" name="marque" id="marque">
                        <option value="">Choisir la marque...</option>
                        <option value="Louis Vuitton"
                            {{ old('marque', $habit->marque) == 'Louis Vuitton' ? 'selected' : '' }}>Louis Vuitton</option>
                        <option value="Dior" {{ old('marque', $habit->marque) == 'Dior' ? 'selected' : '' }}>Dior
                        </option>
                        <option value="Jordan" {{ old('marque', $habit->marque) == 'Jordan' ? 'selected' : '' }}>Jordan
                        </option>
                        <option value="Nike" {{ old('marque', $habit->marque) == 'Nike' ? 'selected' : '' }}>Nike
                        </option>
                        <option value="Adidas" {{ old('marque', $habit->marque) == 'Adidas' ? 'selected' : '' }}>Adidas
                        </option>
                        <option value="Balenciaga" {{ old('marque', $habit->marque) == 'Balenciaga' ? 'selected' : '' }}>
                            Balenciaga</option>
                        <option value="Autres..." {{ old('marque', $habit->marque) == 'Autres...' ? 'selected' : '' }}>
                            Autres...</option>
                    </select>
                    @error('marque')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4 ">
                <div class="form-group w-100 m-1">
                    <label for="description">Descriptions</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        rows="3">{{ old('description', $habit->description) }}</textarea>
                    @error('description')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-2 mb-5 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a href="{{ url('/') }}" class="btn btn-secondary ms-5">Accueil</a>
                </div>
            </div>
        </form>

    </div>
@endsection
