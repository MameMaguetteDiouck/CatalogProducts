<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BtpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $btps = Product::where('type', "btps")->get();
        return view('products.btps.index', compact('btps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.btps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'libelle' => 'required|string|max:500|unique:products',
            'prix' => 'required|numeric',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'description' => 'required|string|max:1000',
'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        try {
            Product::create($data);
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('btps.index')->with('success', "Enregistrement réussi...");
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
        $btp = Product::findOrFail($id);
        return view('products.btps.edit', compact('btp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:500',
            'prix' => 'required|numeric',
            'unite' => 'required|string|max:255',
            'stock' => 'required|integer',
            'description' => 'required|string|max:1000',
'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        $btp = Product::findOrFail($id);
        try {
            $btp->update($data);
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('btps.index')->with('success', "Modification réussie...");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $btp = Product::findOrFail($id);
        try {
            $btp->delete();
        } catch (\Throwable $th) {
            return back()->with('error', "Une erreur est survenue...");
        }
        return redirect()->route('btps.index')->with('success', "Suppression réussie...");
    }
}
