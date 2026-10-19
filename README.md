# 📦 CatalogPro — Plateforme de Catalogue Produits NoSQL (Laravel & MongoDB)

Application web moderne de gestion et vitrine de catalogue multi-secteurs, construite avec **Laravel 13**, **PHP 8.5** et **MongoDB 7.0 (NoSQL)**.

Ce projet démontre l'exploitation d'une base orientée documents (MongoDB) au sein de l'écosystème Laravel via le driver officiel `mongodb/laravel-mongodb`, combinée à une gouvernance des accès par rôles (RBAC), une authentification sans session serveur par cookies JWT HttpOnly, et une interface réactive soignée (Slate & Indigo).

---

## 🚀 Fonctionnalités Clés

### 1. Architecture NoSQL Polymorphique
- **Collection unique `products`** accueillant dynamiquement des attributs hétérogènes selon la catégorie :
  - **Alimentaire** : conditionnement, poids, unité.
  - **Électronique** : marque, durée de garantie constructeur.
  - **Habillement** : taille (S, M, L, XL), matière, marque.
  - **Cosmétique** : volume/contenance (ml), marque.
  - **BTP & Matériaux** : format, unité de vente (palette, sac, rouleau), marque.
- **Typage BSON Natif** : Conversion et persistance des stocks et prix sous forme d'entiers 64-bit BSON natifs, garantissant l'exactitude des requêtes d'agrégation et du filtrage des ruptures.

### 2. Sécurité & Authentification JWT
- **Authentification par Cookie JWT HttpOnly** : Tokens chiffrés et signés stockés en cookies sécurisés (`SameSite=Lax`, `Secure`, `HttpOnly`), imperméables aux injections XSS.
- **Politique de Premier Changement de Mot de Passe** : Les nouveaux comptes sont créés avec un flag `must_change_password`, redirigeant obligatoirement vers un écran dédié avant tout accès aux fonctionnalités.
- **Gestion du Profil & Mot de Passe** : Espace utilisateur sécurisé permettant la mise à jour des coordonnées et la rotation du mot de passe.
- **Désactivation des Flux SMTP Insécurisés** : Neutralisation des routes de réinitialisation par e-mail en environnement hors-production.

### 3. Contrôle d'Accès par Rôles (RBAC)
- **Administrateur** : Gouvernance complète de l'équipe (création, modification, suppression de comptes), gestion totale du catalogue et suppression définitive de références.
- **Manager** : Consultation, création et mise à jour des fiches produits sans droit de suppression ni gestion des utilisateurs.
- **Visiteur / Invité** : Consultation libre de la vitrine publique sans affichage des contrôles de gestion.

### 4. Expérience Utilisateur & Responsive Design
- **Vitrine Publique & Espace Gestion Dédié** : Séparation claire entre la navigation client et le back-office opérationnel.
- **Tableau de Bord Synthétique (KPIs)** : Indicateurs en temps réel (Total références, En stock, Ruptures) contextuels aux filtres actifs.
- **Filtres Dynamiques & Recherche** : Bandeau étagé avec recherche textuelle instantanée et défilement tactile fluide des rayons sur mobile.
- **Pagination Personnalisée Moderne** : Composant de pagination stylisé avec sélecteur de volume par page (8, 12, 24, 48 références).
- **Navigation Mobile Native** : Tiroir latéral offcanvas Bootstrap 5 et boutons d'actions doux indépendants sur chaque carte produit.
- **Fallback Visuel Dynamique** : Génération de vignettes vectorielles SVG élégantes avec monogrammes et palettes harmonisées par univers en l'absence d'image importée.

---

## 🛠️ Stack Technique

| Composant | Technologie | Version / Détail |
| :--- | :--- | :--- |
| **Framework** | Laravel | 13.x |
| **Langage** | PHP (CLI & FPM) | 8.5+ |
| **Base de données** | MongoDB Server | 7.0 (NoSQL) |
| **Driver NoSQL** | `mongodb/laravel-mongodb` | 5.11+ / ext-mongodb 2.5+ |
| **Authentification** | `firebase/php-jwt` | 6.x (Cookies HttpOnly) |
| **Frontend & CSS** | Bootstrap 5 + Vanilla CSS + Bootstrap Icons | Slate & Indigo theme |
| **Build Tool** | Vite | 5.x |
| **Administration DB** | Mongo Express | Conteneurisé |
| **Conteneurs** | Docker Compose | Multi-environnements |

---

## 👤 Identifiants & Comptes par Défaut

Après exécution des migrations et seeders (`php artisan db:seed`), les comptes suivants sont automatiquement disponibles :

