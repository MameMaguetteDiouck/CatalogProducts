<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'libelle',
        'prix',
        'stock',
        'quantite',
        'unite',
        'categorie',
        'description',
        'garantie',
        'marque',
        'taille',
        'type',
        'image',
    ];

    public function imageUrl():string
    {
        return Storage::url($this->image);
    }

    public function countProduct($type): int
    {
        $count = 0;
        for ($i=0; $i < $this->count() - 1; $i++) { 
            if ($this[$i]->type == $type) {
                $count += 1;
            }
        }
        return $count;
    }
}
