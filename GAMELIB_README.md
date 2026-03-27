# 🎮 GameLib - Recommandation de Jeux Vidéo

## 📋 Concept du Projet

**GameLib** est une plateforme intelligente de **recommandation de jeux vidéo** destinée aux joueurs qui :
- ❓ Ne savent pas quel jeu jouer
- 🎯 Cherchent des jeux adaptés à leur niveau de difficulté
- 🎨 Veulent des jeux d'un certain style graphique
- 👥 Recherchent selon leur audience (enfants, ados, adultes)

## 🗂️ Architecture

### Structure des Fichiers

```
data/
  └── games.csv ........................ Base de données des jeux (20 jeux de test)

pages/
  ├── discover.php ..................... 🎯 Page d'accueil - Recommandation intelligente
  ├── game.php ......................... 📖 Détail complet d'un jeu
  └── (autres pages)

includes/
  └── functions.php .................... Fonctions CSV + filtrage
```

## 📊 Structure du CSV (`data/games.csv`)

Chaque jeu contient les critères suivants :

| Colonne | Description | Exemples |
|---------|-------------|----------|
| **id** | ID unique du jeu | `1`, `2`, ... |
| **title** | Nom du jeu | `Elden Ring` |
| **genre** | Genre principal | `Action-RPG`, `Puzzle` |
| **platforms** | Plateformes (séparées par `\|`) | `PS5\|Xbox Series\|PC` |
| **difficulty** | Niveau de difficulté | `Facile`, `Moyen`, `Difficile` |
| **playtime_hours** | Durée de jeu en heures | `60-100`, `20-40`, `Illimité` |
| **graphics_style** | Style graphique | `3D Réaliste`, `2D Pixelart`, `3D Stylisé` |
| **target_audience** | Public visé | `Enfants`, `Ados`, `Adultes`, `Tous` |
| **rating** | Note globale | `9.8`, `8.4`, ... |
| **year** | Année de sortie | `2022`, `2023`, ... |
| **price_eur** | Prix en euros | `59.99`, `14.99`, `Gratuit (F2P)` |
| **multiplayer** | Support multijoueur | `Oui`, `Non` |
| **story_mode** | Mode histoire présent | `Oui`, `Non` |
| **game_type** | Type de jeu | `Soulslike`, `Monde Ouvert`, `Roguelike` |
| **description** | Description courte | Max 180 caractères |
| **emoji** | Émoji représentatif | `⚔️`, `🎮`, ... |

## 🎯 Fonctionnalités Principales

### 1️⃣ Page de Découverte (`pages/discover.php`)
- **Filtrage avancé** par :
  - 🔍 Recherche textuelle (titre, genre)
  - ⚔️ Difficulté (Facile, Moyen, Difficile)
  - 🎨 Style graphique (2D, 3D, Pixelart, etc.)
  - 👥 Public cible (Enfants, Ados, Adultes)
- **Tri** : Note, Année, Prix, Ordre alphabétique
- **Résultats en grille** avec aperçu des critères clés
- **Pagination** automatique (12 jeux par page)

### 2️⃣ Détail du Jeu (`pages/game.php`)
- Affichage complet de tous les critères
- Cartes visuelles pour chaque critère
- Informations techniques (plateformes, multijoueur, etc.)
- Bouton Wishlist + prix

### 3️⃣ Navigation Principale
- Lien `🎯 Découvrir` dans la navbar (principal)
- Accueil repositionné vers le concept de recommandation

## 🔧 Fonctions Nouvelles

### `loadGamesFromCSV(string $csvPath): array`
Charge tous les jeux depuis le CSV.

```php
$games = loadGamesFromCSV(__DIR__ . '/../data/games.csv');
```

### `filterGamesAdvanced(...): array`
Filtre les jeux selon les critères.

```php
$filtered = filterGamesAdvanced(
    $games,
    $q = '',              // Recherche textuelle
    $difficulty = '',     // Difficulté
    $graphics = '',       // Style graphique
    $audience = '',       // Public cible
    $sort = 'rating'      // Tri
);
```

## 📝 Ajouter un Jeu

Pour ajouter un nouveau jeu au CSV, ajoutez une ligne avec tous les champs requis :

```csv
21,Zelda Tears of the Kingdom,Action Aventure,Nintendo Switch,Moyen,50-80,3D Réaliste,Tous,9.8,2023,69.99,Non,Oui,Monde Ouvert,L'aventure Link continue avec de nouveaux mécanismes de création.,⚔️
```

## 🎨 Critères Gérés

- ✅ **Difficulté** : Très Facile, Facile, Moyen, Difficile
- ✅ **Style Graphique** : 2D, 3D, Pixelart, Réaliste, Stylisé, Anime, Low-Poly, etc.
- ✅ **Public** : Enfants, Ados, Adultes, Tous
- ✅ **Plateforme** : PC, PS4, PS5, Xbox, Nintendo Switch, Mobile
- ✅ **Genre** : RPG, Action, Puzzle, Stratégie, Simulation, etc.
- ✅ **Multijoueur** : Présent ou non
- ✅ **Prix** : Gratuit, Payant, F2P

## 🚀 Prochaines Améliorations

- 📱 Recommandations personnalisées (machine learning)
- ⭐ Système d'avis utilisateurs
- 🎯 Quiz pour découvrir le meilleur jeu
- 📊 Statistiques personnelles du joueur
- 🌍 API d'intégration avec Steam/Epic
- 📧 Alertes pour nouveaux jeux

## 💡 Utilisation

1. Accédez à `pages/discover.php`
2. Utilisez les filtres pour affiner votre recherche
3. Cliquez sur un jeu pour voir tous les détails
4. Ajoutez à votre wishlist (à implémenter)

---

**Version** : 1.0  
**Last Updated** : March 2026  
**Auteur** : ESGI Students Group
