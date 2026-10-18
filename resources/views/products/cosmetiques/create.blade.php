@extends('layouts.app')

@section('content')
    <div class="w-100 content">
        <form class="w-100 text-black mt-5 mb-5" method="POST" action="{{ route('cosmetiques.store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="cosmetiques">
          <div class="d-flex align-items-center justify-content-center ms-4 me-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 d-flex me-2 justify-content-center">
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
                            <span class="text-danger ms-3 me-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
          <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-50 m-1">
                  <label for="libelle">Libelle</label>
                  <input type="text" class="form-control mt-1" id="libelle" name="libelle" placeholder="Savon DayByDay" value="{{ old('libelle') }}">
                  @error('libelle')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="form-group w-50 m-1">
                  <label for="prix">Prix</label>
                  <input type="text" class="form-control mt-1" id="prix" name="prix" placeholder="600" value="{{ old('prix') }}">
                  @error('prix')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>

          <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-50 m-1">
                  <label for="quantite">Quantité</label>
                  <input type="number" class="form-control mt-1" id="quantite" name="quantite" placeholder="250" value="{{ old('quantite') }}">
                  @error('quantite')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="form-group w-50 m-1">
                  <label for="unite">Unité</label>
                  <select class="form-control mt-1" name="unite" id="unite">
                      <option value="">Choisir l'unité</option>
                      <option value="Litre" {{ old('unite') == 'Litre' ? 'selected' : '' }}>Litre</option>
                      <option value="Millilitre" {{ old('unite') == 'Millilitre' ? 'selected' : '' }}>Millilitre</option>
                      <option value="Gramme" {{ old('unite') == 'Gramme' ? 'selected' : '' }}>Gramme</option>
                      <option value="Kiligramme" {{ old('unite') == 'Kiligramme' ? 'selected' : '' }}>Kiligramme</option>
                  </select>
                  @error('unite')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>

          <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-50 m-1">
                  <label for="stock">Stock</label>
                  <input type="number" name="stock" class="form-control mt-1" id="stock" placeholder="50" value="{{ old('stock') }}">
                  @error('stock')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="form-group w-50 m-1">
                  <label for="marque">Marque</label>
                  <select class="form-control mt-1" name="marque" id="marque">
                      <option value="">Choisir la marque...</option>
                      <option value="DayByDay" {{ old('marque') == 'DayByDay' ? 'selected' : '' }}>DayByDay</option>
                      <option value="Divop" {{ old('marque') == 'Divop' ? 'selected' : '' }}>Divop</option>
                      <option value="Autres..." {{ old('marque') == 'Autres...' ? 'selected' : '' }}>Autres...</option>
                  </select>
                  @error('marque')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          <div class="d-flex align-items-center justify-content-center ms-4 me-4"">
              <div class="form-group mb-3 m-2 w-100">
                  <label for="description">Descriptions</label>
                  <textarea class="form-control mt-1" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                  @error('description')
                      <small class="text-danger ms-3">{{ $message }}</small>
                  @enderror
              </div>
          </div>

          <div class="form-group ms-4 me-4 mb-12 d-flex justify-content-center align-items-center">
              <div>
                  <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
              </div>
              <div>
                  <button type="button" class="btn btn-primary ms-5">Accueil</button>
              </div>
          </div>
      </form>

    </div>
@endsection