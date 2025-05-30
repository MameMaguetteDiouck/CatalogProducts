@extends('layouts.app')

@section('content')
    <div class="w-100 d-flex align-items-center justify-content-center">
        <form class="w-100 text-black" method="POST" action="{{route('electroniques.store')}}" enctype="multipart/form-data">
          @csrf 
          <input type="hidden" name="type" value="electronique">
            <input type="hidden" name="type" value="electronique">
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
                  <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="exampleFormControlInput1" name="libelle" placeholder="Smart TV 1154''">
                  @error('libelle')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Prix</label>
                  <input type="text" class="form-control mt-2 @error('prix') is-invalid @enderror" name="prix" id="exampleFormControlInput1" placeholder="150399">
                  @error('prix')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Stock</label>
                  <input type="number" min="1" name="stock" class="form-control mt-2 @error('stock') is-invalid @enderror" id="exampleFormControlInput1" placeholder="50 sacs">
                  @error('stock')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Garantie</label>
                  <select name="garantie" class="form-control mt-2 @error('garantie') is-invalid @enderror">
                    <option>Veuillez selectionner le Garantie...</option>
                    <option>Pas de Garantie</option>
                    <option>1 mois</option>
                    <option>2 mois</option>
                    <option>6 mois</option>
                    <option>12 mois</option>
                  </select>
                  @error('garantie')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4 ">
                <div class="form-group w-100 m-1">
                    <label for="description">Descriptions</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger ms-3 me-3">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group ms-4 me-4 mt-3  mb-3 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a class="link-underline text-white btn btn-primary" href="{{ route('electroniques.index')}}">Accueil</a>
                </div>
            </div>
          </form>
    </div>
@endsection
{{-- @extends('layouts.app')

@section('content')
    <div class="w-100 m-5 mt-5" style="border: 1px solid red;">
        <form class="w-100 text-black">
            <div class="d-flex align-items-center justify-content-center m-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Libelle</label>
                  <input type="text" class="form-control mt-2" id="exampleFormControlInput1" name="libelle" placeholder="Smart TV 1154''">
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Prix</label>
                  <input type="number" class="form-control mt-2" name="prix" id="exampleFormControlInput1" placeholder="600">
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center m-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Quantité</label>
                  <input type="text" class="form-control mt-2" id="exampleFormControlInput1" name="quantite" placeholder="25">
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Garantie</label>
                  <input type="text" class="form-control mt-2" name="date_peremption" id="exampleFormControlInput1" placeholder="12 mois">
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center m-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Stock</label>
                  <input type="number" min="1" name="stock" class="form-control mt-2" id="exampleFormControlInput1" placeholder="50 pieces">
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Unite</label>
                  <input type="text" name="unite" class="form-control mt-2" id="exampleFormControlInput1" placeholder="piece">
                </div>
            </div>
            <div class="form-group m-5">
              <label for="exampleFormControlTextarea1">Descriptions</label>
              <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group m-5 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a class="link-underline text-white btn btn-primary" href="{{ route('electroniques.index')}}">Accueil</a>
                </div>
            </div>
          </form>
    </div>
@endsection --}}