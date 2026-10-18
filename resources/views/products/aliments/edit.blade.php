@extends('layouts.app')

@section('content')
    <div class="w-100 content">
        <form class="w-100 mt-5 mb-5 text-black" method="POST" action="{{route('aliments.update', [$aliment->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                            <input type="file" class="form-control d-none" name="image" id="customFile1"
                                onchange="displaySelectedImage(event, 'selectedImage')" />
                        </div>
                    </div>
                </div>
                @error('image')
                  <span class="text-danger ms-3 me-3">{{ $message }}</>
                @enderror
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Libelle</label>
                  <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="exampleFormControlInput1" name="libelle" value="{{old('libelle', $aliment->libelle)}}" placeholder="Mil Souna">
                  @error('libelle')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Prix</label>
                  <input type="number" class="form-control mt-2 @error('prix') is-invalid @enderror" name="prix" id="exampleFormControlInput1" value="{{old('prix', $aliment->prix)}}" placeholder="600">
                  @error('prix')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Quantité</label>
                  <input type="number" class="form-control mt-2 @error('quantite') is-invalid @enderror" id="exampleFormControlInput1" name="quantite" value="{{old('quantite', $aliment->quantite)}}" placeholder="25 Kg">
                  @error('quantite')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Unite</label>
                  <select class="form-control mt-2 @error('unite') is-invalid @enderror" name="unite">
                    <<option value="Millilitre" {{ old('unite', $aliment->unite) == 'Millilitre' ? 'selected' : '' }}>Millilitre</option>
                    <option value="Litre" {{ old('unite', $aliment->unite) == 'Litre' ? 'selected' : '' }}>Litre</option>
                    <option value="Gramme" {{ old('unite', $aliment->unite) == 'Gramme' ? 'selected' : '' }}>Gramme</option>
                    <option value="Kiligramme" {{ old('unite', $aliment->unite) == 'Kiligramme' ? 'selected' : '' }}>Kiligramme</option>
                  </select>
                  @error('unite')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Stock</label>
                  <input type="number" min="1" name="stock" value="{{old('stock', $aliment->stock)}}" class="form-control mt-2" id="exampleFormControlInput1" placeholder="50 sacs">
                  @error('stock')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="categorie">Catégorie</label>
                  <select name="categorie" id="categorie" class="form-control mt-2 @error('categorie') is-invalid @enderror">
                      <option value="">Veuillez sélectionner la catégorie...</option>
                      <option value="Laitier" {{ old('categorie', $aliment->categorie) == 'Laitier' ? 'selected' : '' }}>Laitier</option>
                      <option value="Céréal" {{ old('categorie', $aliment->categorie) == 'Céréal' ? 'selected' : '' }}>Céréal</option>
                      <option value="Viande ou Oeuf" {{ old('categorie', $aliment->categorie) == 'Viande ou Oeuf' ? 'selected' : '' }}>Viande ou Oeuf</option>
                      <option value="Autres" {{ old('categorie', $aliment->categorie) == 'Autres' ? 'selected' : '' }}>Autres</option>
                  </select>
                  @error('categorie')
                      <span class="text-danger ms-3 me-3">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4 ">
                <div class="form-group w-100 m-1">
                    <label for="description">Descriptions</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        rows="3">{{ old('description', $aliment->description) }}</textarea>
                    @error('description')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group ms-4 me-4 mb-3 mt-3 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a class="link-underline text-white btn btn-primary" href="{{ route('aliments.index')}}">Accueil</a>
                </div>
            </div>
          </form>
    </div>
@endsection