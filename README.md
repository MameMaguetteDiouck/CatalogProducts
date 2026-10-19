# 📦 CatalogProducts — Catalogue Produits NoSQL (Laravel & MongoDB)

Application web de gestion et vitrine de catalogue produits multi-catégories, construite avec **Laravel 13**, **PHP 8.5** et **MongoDB 7.0 (NoSQL)**.

Ce projet démontre la modélisation et l'exploitation d'une base orientée documents (MongoDB) au sein de l'écosystème Laravel via le driver officiel `mongodb/laravel-mongodb`, avec gestion polymorphique des attributs produits (alimentaire, électronique, habillement, cosmétique, BTP).

---

## 🚀 Fonctionnalités Clés

- **Architecture NoSQL Polymorphique** : Modélisation d'une collection unique `products` capable d'accueillir dynamiquement des attributs hétérogènes selon la catégorie (garantie, taille, unité, marque, contenance).
- **Vitrine & CRUD Complet** : Consultation publique, pagination, filtrage dynamique par catégorie, recherche textuelle et interface d'administration protégée.
- **Support Images & Fallback SVG** : Upload automatique avec redimensionnement/nettoyage et génération d'un badge vectoriel dynamique en cas d'absence de visuel.
- **Double Environnement Docker** :
  - **Option 1 (Full Stack)** : Application Laravel + MongoDB 7 + Mongo Express entièrement conteneurisés.
  - **Option 2 (DB & Outils)** : MongoDB 7 + Mongo Express sous Docker, exécution rapide de Laravel sur la machine hôte.

---

## 🛠️ Stack Technique

| Composant | Technologie | Version |
| :--- | :--- | :--- |
| **Framework** | Laravel | 13.x |
| **Langage** | PHP (CLI & FPM) | 8.5+ |
| **Base de données** | MongoDB Server | 7.0 |
| **Driver NoSQL** | `mongodb/laravel-mongodb` (`ext-mongodb`) | 5.11+ / ext 2.5+ |
| **Interface DB** | Mongo Express | Latest |
| **Conteneurs** | Docker Compose | v2+ |

---

## 👤 Identifiants & Comptes par Défaut

Après exécution des migrations et des seeders (`php artisan db:seed`), les comptes suivants sont automatiquement injectés en base :

### 1. Application Web (Laravel)
- **URL locale** : [http://localhost:8000](http://localhost:8000)

| Rôle | Adresse E-mail | Mot de passe | Description |
| :--- | :--- | :--- | :--- |
| **Administrateur** | `admin@catalog.local` | `Password123!` | Accès complet aux ajouts, modifications et suppressions |
| **Utilisateur Démo** | `demo@catalog.local` | `Password123!` | Compte de test standard |

### 2. Interface Mongo Express
- **URL** : [http://localhost:8081](http://localhost:8081)
- **Identifiant** : `admin`
- **Mot de passe** : `P@ssword123`

---

## 🏁 Démarrage Rapide

### Option A : Exécution Locale avec MongoDB sous Docker (Recommandé en Dev)

1. **Cloner le projet et entrer dans le dossier** :
   ```bash
   git clone <repo-url> CatalogProducts
   cd CatalogProducts
   ```

2. **Installer les dépendances PHP et Node** :
   ```bash
   composer install
   npm install
   ```

3. **Configurer l'environnement** :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Démarrer MongoDB et Mongo Express** :
   ```bash
   docker compose -f docker-compose.db.yml up -d
   ```

5. **Exécuter les migrations et le jeu d'essai** :
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Lancer le serveur de développement** :
   ```bash
   php artisan serve
   ```

---

### Option B : Environnement 100% Docker

1. **Démarrer l'ensemble des conteneurs** :
   ```bash
   docker compose up -d --build
   ```

2. **Exécuter les migrations et le seeder dans le conteneur** :
   ```bash
   docker compose exec app php artisan migrate --seed
   ```

---

## 🧪 Tests Automatisés

Pour exécuter la suite de tests avec PHPUnit :
```bash
php artisan test
```

---

## 📁 Structure du Projet

```text
app/
├── Enums/
│   └── ProductCategory.php       # Définition des 5 catégories et de leurs attributs dynamiques
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php # Contrôleur RESTful unifié
│   └── Requests/
│       ├── StoreProductRequest.php
│       └── UpdateProductRequest.php
├── Models/
│   ├── Product.php               # Modèle Eloquent MongoDB (scopes, attributs virtuels, fallback SVG)
│   └── User.php                  # Modèle utilisateur authentifiable MongoDB
└── Services/
    └── ImageService.php          # Gestion sécurisée du stockage d'images

database/
├── migrations/                   # Schémas et index MongoDB (email_unique, libelle_unique, type_index)
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php            # Administrateur et compte démo
    └── ProductSeeder.php         # Catalogue d'exemple réaliste par catégorie
```

---

## 📄 Licence
Ce projet est open-source et sous licence [MIT](LICENSE).
