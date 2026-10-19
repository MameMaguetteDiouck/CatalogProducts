<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategory;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the public showcase / home catalog with optional search and category filters.
     */
    public function home(Request $request): View
    {
        $searchTerm = $request->query('search');
        $selectedCategory = $request->query('category');
        $categories = ProductCategory::cases();
        $productsByCategory = [];

        foreach ($categories as $cat) {
            if ($selectedCategory && $selectedCategory !== $cat->value) {
                continue;
            }

            $query = Product::ofType($cat->value);
            if ($searchTerm) {
                $query->search($searchTerm);
            }

            $productsByCategory[$cat->value] = $query->limit(12)->get();
        }

        $totalCount = Product::count();
        $inStockCount = Product::inStock()->count();
        $availabilityRate = $totalCount > 0 ? (int) round(($inStockCount / $totalCount) * 100) : 100;

        return view('welcome', compact(
            'categories',
            'productsByCategory',
            'searchTerm',
            'selectedCategory',
            'totalCount',
            'availabilityRate'
        ));
    }

    /**
     * Display a paginated listing of the products with search and category filters.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category') ?? $request->query('type');
        $searchTerm = $request->query('search') ?? $request->query('q');
        $stockStatus = $request->query('stock_status');

        $query = Product::query();

        if ($selectedCategory) {
            $query->ofType($selectedCategory);
        }

        if ($searchTerm) {
            $query->search($searchTerm);
        }

        if ($stockStatus === 'in_stock') {
            $query->inStock();
        } elseif ($stockStatus === 'out_of_stock') {
            $query->outOfStock();
        }

        $products = $query->orderBy('_id', 'desc')->paginate(12)->withQueryString();

        // Statistiques globales par catégorie pour le tableau de bord
        $categoryCounts = [];
        foreach (ProductCategory::cases() as $category) {
            $categoryCounts[$category->value] = [
                'label' => $category->label(),
                'icon' => $category->icon(),
                'count' => Product::countForType($category->value),
            ];
        }

        $totalCount = Product::count();
        $inStockCount = Product::inStock()->count();
        $outOfStockCount = Product::outOfStock()->count();
        $categories = ProductCategory::cases();

        return view('products.index', compact(
            'products',
            'categories',
            'selectedCategory',
            'searchTerm',
            'stockStatus',
            'categoryCounts',
            'totalCount',
            'inStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request): View
    {
        $selectedCategory = $request->query('type') ?? $request->query('category');
        $categories = ProductCategory::cases();

        return view('products.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Store a newly created product in MongoDB.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = ImageService::storeImage($request->file('image'));
        }

        Product::create($data);

        return redirect()->route('products.index', ['category' => $data['type']])
            ->with('success', 'Produit ajouté avec succès au catalogue.');
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::cases();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in MongoDB.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = ImageService::storeImage($request->file('image'), $product->image);
        }

        $product->update($data);

        return redirect()->route('products.index', ['category' => $product->type])
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Remove the specified product from MongoDB.
     */
    public function destroy(string $id): RedirectResponse
    {
        Gate::authorize('delete-product');

        $product = Product::findOrFail($id);

        if ($product->image) {
            ImageService::deleteImage($product->image);
        }

        $type = $product->type;
        $product->delete();

        return redirect()->route('products.index', ['category' => $type])
            ->with('success', 'Produit supprimé du catalogue.');
    }
}
