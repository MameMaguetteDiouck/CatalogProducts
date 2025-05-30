@extends('layouts.app')

@section('content')
    <div class="w-100 content">
        <form class="w-100 text-black mt-5 mb-5" method="POST", action="{{route('cosmetiques.update', $cosmo->id)}}" enctype="multipart/form-data">
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
                  <label for="exampleFormControlInput1">Libelle</label>
                  <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('libelle', $cosmo->libelle)}}" name="libelle" placeholder="Smart TV 1154''">
                  @error('libelle')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Prix</label>
                  <input type="text" class="form-control mt-2 @error('prix') is-invalid @enderror" value="{{old('prix', $cosmo->prix)}}" name="prix" id="exampleFormControlInput1" placeholder="150399">
                  @error('prix')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Quantité</label>
                  <input type="number" class="form-control mt-2 @error('quantite') is-invalid @enderror" id="exampleFormControlInput1" name="quantite" value="{{old('quantite', $cosmo->quantite)}}" placeholder="25 Kg">
                  @error('quantite')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Unite</label>
                  <select class="form-control mt-2 @error('unite') is-invalid @enderror" name="unite">
                    <<option value="Millilitre" {{ old('unite', $cosmo->unite) == 'Millilitre' ? 'selected' : '' }}>Millilitre</option>
                    <option value="Litre" {{ old('unite', $cosmo->unite) == 'Litre' ? 'selected' : '' }}>Litre</option>
                    <option value="Gramme" {{ old('unite', $cosmo->unite) == 'Gramme' ? 'selected' : '' }}>Gramme</option>
                    <option value="Kiligramme" {{ old('unite', $cosmo->unite) == 'Kiligramme' ? 'selected' : '' }}>Kiligramme</option>
                  </select>
                  @error('unite')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Stock</label>
                  <input type="number" min="1" name="stock" value="{{old('stock', $cosmo->stock)}}" class="form-control mt-2 @error('stock') is-invalid @enderror" id="exampleFormControlInput1" placeholder="50 sacs">
                  @error('stock')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Marque</label>
                  <select class="form-control mt-2 @error('marque') is-invalid @enderror" name="marque">
                    <<option value="DayByDay" {{ old('marque', $cosmo->marque) == 'DayByDay' ? 'selected' : '' }}>DayByDay</option>
                    <option value="Sivop" {{ old('marque', $cosmo->marque) == 'Sivop' ? 'selected' : '' }}>Sivop</option>
                    <option value="Autres..." {{ old('Autres...', $cosmo->marque) == 'Autres...' ? 'selected' : '' }}>Autres...</option>
                  </select>
                   @error('marque')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-100 mb-3 m-2">
                <label for="exampleFormControlTextarea1">Descriptions</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" value="" id="exampleFormControlTextarea1" rows="3">{{old('description', $cosmo->description)}}</textarea>
                @error('description')
                  <span class="text-danger ms-3 me-3">{{ $message }}</>
                @enderror
              </div>
            </div>
            <div class="form-group ms-4 me-4 mb-3 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a class="link-underline text-white btn btn-primary" href="{{ route('cosmetiques.index')}}">Accueil</a>
                </div>
            </div>
          </form>
    </div>
@endsection