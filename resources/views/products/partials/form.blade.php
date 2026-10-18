@php
    $isEdit = isset($product) && $product->exists;
    $selectedType = old('type', $product->type ?? ($selectedCategory ?? 'aliments'));
@endphp

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Veuillez corriger les erreurs ci-dessous :</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

<form action="{{ $isEdit ? route('products.update', $product->id) : route('products.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <!-- Catégorie (Déclencheur NoSQL) -->
        <div class="col-md-6">
            <label for="type" class="form-label fw-bold">Catégorie de produit <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required onchange="toggleCategoryAttributes(this.value)">
                @foreach (App\Enums\ProductCategory::cases() as $category)
                    <option value="{{ $category->value }}" {{ $selectedType === $category->value ? 'selected' : '' }}>
                        {{ $category->label() }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Libellé -->
        <div class="col-md-6">
            <label for="libelle" class="form-label fw-bold">Libellé / Nom <span class="text-danger">*</span></label>
            <input type="text" name="libelle" id="libelle" class="form-control @error('libelle') is-invalid @enderror" 
                   value="{{ old('libelle', $product->libelle ?? '') }}" required placeholder="Ex: Ordinateur portable HP">
            @error('libelle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix -->
        <div class="col-md-6">
            <label for="prix" class="form-label fw-bold">Prix (FCFA) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror" 
                   value="{{ old('prix', $product->prix ?? '') }}" required placeholder="Ex: 250000">
            @error('prix')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="col-md-6">
            <label for="stock" class="form-label fw-bold">Stock disponible <span class="text-danger">*</span></label>
            <input type="number" min="0" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" 
                   value="{{ old('stock', $product->stock ?? 1) }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="col-12">
            <label for="description" class="form-label fw-bold">Description complète <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                      required placeholder="Détails du produit...">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ================= ATTRIBUTS DYNAMIQUES NOSQL ================= -->
        <div class="col-12">
            <div class="p-3 bg-light rounded border">
                <h6 class="text-primary fw-bold mb-3">
                    <i class="bi bi-diagram-3 me-2"></i>Attributs spécifiques NoSQL (Polymorphisme)
                </h6>

                <!-- Aliments : Unité, Quantité, Sous-Catégorie -->
                <div id="attrs-aliments" class="category-attribute-group row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Unité de mesure <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex: Kg, Litre, Pièce">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantité par lot <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="quantite" class="form-control dynamic-input" 
                               value="{{ old('quantite', $product->quantite ?? 1) }}" placeholder="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sous-catégorie alimentaire</label>
                        <input type="text" name="categorie" class="form-control dynamic-input" 
                               value="{{ old('categorie', $product->categorie ?? '') }}" placeholder="Ex: Fruits & Légumes">
                    </div>
                </div>

                <!-- Électronique : Garantie, Marque -->
                <div id="attrs-electronique" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-6">
                        <label class="form-label">Durée de garantie <span class="text-danger">*</span></label>
                        <input type="text" name="garantie" class="form-control dynamic-input" 
                               value="{{ old('garantie', $product->garantie ?? '') }}" placeholder="Ex: 12 mois, 2 ans">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Marque constructeur</label>
                        <input type="text" name="marque" class="form-control dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex: Apple, Samsung, Sony">
                    </div>
                </div>

                <!-- Habillements : Marque, Taille -->
                <div id="attrs-habillements" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-6">
                        <label class="form-label">Marque / Créateur <span class="text-danger">*</span></label>
                        <input type="text" name="marque" class="form-control dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex: Nike, Zara, Lacoste">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Taille / Pointure</label>
                        <input type="text" name="taille" class="form-control dynamic-input" 
                               value="{{ old('taille', $product->taille ?? '') }}" placeholder="Ex: S, M, L, XL, 42">
                    </div>
                </div>

                <!-- Cosmétiques : Marque, Unité, Quantité -->
                <div id="attrs-cosmetiques" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-4">
                        <label class="form-label">Marque cosmétique <span class="text-danger">*</span></label>
                        <input type="text" name="marque" class="form-control dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex: L'Oréal, Nivea">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contenance / Unité <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex: 250ml, 50g">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantité</label>
                        <input type="number" min="1" name="quantite" class="form-control dynamic-input" 
                               value="{{ old('quantite', $product->quantite ?? 1) }}">
                    </div>
                </div>

                <!-- BTP : Unité -->
                <div id="attrs-btps" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-12">
                        <label class="form-label">Unité de vente BTP <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex: Sac de 50kg, Tonne, Mètre">
                    </div>
                </div>
            </div>
        </div>

        <!-- Image du produit -->
        <div class="col-12">
            <label for="image" class="form-label fw-bold">Image du produit</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <div class="form-text">Formats acceptés : PNG, JPG, JPEG, WEBP (Max 2 Mo).</div>
            @if ($isEdit && $product->image)
                <div class="mt-2 d-flex align-items-center">
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <span class="small text-muted">Image actuelle</span>
                </div>
            @endif
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Boutons d'action -->
        <div class="col-12 d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check2-circle me-1"></i> {{ $isEdit ? 'Mettre à jour le produit' : 'Enregistrer le produit' }}
            </button>
        </div>
    </div>
</form>

<script>
    function toggleCategoryAttributes(category) {
        document.querySelectorAll('.category-attribute-group').forEach(el => {
            el.classList.add('d-none');
            // Disable inputs in hidden sections so they don't submit invalid data
            el.querySelectorAll('input').forEach(input => input.disabled = true);
        });

        const activeGroup = document.getElementById('attrs-' + category);
        if (activeGroup) {
            activeGroup.classList.remove('d-none');
            activeGroup.querySelectorAll('input').forEach(input => input.disabled = false);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        if (typeSelect) {
            toggleCategoryAttributes(typeSelect.value);
        }
    });
</script>
