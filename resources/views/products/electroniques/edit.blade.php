@extends('layouts.app')

@section('content')
    <div class="w-100">
        <form class="w-100 text-black" method="POST" action="{{route('electroniques.update', [$electro->id])}}" enctype="multipart/form-data">
          @csrf 
          @method('PUT')
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
                  <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('libelle', $electro->libelle)}}" name="libelle" placeholder="Smart TV 1154''">
                  @error('libelle')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Prix</label>
                  <input type="text" class="form-control mt-2 @error('prix') is-invalid @enderror" value="{{old('prix', $electro->prix)}}" name="prix" id="exampleFormControlInput1" placeholder="150399">
                  @error('prix')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Stock</label>
                  <input type="number" min="1" name="stock" value="{{old('stock', $electro->stock)}}" class="form-control mt-2 @error('stock') is-invalid @enderror" id="exampleFormControlInput1" placeholder="50 sacs">
                  @error('stock')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
                <div class="form-group w-50 m-1">
                  <label for="exampleFormControlInput1">Garantie</label>
                  <select name="garantie" class="form-control @error('garantie') is-invalid @enderror">
                    <option>Veuillez selectionner le Garantie...</option>
                    <option value="Pas de Garantie" {{ old('unite', $electro->garantie) == 'Pas de Ganrantie' ? 'selected' : '' }}>Pas de Garantie</option>
                    <option value="1 mois" {{ old('unite', $electro->garantie) == '1 mois' ? 'selected' : '' }}>1 mois</option>
                    <option value="2 mois" {{ old('unite', $electro->garantie) == '2 mois' ? 'selected' : '' }}>2 mois</option>
                    <option value="6 mois" {{ old('unite', $electro->garantie) == '6 mois' ? 'selected' : '' }}>6 mois</option>
                    <option value="12 mois" {{ old('unite', $electro->garantie) == '12 mois' ? 'selected' : '' }}>12 mois</option>
                  </select>
                  @error('garantie')
                    <span class="text-danger ms-3 me-3">{{ $message }}</>
                  @enderror
                </div>
            </div>
            <div class="form-group mb-3 ms-4 me-5">
              <label class="ms-3 me-3" for="exampleFormControlTextarea1">Descriptions</label>
              <textarea class="form-control ms-3 me-5 @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="3">{{old('description', $electro->description)}}</textarea>
              @error('description')
                <span class="text-danger ms-3 me-3">{{ $message }}</>
              @enderror
            </div>
            <div class="form-group ms-4 me-4 mb-3 d-flex justify-content-center align-items-center">
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
