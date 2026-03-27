# GameLib - Système Intelligent de Recommandation de Jeux Vidéo

## 📋 Vue d'Ensemble du Projet

GameLib est une plateforme communautaire intelligente de découverte et de gestion de jeux vidéo, réorganisée selon des standards enterprise avec une architecture MVC professionnelle.

### Phase 1: Transformation en Recommandeur
- ✅ Création d'un système de filtrage avancé multi-critères
- ✅ Implémentation d'une page de découverte intelligente  
- ✅ CSV database avec 20 jeux et 16 critères de classification
- ✅ Filtres: difficulty, graphics, audience, genre, platicle, price, rating, etc.

### Phase 2: Refactorisation Professionnelle (COMPLET)
- ✅ Restructuration MVC complète
- ✅ Architecture enterprise-grade avec PSR-4 autoloading
- ✅ Séparation des préoccupations (Models, Services, Controllers)
- ✅ Dépendance Injection via bootstrap
- ✅ Système de vues templabilisées
- ✅ Configuration centralisée
- ✅ Gestion d'erreurs robuste

---

## 🏗️ Architecture du Projet

```
/
├── src/                          # Cœur applicatif (PSR-4)
│   ├── Core/
│   │   └── Application.php        # Bootstrap et configuration
│   ├── Models/
│   │   └── Game.php              # Entité Game avec getters typés
│   ├── Services/
│   │   ├── CsvRepository.php      # Data layer pour CSV
│   │   └── GameService.php        # Business logic (filtres, tri)
│   ├── Controllers/
│   │   ├── DiscoveryController.php  # Découverte
│   │   └── GameDetailController.php # Détails jeu
│   └── Utils/
│       └── StringHelper.php       # Utilitaires string
│
├── resources/                     # Assets et vues
│   ├── layouts/
│   │   └── base.php              # Layout principal
│   └── views/
│       ├── discover.php          # Page découverte
│       ├── game-detail.php       # Page détail jeu
│       └── game-not-found.php    # Page 404
│
├── public/                        # Entry points
│   ├── discover.php              # Point d'entrée découverte
│   └── game.php                  # Point d'entrée détail
│
├── database/                      # Données
│   └── games.csv                 # Base de données de jeux
│
├── config/                        # Configuration
│   ├── app.php                   # Configuration application
│   └── database.php              # Configuration BD
│
├── bootstrap.php                  # Initialisation app + DI
├── .htaccess                      # Réécriture URL propres
└── router.php                     # Routeur (optionnel)
```

---

## 🔑 Composants Clés

### 1. **Game Model** (`src/Models/Game.php`)
```php
class Game {
    private int $id;
    private string $title;
    private string $description;
    private string $genre;
    private int $year;
    private float $rating;
    // ... 10 autres propriétés privées
    
    // 16 getters avec typage strict
    public function getId(): int
    public function getTitle(): string
    // ...
}
```

### 2. **GameService** (`src/Services/GameService.php`)
- `filter()` - Filtrage multi-critères
- `findById()` - Recherche par ID
- `getFilterOptions()` - Options de filtres disponibles
- `getAll()` - Récupération tous les jeux

### 3. **CsvRepository** (`src/Services/CsvRepository.php`)
- Chargement sécurisé depuis CSV
- Validation des lignes (prévention des erreurs array_combine)
- Instanciation automatique d'objets Game

### 4. **Controllers**
- **DiscoveryController**: Gère pagination, filtrage, affichage résultats
- **GameDetailController**: Récupère détails d'un jeu

---

## 🚀 Démarrage Rapide

### Installation
```bash
cd /home/vyllixis/ESGI/annuel_project_esgi_1

# Serveur de développement
php -S localhost:8000
```

### Routes Disponibles
- **Découverte**: http://localhost:8000/public/discover.php
- **Détail Jeu**: http://localhost:8000/public/game.php?id=1
- **Accueil**: http://localhost:8000/ (index.php)

---

## 📊 Critères de Filtrage

Les 16 critères de classification des jeux:

| Critère | Valeurs | Type |
|---------|---------|------|
| Difficulty | Très Facile, Facile, Moyen, Difficile | Select |
| Graphics | 2D Pixel Art, 2D Stylisé, 3D Stylisé, 3D Réaliste, etc. | Select |
| Target Audience | Enfants, Ados, Adultes, Tous | Select |
| Playtime | 0-2h, 2-3h, 8-12h, 20-40h, etc. | String |
| Game Type | Soulslike, Monde Ouvert, RPG, Battle Royale, etc. | String |
| Platforms | PC, PS4, PS5, Xbox, Nintendo Switch, Mobile | Array |
| Multiplayer | Oui/Non | Boolean |
| Story Mode | Oui/Non | Boolean |
| Rating | 1-10 | Float |
| Genre | Action, RPG, Adventure, etc. | String |

