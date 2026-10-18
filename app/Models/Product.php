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
     * Returns a lightweight SVG placeholder encoded as data URI.
     */
    protected function defaultPlaceholder(): string
    {
        $label = htmlspecialchars($this->libelle ?? 'Produit', ENT_QUOTES, 'UTF-8');
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
            <rect width="100%" height="100%" fill="#f1f5f9"/>
            <text x="50%" y="45%" font-family="Arial, sans-serif" font-size="20" font-weight="bold" fill="#64748b" text-anchor="middle">{$label}</text>
            <text x="50%" y="60%" font-family="Arial, sans-serif" font-size="14" fill="#94a3b8" text-anchor="middle">Visuel non disponible</text>
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
