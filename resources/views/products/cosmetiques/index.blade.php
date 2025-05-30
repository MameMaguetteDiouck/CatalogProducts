@extends('layouts.app')

@section('content')

<div class="w-100 m-5 h-75 text-black d-flex justify-content-center ">
    <div class="w-100 m-3 pb-5">
        <div class="w-100 justify-content-end d-flex m-4">
            <a class="btn btn-primary" href="{{route('cosmetiques.create')}}">Ajouter un produit cosmétique</a>
        </div>
        <table class="table text-black w-100 p-0"  id="myTable">
            <thead>
                <tr>
                    <th></th>
                    <th>libelle</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                    <th>Stock</th>
                    <th>Marque</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cosmos as $cosmo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cosmo->libelle }}</td>
                    <td>{{ $cosmo->prix }} FrancCFA</td>
                    <td>{{ $cosmo->quantite }} {{ $cosmo->unite }}</td>
                    <td>{{ $cosmo->stock }}</td>
                    <td>{{ $cosmo->marque }}</td>
                    <td>
                        <button type="button" class="btn btn-white border-0" data-bs-toggle="modal" data-bs-target="#delete-{{$cosmo->id}}"><i class="bi bi-trash3 text-black me-2"></i></button>
                        <a href="{{route('cosmetiques.edit', [$cosmo->id])}}"><i class="bi bi-pencil-square text-black ms-2"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>libelle</th>
                    <th>Prix Unitaire</th>
                    <th>Quantite</th>
                    <th>Stock</th>
                    <th>Marque</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
@foreach ($cosmos as $cosmo)
    <div class="modal fade" id="delete-{{$cosmo->id}}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression d'un produi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ce produit sera supprimé définitivement. </br>
                Voulez-vous supprimer le produit {{$cosmo->libelle}} ??!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{route('cosmetiques.destroy', [$cosmo->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endforeach