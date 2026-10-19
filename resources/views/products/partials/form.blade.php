@php
    $isEdit = isset($product) && $product->exists;
    $selectedType = old('type', $product->type ?? ($selectedCategory ?? 'aliments'));
@endphp

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <strong>Veuillez corriger les informations saisies :</strong>
        <ul class="mb-0 mt-2 small">
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
        <!-- Rayon / Univers -->
        <div class="col-md-6">
            <label for="type" class="form-label fw-semibold small text-muted text-uppercase">Rayon / Univers <span class="text-danger">*</span></label>
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
            <label for="libelle" class="form-label fw-semibold small text-muted text-uppercase">Désignation du produit <span class="text-danger">*</span></label>
            <input type="text" name="libelle" id="libelle" class="form-control @error('libelle') is-invalid @enderror" 
                   value="{{ old('libelle', $product->libelle ?? '') }}" required placeholder="Ex : Casque Audio Sans-Fil ANC Pro">
            @error('libelle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Prix -->
        <div class="col-md-6">
            <label for="prix" class="form-label fw-semibold small text-muted text-uppercase">Prix unitaire (FCFA) <span class="text-danger">*</span></label>
            <input type="number" step="1" min="0" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror" 
                   value="{{ old('prix', $product->prix ?? '') }}" required placeholder="Ex : 25000">
            @error('prix')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Stock -->
        <div class="col-md-6">
            <label for="stock" class="form-label fw-semibold small text-muted text-uppercase">Stock disponible <span class="text-danger">*</span></label>
            <input type="number" min="0" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" 
                   value="{{ old('stock', $product->stock ?? 1) }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="col-12">
            <label for="description" class="form-label fw-semibold small text-muted text-uppercase">Description détaillée <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                      required placeholder="Spécifications, usages, arguments de vente...">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Caractéristiques spécifiques dynamiques -->
        <div class="col-12">
            <div class="p-3 rounded-3 border" style="background: #f8fafc;">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center text-white rounded-2" 
                          style="width: 22px; height: 22px; background: #4f46e5; font-size: 0.75rem;">
                        <i class="bi bi-sliders"></i>
                    </span>
                    <h6 class="fw-bold text-dark m-0 small text-uppercase" style="letter-spacing: 0.5px;">
                        Caractéristiques spécifiques de l'univers
                    </h6>
                </div>

                <!-- Aliments -->
                <div id="attrs-aliments" class="category-attribute-group row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Unité de mesure <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex : kg, litre, gramme">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Quantité par unité <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="quantite" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('quantite', $product->quantite ?? 1) }}" placeholder="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Sous-catégorie alimentaire</label>
                        <input type="text" name="categorie" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('categorie', $product->categorie ?? '') }}" placeholder="Ex : Épicerie fine, Boissons">
                    </div>
                </div>

                <!-- Électronique -->
                <div id="attrs-electronique" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Durée de garantie <span class="text-danger">*</span></label>
                        <input type="text" name="garantie" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('garantie', $product->garantie ?? '') }}" placeholder="Ex : 24 mois, 3 ans">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Marque constructeur</label>
                        <input type="text" name="marque" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex : Sony, Apple, Bose">
                    </div>
                </div>

                <!-- Habillements -->
                <div id="attrs-habillements" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Marque / Créateur <span class="text-danger">*</span></label>
                        <input type="text" name="marque" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex : Atelier Nord, Nike">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Taille / Pointure</label>
                        <input type="text" name="taille" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('taille', $product->taille ?? '') }}" placeholder="Ex : S, M, L, XL, 42">
                    </div>
                </div>

                <!-- Cosmétiques -->
                <div id="attrs-cosmetiques" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Marque <span class="text-danger">*</span></label>
                        <input type="text" name="marque" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('marque', $product->marque ?? '') }}" placeholder="Ex : L'Oréal, Nivea">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Contenance / Format <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex : Flacon 50ml, Tube 100g">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Type de soin</label>
                        <input type="text" name="categorie" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('categorie', $product->categorie ?? '') }}" placeholder="Ex : Soin du visage, Parfumerie">
                    </div>
                </div>

                <!-- BTP -->
                <div id="attrs-btps" class="category-attribute-group row g-3 d-none">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Conditionnement / Unité <span class="text-danger">*</span></label>
                        <input type="text" name="unite" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('unite', $product->unite ?? '') }}" placeholder="Ex : Sac de 35kg, Palette, Mètre">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Quantité par unité</label>
                        <input type="number" min="1" name="quantite" class="form-control form-control-sm dynamic-input" 
                               value="{{ old('quantite', $product->quantite ?? 1) }}" placeholder="1">
                    </div>
                </div>
            </div>
        </div>

        <!-- Image du produit -->
        <div class="col-12">
            <label for="image" class="form-label fw-semibold small text-muted text-uppercase">Visuel du produit</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <div class="form-text small">Formats acceptés : WEBP, PNG, JPG (Max 2 Mo). En cas d'absence, un badge dynamique SVG sera généré.</div>
            @if ($isEdit && $product->image)
                <div class="mt-2 d-flex align-items-center">
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->libelle }}" class="img-thumbnail me-3 rounded-3" style="width: 72px; height: 72px; object-fit: contain;">
                    <span class="small text-muted">Visuel actuellement actif</span>
                </div>
            @endif
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Actions -->
        <div class="col-12 d-flex justify-content-between align-items-center pt-3 border-top mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Annuler
            </a>
            <button type="submit" class="btn btn-brand btn-sm">
                <i class="bi bi-check2-circle me-1"></i> {{ $isEdit ? 'Mettre à jour la fiche' : 'Créer la référence' }}
            </button>
        </div>
    </div>
</form>

<script>
    function toggleCategoryAttributes(category) {
        document.querySelectorAll('.category-attribute-group').forEach(el => {
            el.classList.add('d-none');
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
