<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class AlimentController extends Controller
{
     private $way = 'public/images/aliments/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aliments = Product::where('type', 'aliments')->orderBy('libelle', 'asc')->get();
        return view('products.aliments.index', compact('aliments'));

    }

    public function create()
    {
        return view('products.aliments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255|unique:products',
            'categorie' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'stock' => 'required|integer',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
            'type' => 'required',
        ]);
        try {
            $data['image'] = ImageService::traitementImg($request->file('image'), $this->way);
            Product::create($data);
        } catch (\Throwable $th) {
            return back()->with('erreur', "Une erreur s'est produit lors de l'enregistrement.");
        }

        return redirect()->route('aliments.index')->with('success', 'Enregistrement réussi');

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $aliment = Product::find($id);
        return view('products.aliments.edit', compact('aliment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'stock' => 'required|integer',
            'quantite' => 'required|integer',
            'prix' => 'required|numeric',
        ]);
        $product = Product::findOrFail($id);
        try {
            if($file = $request->file('image'))
            {
                ImageService::deleteImg($product->image);
                $request->validate([
                    'image' =>'required|mimes:png,jpg,jpeg,webp|max:2048',
                ]);
                $data['image'] = ImageService::traitementImg($file, $this->way);
            }
            $product->update($data);
        } catch (\Throwable $th) {
            dd($th);
            return back()->withInput()->with('erreur', "Une erreur s'est produit lors de la modification.");
        }

        return redirect()->route('aliments.index')->with('success', 'Modification réussie...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        try {
            ImageService::deleteImg($product->image);
            $product->delete();

        } catch (\Throwable $th) {
            return back()->withInput()->with('error', "Une erreur s'est produite...");
        }
        return redirect()->route('aliments.index')->with('success', "Le Produit a bien été supprimé...");
    }
}