---

## 🔧 Patterns & Standards

### 1. **PSR-4 Autoloading**
```php
// bootstrap.php
spl_autoload_register(function (string $class) {
    $prefix = 'GameLib\\';
    $baseDir = GAMELIB_SRC_DIR . '/';
    // Namespace → File mapping automatique
});
```

### 2. **Dependency Injection**
```php
// Services injectés dans les controllers
$discoveryController = new DiscoveryController($gameService);
$gameDetailController = new GameDetailController($gameService);

// Disponibles globalement
$GLOBALS['discoveryController'] = new DiscoveryController($gameService);
```

### 3. **Type Hints Stricts**
```php
declare(strict_types=1);

public function filter(
    string $query = '',
    string $difficulty = '',
    string $graphics = '',
    string $audience = '',
    string $sort = 'rating'
): array
```

### 4. **Repository Pattern**
- Abstraire l'accès aux données (CSV, DB future)
- Faciliter testing et changements de source

---

## 🔐 Gestion des Erreurs

### CSV Loading
- ✅ Validation des en-têtes
- ✅ Vérification du nombre de colonnes
- ✅ Prévention ValueError dans array_combine()
- ✅ Filtrage des lignes vides

### Game Not Found
- ✅ Réponse 404 HTTP
- ✅ Template d'erreur dédié
- ✅ Redirection vers découverte

---

## 📈 Métriques & Performance

- **Jeux en base**: 20 jeux de référence
- **Critères**: 16 paramètres de classification
- **Filtres supportés**: 6+ axes de filtrage simultanés
- **Pagination**: 12 jeux par page (configurable)

---

## 🚫 Corrections Bug Phase 2

### ValueErrorreur array_combine()
**Problème**: Lignes CSV mal formées causaient ValueError
```php
// AVANT ❌
$data = array_combine($headers, $row);

// APRÈS ✅
if (count($row) !== count($headers)) {
    continue; // Ignorer lignes mal formées
}
$data = array_combine($headers, $row);
```

---

## 📝 Conventions de Code

### Naming Conventions
- **Classes**: `PascalCase` (Game, GameService)
- **Méthodes**: `camelCase` (getTitle(), filterGames())
- **Propriétés**: `$camelCase` (NOT `$_underscored`)
- **Fichiers**: `PascalCase.php` ou `lowercase-kebab.php`
- **Namespaces**: `GameLib\Module\Submodule`

### File Structure Standards
```
src/
├── Core/          # Bootstrap & config
├── Models/        # Entities
├── Services/      # Business logic
├── Controllers/   # Request handlers
└── Utils/         # Helpers
```

---

## 🔄 Workflow Recommandé

### Pour ajouter une fonctionnalité:

1. **Créer le modèle** (si pertinent)
   ```bash
   src/Models/ResourceName.php
   ```

2. **Implémenter la logique** dans Service
   ```bash
   src/Services/ResourceService.php
   ```

3. **Créer le contrôleur**
   ```bash
   src/Controllers/ResourceController.php
   ```

4. **Ajouter la vue**
   ```bash
   resources/views/resource.php
   ```

5. **Créer un entry point** dans `/public`
   ```bash
   public/resource.php
   ```

---

## 🧪 Testing

Points à tester:
- ✅ Chargement CSV sans erreurs
- ✅ Filtrage multi-critères
- ✅ Pagination
- ✅ Affichage détails jeu
- ✅ Requête 404 pour ID inexistant

---

## 📚 Resources & Documentation

- **README.md**: Ce fichier
- **src/*/**: Docblocks détaillés dans chaque classe
- **bootstrap.php**: Pointeur DI et autoloader
- **config/app.php**: Variables globales d'config

---

## 👤 Maintainability

Le code est maintenant:
- ✅ **Testable**: Dépendances injectées
- ✅ **Scalable**: Structure modulaire claire
- ✅ **Maintenable**: Séparation des préoccupations
- ✅ **Professionnelle**: Standards PHP modernes
- ✅ **Documentée**: Docblocks partout

---

## 🎯 Prochaines Étapes (Optionnel)

1. **Tests Unitaires**: PHPUnit pour chaque service
2. **CI/CD**: GitHub Actions
3. **Database**: Migration CSV → MySQL avec Doctrine ORM
4. **Authentification**: Système utilisateurs robuste
5. **API REST**: JSON endpoints pour frontend spa
6. **Cache**: Redis pour les filtres populaires

---

**Statut**: ✅ COMPLET - Architecture Enterprise Grade  
**Version**: 2.0.0 (Professional)  
**Date Dernier Update**: 2025  
**Standard PHP**: 7.4+