### 1. Comptes Applicatifs

| Rôle | Adresse E-mail | Mot de passe | Droits & Périmètre |
| :--- | :--- | :--- | :--- |
| **Directeur Général (Admin)** | `admin@catalog.local` | `Password123!` | Rôle `admin` : accès total, équipe & suppression |
| **Responsable Rayon (Manager)**| `manager@catalog.local`| `Password123!` | Rôle `manager` : ajout et édition de produits |

> 💡 **Configuration Personnalisée** : Les identifiants de l'administrateur par défaut peuvent être surchargés dans le `.env` via les variables `DEFAULT_ADMIN_NAME`, `DEFAULT_ADMIN_EMAIL` et `DEFAULT_ADMIN_PASSWORD`.

### 2. Interface Mongo Express (Dashboard DB)
- **URL** : [http://localhost:8081](http://localhost:8081)
- **Identifiant** : `admin`
- **Mot de passe** : `P@ssword123`

---

## 🏁 Démarrage Rapide

### Option A : Exécution Locale avec MongoDB sous Docker (Recommandé)

1. **Cloner le projet et accéder au répertoire** :
   ```bash
   git clone <repo-url> CatalogProducts
   cd CatalogProducts
   ```

2. **Installer les dépendances PHP et JavaScript** :
   ```bash
   composer install
   npm install
   ```

3. **Initialiser la configuration** :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Démarrer les conteneurs MongoDB & Mongo Express** :
   ```bash
   docker compose -f docker-compose.db.yml up -d
   ```

5. **Exécuter les migrations et injecter le catalogue** :
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Compiler les assets et lancer le serveur** :
   ```bash
   npm run build
   php artisan serve
   ```
   L'application est disponible sur [http://localhost:8000](http://localhost:8000).

---

### Option B : Environnement 100% Docker

1. **Démarrer la pile complète** :
   ```bash
   docker compose up -d --build
   ```

2. **Initialiser la base de données dans le conteneur** :
   ```bash
   docker compose exec app php artisan migrate --seed
   ```

---

## 🧪 Tests Automatisés

Le projet intègre une suite de tests unitaires et fonctionnels (PHPUnit) couvrant les fonctionnalités critiques :
- Sécurité et cycle de vie des cookies JWT.
- Forçage du premier changement de mot de passe.
- Règles d'autorisation par rôles (Admin vs Manager).
- Cohérence du typage des stocks, calculs de ruptures et pagination.

Pour exécuter les tests :
```bash
php artisan test
```

---

## 📁 Structure du Projet

```text
app/
├── Enums/
│   ├── ProductCategory.php       # Définition des 5 univers, icônes et attributs
│   └── UserRole.php              # Rôles applicatifs (admin, manager) et badges
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php               # Authentification JWT
│   │   │   └── ForcePasswordChangeController.php # Écran de premier changement
│   │   ├── ProductController.php                 # CRUD unifié NoSQL
│   │   ├── ProfileController.php                 # Gestion du compte
│   │   └── UserController.php                    # Administration de l'équipe
│   ├── Middleware/
│   │   ├── JwtAuthenticationMiddleware.php       # Protection sans session serveur
│   │   └── EnsurePasswordIsChanged.php           # Redirection de sécurité
│   └── Requests/
│       ├── StoreProductRequest.php               # Validation métier polymorphique
│       └── UpdateProductRequest.php
├── Models/
│   ├── Product.php               # Modèle MongoDB (scopes, typage BSON, fallback SVG)
│   └── User.php                  # Modèle utilisateur MongoDB avec hashing Argon2id
└── Services/
    ├── ImageService.php          # Nettoyage et stockage optimisé des visuels
    └── JwtAuthService.php        # Émission et décodage sécurisé des jetons

database/
├── migrations/                   # Index MongoDB (unicité e-mail, libellé, index par type)
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php            # Administrateur et manager par défaut
    └── ProductSeeder.php         # 29 références authentiques multi-secteurs

resources/
├── css/app.css                   # Design system Slate & Indigo et règles responsives
├── views/
│   ├── layouts/app.blade.php     # Layout principal avec tiroir de navigation mobile
│   ├── products/                 # Vues catalogue (index, fiche, formulaire unifié)
│   ├── users/                    # Interface de gestion des collaborateurs
│   └── welcome.blade.php         # Vitrine publique avec statistiques en direct
```

---

## 📄 Licence & Droits
Ce projet est open-source sous licence [MIT](https://opensource.org/licenses/MIT) — Développé par **Mame Maguette Diouck** dans le cadre de son portfolio technique.
