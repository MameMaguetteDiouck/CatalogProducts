<?php

namespace App\Models;

use App\Enums\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'products';

    /**
     * The attributes that are mass assignable.
     * Note: MongoDB allows flexible schema, but defining fillables ensures mass-assignment security.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'libelle',
        'prix',
        'stock',
        'description',
        'type',
        'image',
        // Attributs dynamiques NoSQL :
        'categorie',
        'unite',
        'quantite',
        'garantie',
        'marque',
        'taille',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'prix' => 'float',
            'stock' => 'integer',
            'quantite' => 'integer',
        ];
    }

    /**
     * Format price with West African CFA Franc (FCFA).
     */
    public function formattedPrice(): string
    {
        return number_format((float) ($this->prix ?? 0), 0, ',', ' ') . ' FCFA';
    }

    /**
     * Get the resolved URL for the product image or return an elegant SVG placeholder.
     */
    public function imageUrl(): string
    {
        if (empty($this->image)) {
            return $this->defaultPlaceholder();
        }

        if (Str::startsWith($this->image, ['http://', 'https://', 'data:'])) {
            return $this->image;
        }

        if (File::exists(public_path($this->image))) {
            return asset($this->image);
        }

        return $this->defaultPlaceholder();
    }

    /**
     * Returns a lightweight SVG placeholder tailored to the product category.
     */
    protected function defaultPlaceholder(): string
    {
        $colorMap = [
            'aliments' => ['bg' => '#ecfdf5', 'accent' => '#059669', 'icon' => '🫒', 'label' => 'Alimentaire'],
            'electronique' => ['bg' => '#f0f9ff', 'accent' => '#0284c7', 'icon' => '🎧', 'label' => 'Électronique'],
            'habillements' => ['bg' => '#fffbeb', 'accent' => '#d97706', 'icon' => '🧥', 'label' => 'Textile & Mode'],
            'cosmetiques' => ['bg' => '#f5f3ff', 'accent' => '#7c3aed', 'icon' => '🧴', 'label' => 'Cosmétiques'],
            'btps' => ['bg' => '#f1f5f9', 'accent' => '#475569', 'icon' => '🧱', 'label' => 'BTP & Matériaux'],
        ];

        $theme = $colorMap[$this->type] ?? ['bg' => '#f8fafc', 'accent' => '#4f46e5', 'icon' => '📦', 'label' => 'Catalogue'];

        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="260" viewBox="0 0 400 260">
            <rect width="100%" height="100%" fill="{$theme['bg']}"/>
            <circle cx="200" cy="100" r="45" fill="{$theme['accent']}" opacity="0.15"/>
            <text x="200" y="112" font-size="34" text-anchor="middle">{$theme['icon']}</text>
            <text x="200" y="170" font-family="-apple-system, system-ui, sans-serif" font-size="13" font-weight="700" fill="{$theme['accent']}" text-anchor="middle">{$theme['label']}</text>
            <text x="200" y="192" font-family="-apple-system, system-ui, sans-serif" font-size="11" fill="#64748b" text-anchor="middle">Référence certifiée</text>
        </svg>
        SVG;

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }

    /**
     * Scope to filter products by category type.
     */
    public function scopeOfType($query, ?string $type)
    {
        if (!empty($type)) {
            return $query->where('type', $type);
        }
        return $query;
    }

    /**
     * Scope to search products by text query.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            return $query->where('libelle', 'like', "%{$term}%")
                         ->orWhere('description', 'like', "%{$term}%")
                         ->orWhere('marque', 'like', "%{$term}%");
        }
        return $query;
    }

    /**
     * High performance category counter replacing old loop anti-pattern.
     */
    public static function countForType(string $type): int
    {
        return static::where('type', $type)->count();
    }
}
