<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function home()
    {
        $aliments = Product::where('type', "aliments")->limit(8)->get();
        $habits = Product::where('type', "habillements")->limit(8)->get();
        $cosmos = Product::where('type', "cosmetiques")->limit(8)->get();
        $electros = Product::where('type', "electronique")->limit(8)->get();
        $btps = Product::where('type', "btps")->limit(8)->get();
        $searches = '';
        return view('welcome', compact('aliments', 'habits','cosmos','electros','btps', 'searches'));
    }
    public function seeMore(string $type)
    {
        $searches = '';
        $products = Product::where('type', $type)->get();
        return view('products.index', compact('products', 'type', 'searches'));
    }

    public function index(){
        $products = Product::all();
        $count = $products->count();
        $data = [$products->where('type', 'aliments')->count(),$products->where('type', 'electronique')->count(),$products->where('type', 'habillements')->count(),$products->where('type', 'cosmetiques')->count(),$products->where('type', 'btps')->count()];
        $quantites = '';
        return view('home', compact('count', 'products', 'data'));
    }
    public function search(Request $request, $vue)
    {
        $data = $request->validate([
            'query' => 'required|string|min:2',
        ]);
        $query = $data['query'];
        $searches = Product::where('libelle', 'like', "%{$query}%")
            ->orWhere('prix', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->orWhere('categorie', 'like', "%{$query}%")
            ->orWhere('unite', 'like', "%{$query}%")
            ->orWhere('quantite', 'like', "%{$query}%")
            ->orWhere('marque', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
        
        return view('welcome', compact('searches'));
    }
}
