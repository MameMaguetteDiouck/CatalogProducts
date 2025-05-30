@extends('layouts.app')

@section('content')
    <div class="w-100 d-flex justify-content-center align-items-center">
        <div class="w-100 m-5">
            <div class="w-100 m-3 pb-5">
                <div class="w-100 justify-content-end d-flex m-4">
                    <a class="btn btn-primary" href="{{route('electroniques.create')}}">Ajouter un appareil</a>
                </div>
            </div>
            <table class="table text-black w-100 p-0"  id="myTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Libelle</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Garantie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($electros as $electro)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $electro->libelle }}</td>
                            <td>{{ $electro->prix }}</td>
                            <td>{{ $electro->stock }}</td>
                            <td>{{ $electro->garantie }}</td>
                            <td>
                                <button type="button" class="btn btn-white border-0" data-bs-toggle="modal" data-bs-target="#delete-{{$electro->id}}"><i class="bi bi-trash3 text-black me-2"></i></button>
                                <a href="{{route('electroniques.edit', [$electro->id])}}"><i class="bi bi-pencil-square text-black ms-2"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Libelle</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Garantie</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

{{-- @foreach ($electros as $electro)
    <div class="modal fade" id="delete-{{$electro->id}}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suppression d'un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ce produit sera supprimé définitivement. </br>
                Voulez-vous supprimer le produit {{$electro->libelle}} ??!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{route('electroniques.destroy', [$electro->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">Supprimer</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endforeach --}}
@endsection