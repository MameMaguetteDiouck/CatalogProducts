@extends('layouts.app')

@section('content')
    <div class="w-100 content">
        <form class="w-100 text-black mt-5 mb-5" method="POST" action="{{ route('aliments.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="aliments">
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
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="libelle"
                        name="libelle" value="{{ old('libelle') }}" placeholder="Mil Souna">
                    @error('libelle')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group w-50 m-1">
                    <label for="prix">Prix</label>
                    <input type="number" class="form-control mt-2 @error('prix') is-invalid @enderror" name="prix"
                        id="prix" value="{{ old('prix') }}" placeholder="600">
                    @error('prix')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                    <label for="quantite">Quantité</label>
                    <input type="number" class="form-control mt-2 @error('quantite') is-invalid @enderror" id="quantite"
                        name="quantite" value="{{ old('quantite') }}" placeholder="25">
                    @error('quantite')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group w-50 m-1">
                    <label for="unite">Unité</label>
                    <select class="form-control mt-2 @error('unite') is-invalid @enderror" name="unite" id="unite">
                        <option value="">Choisir l'unité</option>
                        <option {{ old('unite') == 'Millilitre' ? 'selected' : '' }}>Millilitre</option>
                        <option {{ old('unite') == 'Litre' ? 'selected' : '' }}>Litre</option>
                        <option {{ old('unite') == 'Gramme' ? 'selected' : '' }}>Gramme</option>
                        <option {{ old('unite') == 'Kilogramme' ? 'selected' : '' }}>Kilogramme</option>
                    </select>
                    @error('unite')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                    <label for="stock">Stock</label>
                    <input type="number" min="1" name="stock" value="{{ old('stock') }}"
                        class="form-control mt-2 @error('stock') is-invalid @enderror" id="stock" placeholder="50">
                    @error('stock')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group w-50 m-1">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-control mt-2 @error('categorie') is-invalid @enderror">
                        <option value="">Veuillez sélectionner la catégorie...</option>
                        <option {{ old('categorie') == 'Laitier' ? 'selected' : '' }}>Laitier</option>
                        <option {{ old('categorie') == 'Céréal' ? 'selected' : '' }}>Céréal</option>
                        <option {{ old('categorie') == 'Viande ou Oeuf' ? 'selected' : '' }}>Viande ou Oeuf</option>
                        <option {{ old('categorie') == 'Autres' ? 'selected' : '' }}>Autres</option>
                    </select>
                    @error('categorie')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
               <div class="form-group w-100 m-1">
                   <label for="description">Descriptions</label>
                   <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                       rows="3">{{ old('description') }}</textarea>
                   @error('description')
                       <span class="text-danger ms-3 me-3">{{ $message }}</span>
                   @enderror
               </div>
            </div>

            <div class="form-group ms-4 me-4 mb-3 mt-2 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a href="{{ route('aliments.index') }}" class="btn btn-primary ms-5">Accueil</a>
                </div>
            </div>
        </form>
    </div>
@endsection
