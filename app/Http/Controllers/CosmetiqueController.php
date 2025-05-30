<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CosmetiqueController extends Controller
{
    protected $way = 'public/images/cosmos/';
    public function index()
    {
        $cosmos = Product::where('type', "cosmetiques")->orderBy('libelle')->get();
        return view('products.cosmetiques.index', compact('cosmos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.cosmetiques.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255|unique:products',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'marque' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'type' => 'required',
        ]);

        try {
            $data['image'] = ImageService::traitementImg($request->file('image'), $this->way);
            Product::create($data);
        } catch (\Throwable $th) {
            return back()->with('error', "une erreur s'est produite...");
        }
        return redirect()->route('cosmetiques.index')->with('success', "Enregistrement réussi...");
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
        $cosmo = Product::findOrFail($id);
        return view('products.cosmetiques.edit', compact('cosmo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'marque' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $cosmo = Product::findOrFail($id);
        try {
            if($file = $request->file('image'))
            {
                ImageService::deleteImg($cosmo->image);
                $request->validate([
                    'image' =>'required|mimes:png,jpg,jpeg,webp|max:2048',
                ]);
                $data['image'] = ImageService::traitementImg($file, $this->way);
            }
            $cosmo->update($data);
        } catch (\Throwable $th) {
            return redirect()->route('cosmetiques.index')->with('error', "une erreur s'est produite lors de la modification...");
        }
        return redirect()->route('cosmetiques.index')->with('success', "Modification réussie...");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cosmo = Product::findOrFail($id);

        $cosmo->delete();
        try {
            $cosmo->delete();
        } catch (\Throwable $th) {
            return redirect()->route('cosmetiques.index')->with('error', "une erreur s'est produite lors de la supression...");
        }
        return redirect()->route('cosmetiques.index')->with('success', "Supression réussie...");
    }
}
