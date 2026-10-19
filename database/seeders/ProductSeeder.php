<?php

namespace Database\Seeders;

use App\Enums\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds with rich authentic Senegalese products in FCFA.
     */
    public function run(): void
    {
        // Nettoyage préalable pour garantir un jeu d'essai propre
        Product::truncate();

        $products = [
            // ================= 1. ALIMENTATION (TERROIR & QUOTIDIEN SÉNÉGALAIS) =================
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Riz Brisé Parfumé « Sadia » 50kg',
                'prix' => 22500,
                'stock' => 120,
                'unite' => 'sac de 50kg',
                'quantite' => 50,
                'categorie' => 'Céréales & Riz',
                'description' => 'Riz brisé 100% parfumé de qualité supérieure, idéal pour le traditionnel Thiéboudienne et les grands repas de famille.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Huile d’Arachide Raffinée Pure « Niani » 5L',
                'prix' => 6500,
                'stock' => 85,
                'unite' => 'bidon de 5L',
                'quantite' => 5,
                'categorie' => 'Huiles & Condiments',
                'description' => 'Huile d’arachide pure produite au bassin arachidier du Sénégal, riche en vitamine E et résistante aux hautes températures.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Café Touba Moulu aux Épices Djar « Awa » 500g',
                'prix' => 1500,
                'stock' => 200,
                'unite' => 'sachet de 500g',
                'quantite' => 500,
                'categorie' => 'Boissons chaudes',
                'description' => 'Mélange traditionnel de café robusta torréfié artisanalement et aromatisé au poivre de Selim (Djar) et clous de girofle.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Pack Ingrédients Thiéboudienne Terroir (Guedj, Yët, Tamarin)',
                'prix' => 4500,
                'stock' => 65,
                'unite' => 'pack de 1kg',
                'quantite' => 1,
                'categorie' => 'Épicerie locale',
                'description' => 'Sélection des indispensables de la gastronomie sénégalaise : poisson séché Guedj Kong, mollusque séché Yët et tamarin acidulé de Casamance.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Mil Décortiqué Souna du Sine-Saloum 5kg',
                'prix' => 3200,
                'stock' => 90,
                'unite' => 'sac de 5kg',
                'quantite' => 5,
                'categorie' => 'Céréales locales',
                'description' => 'Mil local bio décortiqué avec soin, parfait pour la préparation du Thiéré (couscous sénégalais), Lakh ou bouillie matinale Arraw.',
            ],
            [
                'type' => ProductCategory::ALIMENTS->value,
                'libelle' => 'Sirop de Bissap Rouge Pasteurisé de Dakar 1L',
                'prix' => 1200,
                'stock' => 180,
                'unite' => 'bouteille de 1L',
                'quantite' => 1,
                'categorie' => 'Jus & Sirops',
                'description' => 'Boisson désaltérante 100% naturelle à base de fleurs d’hibiscus sabdariffa récoltées au Sénégal, infusée à la menthe fraîche.',
            ],

            // ================= 2. ÉLECTRONIQUE (RÉFÉRENCES POPULAIRES AU SÉNÉGAL) =================
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Téléviseur Smart TV 55" Crystal UHD 4K',
                'prix' => 345000,
                'stock' => 15,
                'marque' => 'Samsung',
                'garantie' => '24 mois',
                'description' => 'Écran 55 pouces 4K HDR avec processeur Crystal 4K, Wi-Fi intégré, compatible Netflix, YouTube et récepteur satellite intégré.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Réfrigérateur Double Porte No-Frost Tropicalisé 320L',
                'prix' => 420000,
                'stock' => 10,
                'marque' => 'LG',
                'garantie' => '36 mois',
                'description' => 'Compresseur Smart Inverter ultra-économe conçu pour résister au climat chaud de Dakar, éclairage LED et clayettes en verre trempé.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Climatiseur Inverter Tropicalisé 12 000 BTU T3',
                'prix' => 215000,
                'stock' => 22,
                'marque' => 'Midea',
                'garantie' => '24 mois',
                'description' => 'Climatiseur split haute performance capable de refroidir même à 52°C extérieur, gaz R410A écologique et mode Turbo.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Smartphone Spark 20 Pro 256Go / 8Go RAM',
                'prix' => 115000,
                'stock' => 35,
                'marque' => 'Tecno',
                'garantie' => '13 mois',
                'description' => 'Appareil photo ultra-clair 108 MP, batterie 5000 mAh avec charge rapide 33W, processeur Helio G99 et double haut-parleur stéréo.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Régulateur Onduleur de Tension Automatique 1500VA',
                'prix' => 85000,
                'stock' => 28,
                'marque' => 'APC',
                'garantie' => '24 mois',
                'description' => 'Protection indispensable contre les variations de tension et coupures intempestives sur le réseau électrique dakarois.',
            ],
            [
                'type' => ProductCategory::ELECTRONIQUE->value,
                'libelle' => 'Ventilateur Rechargeable Solaire 16" avec Télécommande',
                'prix' => 38000,
                'stock' => 45,
                'marque' => 'Sonashi',
                'garantie' => '12 mois',
                'description' => 'Ventilateur autonome avec batterie lithium intégrée (autonomie 8 heures), port USB de recharge pour téléphone et panneau solaire inclus.',
            ],

            // ================= 3. HABILLEMENT & TEXTILE SÉNÉGALAIS =================
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Grand Boubou 3 Pièces Bazin Riche Getzner Brodé',
                'prix' => 85000,
                'stock' => 20,
                'marque' => 'Getzner',
                'taille' => 'XL',
                'description' => 'Tenue d’apparat traditionnelle sénégalaise en authentique Bazin autrichien Getzner, broderie fil de soie ton sur ton par les maîtres tailleurs de Dakar.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Ensemble Kaftan Moderne 2 Pièces Lin et Soie',
                'prix' => 45000,
                'stock' => 30,
                'marque' => 'Touba Design',
                'taille' => 'L',
                'description' => 'Coupe slim moderne adaptée aux journées chaudes et prières du vendredi, tissu lin respirant avec encolure travaillée.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Robe Festive Mame Boye en Tissu Woodin Sénégal',
                'prix' => 32000,
                'stock' => 25,
                'marque' => 'Woodin',
                'taille' => 'M',
                'description' => 'Robe fluide et élégante aux motifs géométriques chaleureux, 100% coton de qualité supérieure, coupe cintrée et manches volantées.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Sandales Artisanales en Cuir Véritable de Ngaye Mékhé',
                'prix' => 15000,
                'stock' => 60,
                'marque' => 'Ngaye Cuir',
                'taille' => '43',
                'description' => 'Chaussures traditionnelles confectionnées à la main par les cordonniers réputés de Ngaye Mékhé, semelle cuir robuste et lanières tressées.',
            ],
            [
                'type' => ProductCategory::HABILLEMENTS->value,
                'libelle' => 'Chéchia Traditionnelle Rouge Brodée Fil Doré',
                'prix' => 7500,
                'stock' => 50,
                'marque' => 'Fass Artisanat',
                'taille' => 'Unique',
                'description' => 'Couvre-chef sénégalais classique en feutre dense de laine, broderie dorée artisanale raffinée pour cérémonies et fêtes religieuses.',
            ],

            // ================= 4. COSMÉTIQUES & SOINS NATURELS =================
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Beurre de Karité Brut Non Raffiné de Tambacounda 500g',
                'prix' => 3500,
                'stock' => 120,
                'marque' => 'Karité Teranga',
                'unite' => 'pot de 500g',
                'quantite' => 500,
                'categorie' => 'Soins du corps',
                'description' => 'Beurre végétal pur extrait à la main par des coopératives de femmes de Tambacounda, hydratation intense des peaux sèches et pointes de cheveux.',
            ],
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Huile Pure de Baobab Végétale Première Pression 100ml',
                'prix' => 6000,
                'stock' => 70,
                'marque' => 'BioDakar',
                'unite' => 'flacon de 100ml',
                'quantite' => 100,
                'categorie' => 'Huiles précieuses',
                'description' => 'Élixir anti-âge et réparateur naturel issu des graines de l’arbre emblématique du Sénégal, absorption rapide sans film gras.',
            ],
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Savon Noir Artisanal au Miel de Casamance et Curcuma',
                'prix' => 1800,
                'stock' => 190,
                'marque' => 'Miel & Nature',
                'unite' => 'pain de 150g',
                'quantite' => 150,
                'categorie' => 'Savons & Hygiène',
                'description' => 'Nettoyant visage et corps purifiant, élimine les impuretés, atténue les taches pigmentaires et illumine naturellement le teint.',
            ],
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Sérum Capillaire Fortifiant au Chébé et Ricin 120ml',
                'prix' => 7500,
                'stock' => 85,
                'marque' => 'Nappy Sénégal',
                'unite' => 'flacon de 120ml',
                'quantite' => 120,
                'categorie' => 'Soins capillaires',
                'description' => 'Traitement fortifiant pour cheveux crépus, frisés et tressés, stimule la pousse des tempes et prévient la casse de la fibre.',
            ],
            [
                'type' => ProductCategory::COSMETIQUES->value,
                'libelle' => 'Thiouraye Traditionnel Dakarois « Gowe & Musc » 200g',
                'prix' => 5000,
                'stock' => 100,
                'marque' => 'Khaly Thiouraye',
                'unite' => 'bocal de 200g',
                'quantite' => 200,
                'categorie' => 'Encens & Senteurs',
                'description' => 'Encens d’intérieur ancestral macéré aux huiles orientales précieuses et bois de santal, diffuse une ambiance chaleureuse et apaisante.',
            ],

            // ================= 5. BTP & MATÉRIAUX DE CONSTRUCTION =================
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Ciment Pouzzolane CEM II 42.5 Haute Résistance 50kg',
                'prix' => 4300,
                'stock' => 600,
                'unite' => 'sac de 50kg',
                'quantite' => 50,
                'description' => 'Ciment gris haute qualité de la cimenterie de Rufisque (Sococim), idéal pour fondations, dalles armées et bétons de structure.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Ciment 3X Falcon CEM II 32.5 Dangote 50kg',
                'prix' => 4100,
                'stock' => 500,
                'unite' => 'sac de 50kg',
                'quantite' => 50,
                'description' => 'Ciment hydraulique polyvalent conçu pour crépis, maçonnerie de parpaings et chapes courantes, excellente ouvrabilité.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Barre de Fer à Béton Haute Adhérence FeE500 Ø12mm 12m',
                'prix' => 5800,
                'stock' => 350,
                'unite' => 'barre de 12m',
                'quantite' => 12,
                'description' => 'Acier cranté certifié aux normes UEMOA pour armatures de poteaux, poutres et chaînages de bâtiments à étages.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Peinture Extérieure Acrylique Façade Sahélienne « Seigneurie » 25kg',
                'prix' => 38000,
                'stock' => 45,
                'unite' => 'fût de 25kg',
                'quantite' => 25,
                'description' => 'Peinture microporeuse lessivable résistant aux UV intenses et à la poussière d’harmattan, pouvoir couvrant exceptionnel.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Câble Électrique Cuivre Rigide U1000 R2V 3x2.5mm² 100m',
                'prix' => 34500,
                'stock' => 65,
                'unite' => 'rouleau de 100m',
                'quantite' => 100,
                'description' => 'Câble d’alimentation certifié conforme Senelec pour circuits de prises de courant et climatisation domestique ou tertiaire.',
            ],
            [
                'type' => ProductCategory::BTPS->value,
                'libelle' => 'Brouette de Chantier Renforcée avec Roue Increvable',
                'prix' => 28000,
                'stock' => 40,
                'unite' => 'pièce',
                'quantite' => 1,
                'description' => 'Châssis tubulaire monobloc en acier peint époxy, cuve emboutie 90 litres et roue pleine increvable pour terrains sablonneux.',
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
