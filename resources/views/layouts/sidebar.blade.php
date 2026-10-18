<div class="sidebar bg-primary">
    <div class="titleProject d-flex justify-content-center align-items-center py-3">
        <a href="{{ route('products.index') }}" class="text-white text-decoration-none">
            <h2 class="m-0 fw-bold">MyCatalog</h2>
        </a>
    </div>
    <div class="menu px-2">
        <nav class="nav flex-column text-white">
            <a class="nav-link text-white d-flex align-items-center mb-1" href="{{ route('products.index') }}">
                <i class="bi bi-grid me-2"></i> Catalogue Produits
            </a>
            <a class="nav-link text-white d-flex align-items-center mb-1" href="{{ route('products.create') }}">
                <i class="bi bi-plus-circle me-2"></i> Ajouter un produit
            </a>
            <a class="nav-link text-white-50 d-flex align-items-center mb-2" href="{{ route('home') }}">
                <i class="bi bi-shop me-2"></i> Vitrine Client
            </a>

            <div class="border-top border-white-50 my-2 pt-2">
                <span class="small text-uppercase text-white-50 px-3 fw-bold">Catégories NoSQL</span>
                @foreach (App\Enums\ProductCategory::cases() as $category)
                    <a class="nav-link text-white d-flex justify-content-between align-items-center py-1 {{ request('category') === $category->value ? 'fw-bold bg-white bg-opacity-25 rounded' : '' }}" 
                       href="{{ route('products.index', ['category' => $category->value]) }}">
                        <span>{{ $category->label() }}</span>
                        <span class="badge bg-light text-dark rounded-pill">{{ App\Models\Product::countForType($category->value) }}</span>
                    </a>
                @endforeach
            </div>
        </nav>
    </div>
    <div class="mt-auto p-3 text-center border-top border-white-50">
        <a href="#" class="btn btn-outline-light btn-sm w-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>