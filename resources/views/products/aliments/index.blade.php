@extends('layouts.app')

@section('content')

<div class="w-100 m-5 h-75 text-black d-flex justify-content-center ">
    <div class="w-100 m-3 pb-5">
        <div class="w-100 justify-content-end d-flex m-4">
            <a class="btn btn-primary" href="{{route('aliments.create')}}">Ajouter un aliment</a>
        </div>
        <table class="table text-black w-100 p-0"  id="myTable">
            <thead>
                <th>
                    <td>Libelle</td>
                    <td>Prix</td>
                    <td>Quantite</td>
                    <td>stock</td>
                    <td>categorie</td>
                    <td>Action</td>
                </th>
            </thead>
            <tbody>
                @foreach ($aliments as $aliment)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $aliment->libelle }}</td>
                        <td>{{ $aliment->prix }} FrancCFA</td>
                        <td>{{ $aliment->quantite }} {{$aliment->unite}}</td>
                        <td>{{ $aliment->stock }}</td>
                        <td>{{ $aliment->categorie }}</td>
                        <td>
                            <button type="button" class="btn btn-white border-0" data-bs-toggle="modal" data-bs-target="#delete-{{$aliment->id}}"><i class="bi bi-trash3 text-black me-2"></i></button>
                            <a href="{{route('aliments.edit', [$aliment->id])}}"><i class="bi bi-pencil-square text-black ms-2"></i></a>
                        </td>
                    </tr>
                @endforeach
            <tfoot>
                <th>
                    <td>Libelle</td>
                    <td>Prix</td>
                    <td>Quantite</td>
                    <td>stock</td>
                    <td>categorie</td>
                    <td>Action</td>
                </th>
            </tfoot>
        </table>
    </div>
</div>
@endsection
@foreach ($aliments as $aliment)
    <div class="modal fade" id="delete-{{$aliment->id}}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression d'un produi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ce produit sera supprimé définitivement. </br>
                Voulez-vous supprimer le produit {{$aliment->libelle}} ??!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{route('aliments.destroy', [$aliment->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endforeach