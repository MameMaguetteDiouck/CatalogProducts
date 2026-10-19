<?php

namespace App\Enums;

enum ProductCategory: string
{
    case ALIMENTS = 'aliments';
    case ELECTRONIQUE = 'electronique';
    case HABILLEMENTS = 'habillements';
    case COSMETIQUES = 'cosmetiques';
    case BTPS = 'btps';

    public function label(): string
    {
        return match ($this) {
            self::ALIMENTS => 'Alimentaire',
            self::ELECTRONIQUE => 'Électronique',
            self::HABILLEMENTS => 'Habillement',
            self::COSMETIQUES => 'Cosmétique',
            self::BTPS => 'BTP & Matériaux',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ALIMENTS => 'bi-basket',
            self::ELECTRONIQUE => 'bi-laptop',
            self::HABILLEMENTS => 'bi-tag',
            self::COSMETIQUES => 'bi-stars',
            self::BTPS => 'bi-tools',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function specificAttributes(): array
    {
        return match ($this) {
            self::ALIMENTS => ['categorie', 'unite', 'quantite'],
            self::ELECTRONIQUE => ['garantie'],
            self::HABILLEMENTS => ['marque', 'taille'],
            self::COSMETIQUES => ['marque', 'unite', 'quantite'],
            self::BTPS => ['unite'],
        };
    }
}
