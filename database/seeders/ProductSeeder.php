<?php

namespace Database\Seeders;

use App\Enums\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Alimentaire
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Riz Basmati Impérial 5kg',
                'prix' => 14.50,
                'stock' => 85,
                'unite' => 'kg',
                'quantite' => 5,
                'description' => 'Riz blanc aromatique haut de gamme à grain long, idéal pour plats raffinés.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Huile d’Olive Vierge Extra Bio 1L',
                'prix' => 12.90,
                'stock' => 120,
                'unite' => 'litre',
                'quantite' => 1,
                'description' => 'Première pression à froid issue de vergers biologiques méditerranéens.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Café Arabica Pur Colombie 500g',
                'prix' => 8.75,
                'stock' => 60,
                'unite' => 'g',
                'quantite' => 500,
                'description' => 'Café torréfié artisanalement, notes délicates de cacao et de noisette.',
            ],

            // Électronique
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Casque Audio Sans-Fil ANC Pro',
                'prix' => 199.99,
                'stock' => 25,
                'marque' => 'AcoustiX',
                'garantie' => '24 mois',
                'description' => 'Réduction active de bruit hybride, autonomie 40 heures et recharge rapide USB-C.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Écran 27" 4K HDR UltraClarity',
                'prix' => 389.00,
                'stock' => 18,
                'marque' => 'VisionPlus',
                'garantie' => '36 mois',
                'description' => 'Dalle IPS professionnelle 99% sRGB, hub USB-C intégré 90W PD.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Clavier Mécanique RGB Hot-Swap',
                'prix' => 119.50,
                'stock' => 40,
                'marque' => 'TypeMaster',
                'garantie' => '24 mois',
                'description' => 'Switches tactiles lubrifiés en usine, châssis aluminium et triple connectivité.',
            ],

            // Habillements
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Veste Saharienne en Lin Naturel',
                'prix' => 89.90,
                'stock' => 32,
                'taille' => 'L',
                'marque' => 'Atelier Nord',
                'description' => 'Coupe ajustée moderne, tissu 100% lin respirant avec boutons en corne naturelle.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Sneakers Urbaines Minimalistes',
                'prix' => 110.00,
                'stock' => 45,
                'taille' => '42',
                'marque' => 'SoleCraft',
                'description' => 'Cuir pleine fleur italien et semelle amortissante en caoutchouc recyclé.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Pull Col Roulé Mérinos Extra-Fin',
                'prix' => 75.00,
                'stock' => 28,
                'taille' => 'M',
                'marque' => 'Loom & Weave',
                'description' => 'Laine mérinos australienne thermorégulatrice, finition douce sans démangeaison.',
            ],

            // Cosmétiques
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Sérum Éclat Vitamine C 30ml',
                'prix' => 34.00,
                'stock' => 90,
                'categorie' => 'Soin du visage',
                'description' => 'Formule concentrée à 15% de vitamine C pure et acide hyaluronique hydratant.',
            ],
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Eau de Parfum Boisée Ambrée 50ml',
                'prix' => 68.00,
                'stock' => 35,
                'categorie' => 'Parfumerie',
                'description' => 'Fragrance mixte élégante mêlant bois de cèdre, cardamome et vétiver d’Haïti.',
            ],

            // BTP
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Ciment Haute Résistance CEM II 32.5',
                'prix' => 9.20,
                'stock' => 300,
                'unite' => 'sac de 35kg',
                'quantite' => 35,
                'description' => 'Liant hydraulique polyvalent pour travaux de maçonnerie, fondations et bétons courants.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Pack 50 Vis Béton Haute Performance',
                'prix' => 28.50,
                'stock' => 70,
                'unite' => 'boîte de 50',
                'quantite' => 50,
                'description' => 'Ancrage direct sans cheville dans le béton armé, acier zingué anticorrosion.',
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['libelle' => $data['libelle']],
                $data
            );
        }
    }
}
