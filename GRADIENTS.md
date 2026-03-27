# 🎨 Système de Gradients Dynamiques par Jeu

## Fonctionnement

Chaque jeu affiche maintenant un **gradient CSS unique** basé sur ses propriétés (difficulté et style graphique), sans nécessiter d'images externes.

## 🌈 Palettes de Couleurs

### Par Difficulté
- **Très Facile** → `#10b981` → `#34d399` (Vert)
- **Facile** → `#3b82f6` → `#60a5fa` (Bleu)
- **Moyen** → `#f59e0b` → `#fbbf24` (Orange)
- **Difficile** → `#ef4444` → `#f87171` (Rouge)

### Accent par Style Graphique
- **2D Pixel Art** → `#8b5cf6` (Violet)
- **2D Stylisé** → `#a855f7` (Violet clair)
- **3D Stylisé** → `#06b6d4` (Cyan)
- **3D Réaliste** → `#6366f1` (Indigo)
- **3D Abstrait** → `#ec4899` (Rose)

## 📐 Rotation Dynamique

La rotation du gradient pour chaque jeu est calculée ainsi:
```
rotation = (gameId * 13) % 360
```

Cela crée une rotation unique déterministe pour chaque jeu, garantissant le même gradient à chaque chargement.

## 📝 Exemples

### Elden Ring (ID: 1)
- **Difficulté** : Difficile → Rouge + Indigo + Rose
- **Rotation** : (1 × 13) % 360 = 13°
- **Résultat** : `linear-gradient(13deg, #ef4444, #6366f1, #f87171)`
- **Affichage** : Les en-têtes de cartes affichent ce gradient unique

### Cyberpunk 2077 (ID: 2) 
- **Difficulté** : Moyen → Orange + Cyan (car 3D Stylisé) + Jaune
- **Rotation** : (2 × 13) % 360 = 26°
- **Résultat** : `linear-gradient(26deg, #f59e0b, #06b6d4, #fbbf24)`

### Hollow Knight (ID: 3)
- **Difficulté** : Moyen → Orange + Indigo (default) + Jaune
- **Rotation** : (3 × 13) % 360 = 39°
- **Résultat** : `linear-gradient(39deg, #f59e0b, #f472b6, #fbbf24)`

## 🛠️ Architecture

### Fonction Helper (`includes/functions.php`)
```php
function gameGradient(
    int $gameId = 1,
    string $difficulty = '',
    string $graphics = ''
): string {
    // Retourne un gradient CSS complet et unique
}
```

### Utilisation

**Dans `resources/views/discover.php`** (cartes de jeux):
```php
<div style="background: <?= gameGradient((int)$game['id'], ...) ?>; ...">
```

**Dans `resources/views/game-detail.php`** (hero section):
```php
<div style="background: <?= gameGradient((int)$gameData['id'], ...) ?>; ...">
```

## ✅ Avantages

✅ **Aucune dépendance externe** - Pure CSS  
✅ **Déterministe** - Même ID = Même gradient toujours  
✅ **Performant** - Pas de requêtes réseau d'images  
✅ **Responsif** - Adapté à tous les écrans  
✅ **Accessible** - Contraste suffisant avec le texte blanc  
✅ **Unique par jeu** - Visuelle cohérence et différenciation  

## 🎯 Résultats

- ✅ Chaque jeu a un gradient unique basé sur ses attributs
- ✅ Les gradients s'affichent sur les cartes de découverte
- ✅ Les gradients s'affichent sur les pages de détail
- ✅ L'angle de rotation varie pour la variété visuelle
- ✅ Les couleurs reflètent le type de jeu (difficulté + style graphique)

## 📊 Exemple de Page

Sur `/public/discover.php?`:
- Affiche **12 jeux** avec gradients uniques
- Chaque gradient combine:
  - Palette de difficulté (2 couleurs)
  - Accent du style graphique (1 couleur de contraste)
  - Rotation unique au jeu

## 🚀 Extension Future

Pour ajouter des images réelles par-dessus les gradients:
```php
background-image:
  url('path/to/game-image.jpg'),
  linear-gradient(...);
background-blend-mode: overlay;
```

Cela créerait une couche visuelle riche sans compromettre la performance actuelle.
