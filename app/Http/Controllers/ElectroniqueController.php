<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ImageService;

class ElectroniqueController extends Controller
{
    protected $way = 'public/images/electros/';
    public function index()
    {
        $electros = Product::where('type', 'electronique')->orderBy('libelle')->get();
        return view('products.electroniques.index', compact('electros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.electroniques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255|unique:products',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'type' => 'required:string:max:255',
            'garantie' => 'required:string:max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        try {
            $data['image'] = ImageService::traitementImg($request->file('image'), $this->way);
            Product::create($data);
        } catch (\Throwable $th) {
            return redirect()->route('electroniques.index')->with('error', "Une erreur s'est produite...");
        }
        return redirect()->route('electroniques.index')->with('success', "Enregistrement réussi..."); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $electro = Product::findOrFail($id);
        return view('products.electroniques.edit', compact('electro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'stock' => 'required|integer',
            'garantie' => 'required:string:max:255',
            'description' => 'required|string|max:1000',
        ]);
        $electro = Product::findOrFail($id);
        try {
            if($file = $request->file('image'))
            {
                ImageService::deleteImg($electro->image);
                $request->validate([
                    'image' =>'required|mimes:png,jpg,jpeg,webp|max:2048',
                ]);
                $data['image'] = ImageService::traitementImg($file, $this->way);
            }
            $electro->update($data);
        } catch (\Throwable $th) {
            dd($th);
            return back()->withInput()->with('erreur', "Une erreur s'est produit lors de la modification.");
        }
        return redirect()->route('electroniques.index')->with('success', "Mis-à-jour réussie...");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $electro = Product::findOrFail($id);
            $electro->delete();
        } catch (\Throwable $th) {
            return back()->with('error',  "Une erreur s'est produite lors de la suppression...");
        }
        return redirect()->route('electroniques.index')->withInput()->with('success', "Supression effectuée avec succès");
    }
}
