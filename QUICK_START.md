# 🚀 GUIDE RAPIDE - Découverte de Jeux

## Bienvenue sur GameLib ! 👋

Vous avez du mal à choisir votre prochain jeu ? Vous êtes au bon endroit !

---

## ⚡ Démarrage Express

### 1️⃣ **Accédez à la page de Découverte**
   - Cliquez sur le bouton **"🎯 Découvrir"** dans la barre de navigation
   - Ou allez sur `/pages/discover.php`

### 2️⃣ **Utilisez les Filtres**

Vous avez 5 paramètres de recherche :

#### 🔍 **Recherche**
- Entrez un titre, un genre, une plateforme...
- Exemple : `Zelda`, `Action RPG`, `RPG`

#### ⚔️ **Difficulté**
- `Très Facile` → Relaxant, pas de frustration
- `Facile` → Accessible à tous
- `Moyen` → Équilibre classique
- `Difficile` → Pour les hardcore gamers

#### 🎨 **Style Graphique**
- `2D` → Rétro, pixelart, indie
- `3D Réaliste` → Graphismes modernes
- `3D Stylisé` → Style unique et artistique
- `Anime` → Personnages manga/anime
- `Low-Poly` → Géométrie simple et mignonne

#### 👥 **Public Cible**
- `Enfants` → Jeux pour les jeunes enfants
- `Ados` → Jeux pour 12+
- `Adultes` → Jeux pour +18
- `Tous` → Tout le monde peut y jouer

#### 📊 **Tri**
- `⭐ Meilleures notes` → Les jeux les plus appréciés
- `🆕 Plus récents` → Les nouveautés
- `💰 Prix croissant` → Du moins cher au plus cher
- `A→Z` → Ordre alphabétique

### 3️⃣ **Parcourez les Résultats**

Chaque jeu affiche :
- ⭐ **Note** du jeu
- ⚔️ **Difficulté**
- 🎨 **Style graphique**
- ⏱️ **Durée de jeu**
- 👥 **Public cible**
- 💵 **Prix**
- 🎮 **Multijoueur** (si applicable)

### 4️⃣ **Consultez les Détails**

Cliquez sur une carte de jeu pour voir :
- Description complète
- Toutes les plateformes
- Mode histoire / Multijoueur
- Prix et liens
- Critères détaillés

---

## 💡 Exemples de Recherche

### "Je veux un jeu facile et relaxant"
- Difficulté : **Facile**
- Style : **2D Pixelart** ou **Low-Poly**
- Public : **Tous**
- Résultat : Vous trouverez `Stardew Valley`, `A Short Hike`, etc.

### "Un défi difficile avec belle qualité graphique"
- Difficulté : **Difficile**
- Style : **3D Réaliste**
- Résultat : `Elden Ring`, `Dark Souls 3`, etc.

### "Un jeu en multijoueur pour jouer avec mes amis"
- Recherche : `multijoueur`
- Ou filtrez par **Public Cible : Tous**
- Résultat : `Minecraft`, `Fortnite`, etc.

### "Un bon jeu indépendant pas cher"
- Recherche : `indie` ou `indépendant`
- Tri : **Prix croissant**
- Résultat : Des pépites comme `Hollow Knight`, `Hades`

---

## 📊 Les 20 Jeux de Base

| # | Titre | Genre | Difficulté | Prix |
|----|-------|-------|-----------|------|
| 1 | Elden Ring | Action-RPG | Difficile | 59,99€ |
| 2 | Cyberpunk 2077 | RPG | Moyen | 59,99€ |
| 3 | Hollow Knight | Metroidvania | Moyen | 14,99€ |
| 4 | Baldur's Gate 3 | RPG | Moyen | 59,99€ |
| 5 | Alan Wake 2 | Survival | Moyen | 59,99€ |
| 6 | Spider-Man 2 | Action | Facile | 59,99€ |
| 7 | Minecraft | Sandbox | Facile | 26,99€ |
| 8 | Stardew Valley | Simulation | Facile | 14,99€ |
| 9 | Zelda: BOTW | Aventure | Moyen | 69,99€ |
| 10 | Fortnite | Battle Royale | Moyen | Gratuit |
| 11 | Hades | Roguelike | Difficile | 24,99€ |
| 12 | Tetris Effect | Puzzle | Facile | 29,99€ |
| 13 | Outer Wilds | Exploration | Facile | 24,99€ |
| 14 | Dead Cells | Roguelike | Difficile | 26,99€ |
| 15 | A Short Hike | Aventure | Très Facile | 7,99€ |
| 16 | Celeste | Plateforme | Difficile | 19,99€ |
| 17 | Portal 2 | Puzzle | Moyen | 19,99€ |
| 18 | Undertale | RPG | Facile | 14,99€ |
| 19 | Genshin Impact | RPG | Facile | Gratuit |
| 20 | Fall Guys | Party | Facile | Gratuit |

---

## 🎮 Ajouter Vos Propres Jeux

Pour les administrateurs qui veulent ajouter des jeux :

1. Ouvrez `data/games.csv`
2. Ajoutez une nouvelle ligne avec tous les critères
3. **Format CSV** : `id,title,genre,platforms,difficulty,...`
4. Les changements seront visibles instantanément !

---

## ❓ FAQ

### Pourquoi mes filtres ne retournent aucun résultat ?
Vérifiez l'orthographe de la recherche. Les filtres sont **sensibles à la casse** (important !).

### Puis-je créer une collection de mes jeux favoris ?
Oui ! Section **Collections** à implémenter bientôt.

### Y a-t-il d'autres jeux que ces 20 ?
Vous pouvez en ajouter dans le CSV. Cette version de base contient 20 jeux de test.

### Puis-je noter les jeux ?
La section **Avis** est en développement. Pour l'instant, voyez les notes existantes.

---

**Besoin d'aide ?** Consultez le [README principal](GAMELIB_README.md)

Happy gaming! 🎮✨
