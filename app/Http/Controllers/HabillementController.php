<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class HabillementController extends Controller
{
    protected $way = 'public/images/habits/';
    public function index()
    {
        $habits = Product::where('type', "habillements")->orderBy('libelle')->get();
        return view('products.habillements.index', compact('habits'));
    }

    public function create()
    {
        return view('products.habillements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:500|unique:products',
            'prix' => 'required|numeric',
            'taille' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'marque' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'type' => 'required|string|max:255',
        ]);

        try {
            $data['image'] = ImageService::traitementImg($request->file('image'), $this->way);
            Product::create($data);
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('habillements.index')->with('success', "Enregistrement réussi...");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $habit = Product::findOrFail($id);
        return view('products.habillements.edit', compact('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:500',
            'prix' => 'required|numeric',
            'taille' => 'required|string|max:255',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'marque' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);
        $habit = Product::findOrFail($id);
        try {
            if($file = $request->file('image'))
            {
                ImageService::deleteImg($habit->image);
                $request->validate([
                    'image' =>'required|mimes:png,jpg,jpeg,webp|max:2048',
                ]);
                $data['image'] = ImageService::traitementImg($file, $this->way);
            }
            $habit->update($data);
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('habillements.index')->with('success', "Modification réussie...");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $habit = Product::findOrFail($id);
        try {
            ImageService::deleteImg($habit->image);
            $habit->delete();
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('habillements.index')->with('success', "Suppression réussie...");
    }
}
