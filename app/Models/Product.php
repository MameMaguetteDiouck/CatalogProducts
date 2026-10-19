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
     * Returns a clean, lightweight SVG placeholder displaying the product name and initials.
     */
    protected function defaultPlaceholder(): string
    {
        $label = htmlspecialchars($this->libelle ?? 'Produit', ENT_QUOTES, 'UTF-8');

        // Extract initials from product title (e.g. "Riz Brisé" -> "RB")
        $words = preg_split('/\s+/', trim($this->libelle ?? 'CP'));
        $initials = '';
        if (!empty($words[0])) {
            $initials .= mb_substr($words[0], 0, 1);
        }
        if (!empty($words[1])) {
            $initials .= mb_substr($words[1], 0, 1);
        }
        $initials = strtoupper(htmlspecialchars($initials ?: 'CP', ENT_QUOTES, 'UTF-8'));

        $colorMap = [
            'aliments' => ['bg' => '#ecfdf5', 'accent' => '#059669', 'badge' => '#d1fae5'],
            'electronique' => ['bg' => '#f0f9ff', 'accent' => '#0284c7', 'badge' => '#e0f2fe'],
            'habillements' => ['bg' => '#fffbeb', 'accent' => '#d97706', 'badge' => '#fef3c7'],
            'cosmetiques' => ['bg' => '#f5f3ff', 'accent' => '#7c3aed', 'badge' => '#ede9fe'],
            'btps' => ['bg' => '#f1f5f9', 'accent' => '#475569', 'badge' => '#e2e8f0'],
        ];

        $theme = $colorMap[$this->type] ?? ['bg' => '#f8fafc', 'accent' => '#4f46e5', 'badge' => '#eef2ff'];

        // Truncate name if too long for clean SVG fit
        $displayName = mb_strlen($label) > 30 ? mb_substr($label, 0, 28) . '...' : $label;

        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="260" viewBox="0 0 400 260">
            <rect width="100%" height="100%" fill="{$theme['bg']}"/>
            <!-- Monogram badge -->
            <circle cx="200" cy="95" r="42" fill="{$theme['badge']}"/>
            <text x="200" y="105" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="24" font-weight="800" fill="{$theme['accent']}" text-anchor="middle">{$initials}</text>
            <!-- Product Name -->
            <text x="200" y="165" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="15" font-weight="700" fill="#0f172a" text-anchor="middle">{$displayName}</text>
            <text x="200" y="190" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="12" font-weight="500" fill="{$theme['accent']}" text-anchor="middle">Référence Catalogue</text>
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
