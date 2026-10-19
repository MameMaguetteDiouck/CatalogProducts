<?php

namespace App\Http\Requests;

use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryValues = ProductCategory::values();

        $rules = [
            'libelle' => ['required', 'string', 'max:255'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'type' => ['required', 'string', Rule::in($categoryValues)],
            'description' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];

        // Validation dynamique selon la catégorie NoSQL
        $type = $this->input('type');

        if ($type === ProductCategory::ALIMENTS->value) {
            $rules['unite'] = ['required', 'string', 'max:100'];
            $rules['quantite'] = ['required', 'integer', 'min:1'];
            $rules['categorie'] = ['nullable', 'string', 'max:100'];
        } elseif ($type === ProductCategory::ELECTRONIQUE->value) {
            $rules['garantie'] = ['required', 'string', 'max:100'];
            $rules['marque'] = ['nullable', 'string', 'max:100'];
        } elseif ($type === ProductCategory::HABILLEMENTS->value) {
            $rules['marque'] = ['required', 'string', 'max:100'];
            $rules['taille'] = ['nullable', 'string', 'max:50'];
        } elseif ($type === ProductCategory::COSMETIQUES->value) {
            $rules['marque'] = ['required', 'string', 'max:100'];
            $rules['unite'] = ['required', 'string', 'max:100'];
            $rules['quantite'] = ['nullable', 'integer', 'min:1'];
        } elseif ($type === ProductCategory::BTPS->value) {
            $rules['unite'] = ['required', 'string', 'max:100'];
        }

        return $rules;
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé du produit est obligatoire.',
            'prix.required' => 'Le prix est obligatoire.',
            'stock.required' => 'La quantité en stock est obligatoire.',
            'type.required' => 'La catégorie est obligatoire.',
            'type.in' => 'La catégorie sélectionnée est invalide.',
            'garantie.required' => 'La durée de garantie est requise pour les produits électroniques.',
            'marque.required' => 'La marque est obligatoire pour cette catégorie.',
            'unite.required' => "L'unité de mesure est obligatoire.",
            'image.image' => 'Le fichier doit être une image valide.',
            'image.max' => "L'image ne doit pas dépasser 2 Mo.",
        ];
    }
}
