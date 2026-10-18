@extends('layouts.app')

@section('content')
    <div class="w-100">
        <form class="w-100 text-black" method="POST" action="{{route('btps.index')}}">
          @csrf
            <input type="hidden" name="type" value="btps">
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-50 m-3">
                  <label for="libelle">Libellé</label>
                  <input type="text" class="form-control mt-2 @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle') }}" placeholder="Tyau avc">
                  @error('libelle')
                      <span class="text-danger ms-3 me-3">{{ $message }}</span>
                  @enderror
              </div>
              <div class="form-group w-50 m-3">
                  <label for="prix">Prix</label>
                  <input type="number" class="form-control mt-2 @error('prix') is-invalid @enderror" name="prix" id="prix" value="{{ old('prix') }}" placeholder="600">
                  @error('prix')
                      <span class="text-danger ms-3 me-3">{{ $message }}</span>
                  @enderror
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-center ms-4 me-4">
              <div class="form-group w-50 m-3">
                <label for="unite">Unité</label>
                <select class="form-control @error('unite') is-invalid @enderror" name="unite" id="unite">
                  <option value="">Choisir l'unité</option>
                  <option {{ old('unite') == 'Mettre' ? 'selected' : '' }}>Mettre</option>
                  <option {{ old('unite') == 'Litre' ? 'selected' : '' }}>Litre</option>
                  <option {{ old('unite') == 'Piece' ? 'selected' : '' }}>Piece</option>
                  <option {{ old('unite') == 'Kilogramme' ? 'selected' : '' }}>Kilogramme</option>
                </select>
                @error('unite')
                    <span class="text-danger ms-3 me-3">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group w-50 m-3">
                  <label for="stock">Stock</label>
                  <input type="number" min="1" name="stock" value="{{ old('stock') }}" 
                        class="form-control mt-2 @error('stock') is-invalid @enderror" id="stock" placeholder="50">
                  @error('stock')
                      <span class="text-danger ms-3 me-3">{{ $message }}</span>
                  @enderror
              </div>
            </div>
            <div class="form-group mb-3 ms-4 me-5">
              <label class="ms-3 me-3" for="exampleFormControlTextarea1">Descriptions</label>
              <textarea class="form-control ms-3 me-5  @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="3">{{ old('description') }}</textarea>
              @error('description')
                <span class="text-danger ms-3 me-3">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group ms-4 me-4 mb-3 d-flex justify-content-center align-items-center">
                <div>
                    <button type="submit" class="btn btn-primary me-5">Enregistrer</button>
                </div>
                <div>
                    <a class="link-underline text-white btn btn-primary" href="{{ route('btps.index')}}">Accueil</a>
                </div>
            </div>
          </form>
    </div>
@endsection