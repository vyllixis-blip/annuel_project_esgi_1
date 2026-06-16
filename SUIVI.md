# Suivi — CodexGame

---

## Chapitre 1 — Features

---

### 1.1 — Page de détail d'un jeu

- [ ] **`src/api/games.js` → dans `normalizeGame`** : ajoute ces champs dans l'objet retourné (ils existent déjà dans le JSON mais ne sont pas utilisés) :
  ```js
  appid:         String(rawGame.appid),
  developer:     rawGame.developer    || 'Inconnu',
  publisher:     rawGame.publisher    || 'Inconnu',
  categories:    rawGame.categories   || '',
  achievements:  rawGame.achievements || 0,
  averagePlaytime: rawGame.average_playtime || 0,
  medianPlaytime:  rawGame.median_playtime  || 0,
  owners:        rawGame.owners       || 'N/A',
  requiredAge:   rawGame.required_age || 0,
  ```

- [ ] **Crée le fichier `public/game.html`** : copie-colle tout le contenu de `public/index.html`, puis remplace le bloc `<main>` par :
  ```html
  <main class="container">
    <div id="game-detail"></div>
  </main>
  ```
  Et remplace la ligne `<script src="/src/main.js">` par `<script type="module" src="/src/pages/game-detail.js">`.

- [ ] **Crée le dossier `src/pages/` puis le fichier `src/pages/game-detail.js`** et colle ces imports en haut :
  ```js
  import { fetchGames }               from '../api/games.js'
  import { injectHeader, injectFooter } from '../components/layout.js'
  import { qs }                       from '../utils/dom.js'
  ```

- [ ] **Dans `game-detail.js`** : écris la fonction `getGameIdFromUrl()`. Elle lit l'URL de la page pour récupérer le paramètre `id` (ex: `/game.html?id=10` → retourne `"10"`).
  ```js
  function getGameIdFromUrl() {
    return new URLSearchParams(window.location.search).get('id')
  }
  ```

- [ ] **Dans `game-detail.js`** : écris la fonction `renderGameDetail(game)`. Elle prend un jeu en paramètre et affiche ses infos dans `#game-detail`. Utilise `qs('#game-detail').innerHTML` pour écrire du HTML dedans avec les champs du jeu (nom, développeur, éditeur, prix, score, plateformes, genres, etc.).

- [ ] **Dans `game-detail.js`** : écris le bloc principal qui s'exécute au chargement de la page. Il appelle `injectHeader()`, `injectFooter()`, puis `fetchGames()` pour charger tous les jeux, ensuite cherche le bon jeu avec `.find()` et appelle `renderGameDetail`.
  ```js
  injectHeader()
  injectFooter()
  var id = getGameIdFromUrl()
  fetchGames().then(function(games) {
    var game = games.find(function(g) { return g.appid === id })
    if (!game) {
      qs('#game-detail').textContent = 'Jeu introuvable.'
      return
    }
    renderGameDetail(game)
  })
  ```

- [ ] **`src/components/game-card.js` → dans `createGameCard`** : rends la carte cliquable en ajoutant un listener `click` sur l'`<article>` :
  ```js
  card.addEventListener('click', function() {
    window.location.href = '/game.html?id=' + game.appid
  })
  ```

- [ ] **Test** : clique sur une carte depuis la page d'accueil → tu dois arriver sur `/game.html` avec les infos du jeu.

---

### 1.2 — Tri des résultats

- [ ] **`src/main.js` → dans `appState`** : ajoute `sortBy: 'default'` dans l'objet.

- [ ] **Crée le fichier `src/components/sort-select.js`** avec cet import :
  ```js
  import { createElement } from '../utils/dom.js'
  ```

- [ ] **Dans `sort-select.js`** : écris la fonction `createSortSelect(onSort)`. Elle crée un `<select>` avec ces options et appelle `onSort` à chaque changement de valeur :
  ```js
  export function createSortSelect(onSort) {
    var select = document.createElement('select')
    select.className = 'sort-select'
    var options = [
      { value: 'default',    label: 'Par défaut' },
      { value: 'name-asc',   label: 'Nom A → Z' },
      { value: 'score-desc', label: 'Meilleure note' },
      { value: 'price-asc',  label: 'Prix croissant' },
      { value: 'price-desc', label: 'Prix décroissant' },
      { value: 'date-desc',  label: 'Plus récent' },
    ]
    options.forEach(function(opt) {
      var option = document.createElement('option')
      option.value = opt.value
      option.textContent = opt.label
      select.appendChild(option)
    })
    select.addEventListener('change', function() { onSort(select.value) })
    return select
  }
  ```

- [ ] **`src/main.js`** : écris la fonction `applySorting(games)`. Elle retourne une copie du tableau triée selon `appState.sortBy`. Utilise `.slice()` pour ne pas modifier le tableau original, puis `.sort()` avec la bonne comparaison selon la valeur de `sortBy`.
  - `name-asc` → compare `a.name` et `b.name` avec `.localeCompare()`
  - `score-desc` → compare `b.scorePercent` et `a.scorePercent` (si tu as fait la feature 1.5, sinon utilise `positiveRatings`)
  - `price-asc` / `price-desc` → compare `parseFloat(a.price)` et `parseFloat(b.price)`
  - `date-desc` → compare `new Date(b.releaseDate)` et `new Date(a.releaseDate)`

- [ ] **`src/main.js`** : écris la fonction `initSort()`. Elle importe `createSortSelect`, l'insère dans `qs('#sort-bar')`, et dans le callback met à jour `appState.sortBy` puis appelle `renderFilteredGames()`.

- [ ] **`public/index.html`** : ajoute cette ligne entre la section filtres et `#games-grid` :
  ```html
  <div id="sort-bar" class="sort-bar"></div>
  ```

- [ ] **`src/main.js` → dans `renderFilteredGames`** : appelle `applySorting(filteredGames)` juste après le `.filter()`, avant de découper en pages.

- [ ] **`src/main.js` → dans `initApp`** : appelle `initSort()` dans le `.then()`, avec les autres `init*`.

- [ ] **`styles/search.css`** : ajoute le style du `<select>` :
  ```css
  .sort-select {
    padding: 0.5rem 0.8rem;
    border: 1px solid var(--color-border);
    border-radius: 10px;
    background: var(--color-surface);
    color: var(--color-text);
    font-size: 0.9rem;
    cursor: pointer;
  }
  ```

- [ ] **Test** : change chaque option du tri et vérifie que les cartes changent d'ordre.

---

### 1.3 — Filtre par plateforme

- [ ] **`public/index.html`** : après le bloc `#genre-filter`, ajoute :
  ```html
  <p class="genre-label">Filtrer par plateforme</p>
  <div id="platform-filter" class="genre-checkboxes"></div>
  ```

- [ ] **`src/main.js` → dans `appState`** : ajoute `selectedPlatforms: []`.

- [ ] **`src/main.js`** : écris `extractUniquePlatforms(games)`. C'est la même logique qu'`extractUniqueGenres` mais sur `game.platforms` au lieu de `game.genres`.

- [ ] **`src/main.js`** : écris `matchesPlatforms(game, selectedPlatforms)`. Si `selectedPlatforms` est vide, retourne `true`. Sinon retourne `true` si le jeu a **au moins une** des plateformes cochées (utilise `.some()`, pas `.every()`).
  ```js
  function matchesPlatforms(game, selectedPlatforms) {
    if (!selectedPlatforms.length) return true
    return selectedPlatforms.some(function(p) { return game.platforms.includes(p) })
  }
  ```

- [ ] **`src/main.js`** : écris `initPlatformFilter(games)`. C'est la même chose qu'`initGenreFilter` mais tu passes `extractUniquePlatforms(games)` et tu mets à jour `appState.selectedPlatforms`.

- [ ] **`src/main.js` → dans `renderFilteredGames`** : dans la condition du `.filter()`, ajoute `&& matchesPlatforms(game, appState.selectedPlatforms)`.

- [ ] **`src/main.js` → dans `initApp`** : appelle `initPlatformFilter(games)` dans le `.then()`.

- [ ] **Test** : coche "mac" → seuls les jeux compatibles Mac s'affichent.

---

### 1.4 — Filtre par fourchette de prix

- [ ] **Crée `src/components/price-filter.js`** avec l'import de `createElement`.

- [ ] **Dans `price-filter.js`** : écris `createPriceFilter(onFilter)`. Elle crée des boutons radio (pas des checkboxes — un seul actif à la fois) pour ces tranches. Le bouton "Tous" est coché par défaut. Chaque clic appelle `onFilter` avec la valeur max de la tranche :
  ```js
  var tranches = [
    { label: 'Tous',    max: Infinity },
    { label: 'Gratuit', max: 0 },
    { label: '< 5 €',   max: 5 },
    { label: '< 15 €',  max: 15 },
    { label: '< 30 €',  max: 30 },
  ]
  ```

- [ ] **`src/main.js` → dans `appState`** : ajoute `maxPrice: Infinity`.

- [ ] **`src/main.js`** : écris `matchesPrice(game, maxPrice)`. Si `maxPrice` est `Infinity`, retourne `true`. Si `game.price` vaut `'N/A'`, retourne `false`. Sinon retourne `parseFloat(game.price) <= maxPrice`.

- [ ] **`src/main.js`** : écris `initPriceFilter()`. Elle insère `createPriceFilter(...)` dans `qs('#price-filter')` et dans le callback met à jour `appState.maxPrice` puis appelle `renderFilteredGames()`.

- [ ] **`public/index.html`** : ajoute dans la section de recherche :
  ```html
  <p class="genre-label">Filtrer par prix</p>
  <div id="price-filter" class="genre-checkboxes"></div>
  ```

- [ ] **`src/main.js` → dans `renderFilteredGames`** : ajoute `&& matchesPrice(game, appState.maxPrice)` dans le `.filter()`.

- [ ] **`src/main.js` → dans `initApp`** : appelle `initPriceFilter()` dans le `.then()`.

- [ ] **Test** : sélectionne "< 5 €" → tous les jeux affichés coûtent moins de 5 €.

---

### 1.5 — Score de recommandation

- [ ] **`src/api/games.js`** : écris `calculateScore(pos, neg)` juste avant `normalizeGame`. Elle prend le nombre de notes positives et négatives, calcule le pourcentage, et le retourne arrondi. Si le total est 0 (pas de notes), retourne `null`.
  ```js
  function calculateScore(pos, neg) {
    var total = Number(pos) + Number(neg)
    if (total === 0) return null
    return Math.round(Number(pos) / total * 100)
  }
  ```

- [ ] **`src/api/games.js` → dans `normalizeGame`** : ajoute `scorePercent: calculateScore(rawGame.positive_ratings, rawGame.negative_ratings)` et **supprime** les lignes `positiveRatings` et `negativeRatings`.

- [ ] **`src/components/game-card.js`** : écris `createScoreBadge(scorePercent)`. Elle crée un `<span>` avec le texte du score et une classe CSS selon le niveau :
  ```js
  function createScoreBadge(scorePercent) {
    var span = document.createElement('span')
    span.className = 'score-badge'
    if (scorePercent === null) {
      span.textContent = 'Non noté'
      return span
    }
    span.textContent = scorePercent + ' %'
    if (scorePercent >= 80)     span.classList.add('score--good')
    else if (scorePercent >= 50) span.classList.add('score--ok')
    else                         span.classList.add('score--bad')
    return span
  }
  ```

- [ ] **`game-card.js` → dans `createGameCard`** : remplace les deux `createInfoRow` pour notes positives et négatives par `createScoreBadge(game.scorePercent)` et insère ce badge dans les enfants de la carte.

- [ ] **`styles/game-card.css`** : ajoute les couleurs des badges :
  ```css
  .score--good { color: #4ade80; font-weight: 700; }
  .score--ok   { color: #fb923c; font-weight: 700; }
  .score--bad  { color: #f87171; font-weight: 700; }
  ```

- [ ] **Test** : Counter-Strike doit afficher un score vert élevé (il a ~97%).

---

## Chapitre 2 — UX

---

### 2.1 — État de chargement

- [ ] **Crée `src/components/loading.js`** avec les imports `createElement` et `clearElement` depuis `../utils/dom.js`.

- [ ] **Dans `loading.js`** : écris `showLoading(container)`. Elle crée un `<div class="loading-spinner">` et l'ajoute dans le container passé en paramètre.
  ```js
  export function showLoading(container) {
    var spinner = document.createElement('div')
    spinner.className = 'loading-spinner'
    container.appendChild(spinner)
  }
  ```

- [ ] **Dans `loading.js`** : écris `hideLoading(container)`. Elle vide le container (utilise `clearElement`).
  ```js
  export function hideLoading(container) {
    clearElement(container)
  }
  ```

- [ ] **Crée `styles/loading.css`** avec l'animation du spinner :
  ```css
  .loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--color-border);
    border-top-color: var(--color-primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 3rem auto;
  }
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  ```

- [ ] **`styles/index.css`** : ajoute `@import './loading.css';`.

- [ ] **`src/main.js` → dans `initApp`** : importe `showLoading` et `hideLoading`, appelle `showLoading(qs('#games-grid'))` juste avant `fetchGames()`, et appelle `hideLoading(qs('#games-grid'))` au début du `.then()` et aussi dans le `.catch()`.

- [ ] **Test** : DevTools → onglet Network → Throttling → "Slow 3G" → recharge la page → le spinner tourne pendant le chargement.

---

### 2.2 — État "aucun résultat"

- [ ] **Crée `src/components/empty-state.js`**.

- [ ] **Dans `empty-state.js`** : écris `createEmptyState(onReset)`. Elle crée un message avec un bouton reset :
  ```js
  export function createEmptyState(onReset) {
    var wrapper = document.createElement('div')
    wrapper.className = 'empty-state'
    var msg = document.createElement('p')
    msg.textContent = 'Aucun jeu trouvé pour ces critères.'
    var btn = document.createElement('button')
    btn.className = 'reset-btn'
    btn.textContent = 'Réinitialiser les filtres'
    btn.addEventListener('click', onReset)
    wrapper.appendChild(msg)
    wrapper.appendChild(btn)
    return wrapper
  }
  ```

- [ ] **`styles/`** : ajoute dans un fichier existant (ou crée `styles/empty-state.css`) :
  ```css
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--color-text-muted);
  }
  .empty-state .reset-btn {
    margin-top: 1rem;
    padding: 0.5rem 1.2rem;
    border: 1px solid var(--color-primary);
    border-radius: 8px;
    background: transparent;
    color: var(--color-primary);
    cursor: pointer;
  }
  ```

- [ ] **`src/main.js` → dans `renderGamesGrid`** : tout en haut de la fonction, avant le `forEach`, ajoute :
  ```js
  if (games.length === 0) {
    gamesGrid.appendChild(createEmptyState(resetFilters))
    return
  }
  ```
  (La fonction `resetFilters` est créée dans la tâche 2.4 juste après.)

- [ ] **Test** : tape "zzzzzzz" dans la recherche → le message et le bouton apparaissent.

---

### 2.3 — Correction du bug `aria-current="null"`

- [ ] **`src/utils/dom.js` → dans `createElement`** : trouve la boucle qui fait `element.setAttribute(key, config.attrs[key])` et ajoute une vérification avant pour ne pas écrire `null` dans le DOM :
  ```js
  Object.keys(config.attrs).forEach(function(key) {
    if (config.attrs[key] !== null && config.attrs[key] !== undefined) {
      element.setAttribute(key, config.attrs[key])
    }
  })
  ```

- [ ] **Test** : clique sur une page de la pagination, ouvre les DevTools → Elements → inspecte un bouton de page non-active → il ne doit **pas** avoir l'attribut `aria-current` dans le HTML.

---

### 2.4 — Bouton "Réinitialiser tous les filtres"

- [ ] **`src/main.js`** : écris la fonction `resetFilters()`. Elle remet tout à zéro dans `appState` ET dans le DOM (vide l'input texte, décoche les checkboxes) :
  ```js
  function resetFilters() {
    appState.searchTerm      = ''
    appState.selectedGenres  = []
    appState.selectedPlatforms = []
    appState.maxPrice        = Infinity
    appState.sortBy          = 'default'
    appState.currentPage     = 1
    qs('#search-input').value = ''
    qsa('input[type="checkbox"]').forEach(function(cb) { cb.checked = false })
    // Remet le radio "Tous" coché si tu as fait la feature 1.4
    var radioTous = qs('input[name="price-range"][value="Infinity"]')
    if (radioTous) radioTous.checked = true
    renderFilteredGames()
  }
  ```

- [ ] **`src/main.js`** : écris `updateResetButtonVisibility()`. Elle affiche le bouton si au moins un filtre est actif, le cache sinon :
  ```js
  function updateResetButtonVisibility() {
    var isActive = appState.searchTerm
      || appState.selectedGenres.length
      || appState.selectedPlatforms.length
      || appState.maxPrice !== Infinity
      || appState.sortBy !== 'default'
    qs('#reset-btn').classList.toggle('hidden', !isActive)
  }
  ```

- [ ] **`public/index.html`** : ajoute ce bouton dans la section filtres (à côté du label "Filtrer par genre") :
  ```html
  <button id="reset-btn" class="hidden reset-btn-header">Effacer les filtres</button>
  ```

- [ ] **`src/main.js` → dans `initApp`** : branche le bouton sur `resetFilters` :
  ```js
  qs('#reset-btn').addEventListener('click', resetFilters)
  ```

- [ ] **Dans chaque callback de filtre** (genre, plateforme, prix, tri, recherche) : ajoute `updateResetButtonVisibility()` à la fin du callback.

- [ ] **CSS** : stylise `.reset-btn-header` (petit bouton, bordure `var(--color-primary)`, fond transparent).

- [ ] **Test** : coche un genre → le bouton apparaît → clique dessus → tout se remet à zéro.

---

### 2.5 — Debounce sur la recherche

- [ ] **`src/utils/dom.js`** : ajoute cette fonction exportée à la fin du fichier. Elle "retarde" l'exécution d'une fonction jusqu'à ce que l'utilisateur arrête de taper :
  ```js
  export function debounce(fn, delay) {
    var timer
    return function() {
      clearTimeout(timer)
      timer = setTimeout(fn, delay)
    }
  }
  ```

- [ ] **`src/main.js`** : importe `debounce` depuis `./utils/dom.js`.

- [ ] **`src/main.js` → dans `initSearch`** : au lieu d'appeler directement la fonction dans l'event `input`, wrappe-la avec `debounce`. La valeur de l'input doit être lue **à l'intérieur** de la fonction debounced :
  ```js
  searchInput.addEventListener('input', debounce(function(event) {
    appState.searchTerm = event.target.value.trim().toLowerCase()
    appState.currentPage = 1
    renderFilteredGames()
  }, 250))
  ```
  ⚠️ Problème : le debounce actuel ne passe pas `event` correctement. Pour que ça marche, soit tu lis `searchInput.value` directement dans la fonction, soit tu adaptes `debounce` pour transmettre les arguments :
  ```js
  export function debounce(fn, delay) {
    var timer
    return function(event) {
      clearTimeout(timer)
      timer = setTimeout(function() { fn(event) }, delay)
    }
  }
  ```

- [ ] **Test** : tape rapidement 5 lettres → `renderFilteredGames` ne se déclenche qu'une fois quand tu t'arrêtes.

---

## Chapitre 3 — Visuel

---

### 3.1 — Images de couverture Steam

- [ ] **`src/api/games.js` → dans `normalizeGame`** : ajoute `appid: String(rawGame.appid)` si ce n'est pas déjà fait (feature 1.1).

- [ ] **`src/components/game-card.js` → dans `createGameCard`** : crée l'élément image et configure-le :
  ```js
  var img = document.createElement('img')
  img.src     = 'https://cdn.akamai.steamstatic.com/steam/apps/' + game.appid + '/header.jpg'
  img.alt     = game.name
  img.loading = 'lazy'
  img.className = 'game-cover'
  img.addEventListener('error', function() { img.style.display = 'none' })
  ```

- [ ] **Dans `createGameCard`** : insère `img` en premier dans la liste des enfants passés à `createElement('article', ...)`, avant le titre.

- [ ] **`styles/game-card.css`** : ajoute le style de l'image pour qu'elle soit en haut de la carte, pleine largeur, avec les coins arrondis en haut seulement :
  ```css
  .game-cover {
    display: block;
    width: calc(100% + 1.6rem);
    margin: -0.6rem -0.8rem 0.7rem;
    height: 130px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
  }
  ```

- [ ] **Test** : les cartes affichent les images Steam en haut. Les jeux sans image (très anciens) ne laissent pas de case cassée.

---

### 3.2 — Tags visuels pour genres et plateformes

- [ ] **`src/utils/dom.js`** : ajoute cette fonction exportée. Elle prend une liste de mots et crée une rangée de petits tags :
  ```js
  export function createTagList(items, extraClass) {
    var container = document.createElement('div')
    container.className = 'tag-list'
    items.forEach(function(item) {
      var span = document.createElement('span')
      span.className = 'card-tag' + (extraClass ? ' ' + extraClass : '')
      span.textContent = item
      container.appendChild(span)
    })
    return container
  }
  ```

- [ ] **`src/components/game-card.js`** : importe `createTagList` depuis `../utils/dom.js`.

- [ ] **Dans `createGameCard`** : supprime les deux `createInfoRow` pour `genres` et `platforms`. Remplace-les par :
  ```js
  var genresTags   = createTagList(game.genres,    'genre-tag')
  var platformTags = createTagList(game.platforms,  'platform-tag')
  ```
  Et ajoute `genresTags` et `platformTags` dans les enfants de la carte.

- [ ] **`styles/game-card.css`** : ajoute les styles des tags :
  ```css
  .tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
    margin-top: 0.5rem;
  }
  .card-tag {
    font-size: 0.72rem;
    padding: 0.18rem 0.5rem;
    border-radius: 999px;
    border: 1px solid var(--color-border-tag);
    background: var(--color-surface-card);
    color: var(--color-text-tag);
  }
  ```

- [ ] **Test** : les genres et plateformes apparaissent en petites pilules sur les cartes, dans le même style que les filtres en haut de page.

---

### 3.3 — Effet hover sur les cartes

- [ ] **`styles/game-card.css` → sur le sélecteur `.game-card` déjà existant** : ajoute `transition` et `cursor` :
  ```css
  transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
  cursor: pointer;
  ```

- [ ] **`styles/game-card.css`** : ajoute le nouveau sélecteur hover :
  ```css
  .game-card:hover {
    transform: translateY(-3px);
    border-color: var(--color-primary);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
  }
  ```

- [ ] **Test** : survole une carte → elle se lève légèrement et la bordure devient bleue. L'animation doit être fluide.

---

### 3.4 — Icône loupe dans la recherche

- [ ] **`public/index.html`** : entoure l'input de recherche dans un wrapper :
  ```html
  <div class="search-wrapper">
    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8"/>
      <line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input id="search-input" type="text" placeholder="Ex: Elden Ring" class="search-input">
  </div>
  ```

- [ ] **`styles/search.css`** : ajoute les styles du wrapper et de l'icône :
  ```css
  .search-wrapper {
    position: relative;
    display: block;
  }
  .search-icon {
    position: absolute;
    left: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--color-text-muted);
    pointer-events: none;
  }
  ```

- [ ] **`styles/search.css` → sur `.search-input` déjà existant** : ajoute `padding-left: 2.6rem` et `font-size: 0.95rem` (ce font-size était absent).

- [ ] **Test** : l'icône loupe est bien à gauche dans le champ, alignée verticalement. Cliquer dessus place le curseur dans le champ (grâce à `pointer-events: none`).

---

### 3.5 — Barre de progression du score

> ⚠️ Nécessite que la **feature 1.5** soit faite — `game.scorePercent` doit exister dans les données.

- [ ] **`src/components/game-card.js` → dans `createGameCard`** : après avoir créé le titre, crée la barre. Si `game.scorePercent` est `null`, ne crée rien.
  ```js
  if (game.scorePercent !== null) {
    var track = document.createElement('div')
    track.className = 'score-bar-track'
    var fill = document.createElement('div')
    fill.className = 'score-bar-fill'
    fill.style.width = game.scorePercent + '%'
    if (game.scorePercent < 50)      fill.classList.add('score--bad')
    else if (game.scorePercent < 80) fill.classList.add('score--ok')
    track.appendChild(fill)
    // Insère `track` dans les enfants de la carte, juste après le titre
  }
  ```

- [ ] **`styles/game-card.css`** : ajoute les styles de la barre :
  ```css
  .score-bar-track {
    width: 100%;
    height: 4px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 2px;
    margin: 0.4rem 0 0.5rem;
    overflow: hidden;
  }
  .score-bar-fill {
    height: 100%;
    border-radius: 2px;
    background: var(--color-primary);
    transition: width 0.3s ease;
  }
  .score-bar-fill.score--ok  { background: #fb923c; }
  .score-bar-fill.score--bad { background: #f87171; }
  ```

- [ ] **Test** : chaque carte affiche une petite barre colorée sous le titre (bleue/verte pour les bons jeux, orange ou rouge pour les autres).

---

## Chapitre 4 — Complémentaires

---

### 4.1 — Ne pas charger 16 Mo d'un coup

**Option A — Sans backend (plus simple)**

- [ ] **Crée le fichier `scripts/split-games.js`** : un petit script Node.js qui lit `data/games.json`, le découpe en tranches de 5 000 jeux et écrit `data/games-1.json`, `data/games-2.json`, etc.
  ```js
  const fs   = require('fs')
  const data = JSON.parse(fs.readFileSync('data/games.json'))
  const size = 5000
  for (var i = 0; i < data.length; i += size) {
    var chunk = data.slice(i, i + size)
    var n     = Math.floor(i / size) + 1
    fs.writeFileSync('data/games-' + n + '.json', JSON.stringify(chunk))
  }
  ```
- [ ] **Exécute ce script une seule fois** avec `node scripts/split-games.js` depuis la racine du projet.
- [ ] **`src/api/games.js` → dans `fetchGames`** : charge d'abord `games-1.json` pour afficher les premiers jeux rapidement, puis enchaîne les autres fichiers avec des `.then()`.

**Option B — Avec backend Express (correct)**

- [ ] **Dans le fichier serveur Express** : ajoute une route `GET /api/games` qui lit `games.json`, filtre selon les query params (`search`, `genres`), pagine les résultats, et retourne `{ games: [...], total: N }`.
- [ ] **`src/api/games.js` → dans `fetchGames`** : remplace le `fetch('/data/games.json')` par `fetch('/api/games?page=1&limit=20')`.
- [ ] **`src/main.js`** : adapte `renderFilteredGames` — le filtrage et la pagination ne sont plus faits en JS côté client, c'est le serveur qui les fait.

---

### 4.2 — Synchronisation de l'état dans l'URL

- [ ] **Crée `src/utils/url.js`**.

- [ ] **Dans `url.js`** : écris `readStateFromUrl()`. Elle lit les paramètres dans l'URL et retourne un objet :
  ```js
  export function readStateFromUrl() {
    var params = new URLSearchParams(window.location.search)
    return {
      searchTerm:     params.get('search')  || '',
      selectedGenres: params.get('genres')  ? params.get('genres').split(',') : [],
      currentPage:    params.get('page')    ? Number(params.get('page')) : 1,
    }
  }
  ```

- [ ] **Dans `url.js`** : écris `writeStateToUrl(state)`. Elle met à jour l'URL sans recharger la page :
  ```js
  export function writeStateToUrl(state) {
    var params = new URLSearchParams()
    if (state.searchTerm)         params.set('search', state.searchTerm)
    if (state.selectedGenres.length) params.set('genres', state.selectedGenres.join(','))
    if (state.currentPage > 1)    params.set('page',   state.currentPage)
    var query = params.toString()
    history.replaceState(null, '', query ? '?' + query : window.location.pathname)
  }
  ```

- [ ] **`src/main.js`** : importe les deux fonctions depuis `./utils/url.js`.

- [ ] **`src/main.js` → dans `initApp`** : avant `fetchGames()`, lis l'URL et merge dans `appState` :
  ```js
  var urlState = readStateFromUrl()
  appState.searchTerm    = urlState.searchTerm
  appState.selectedGenres = urlState.selectedGenres
  appState.currentPage   = urlState.currentPage
  ```

- [ ] **`src/main.js` → dans `renderFilteredGames`** : appelle `writeStateToUrl(appState)` à la toute fin de la fonction.

- [ ] **Test** : effectue une recherche, copie l'URL, ouvre un nouvel onglet → la recherche est restaurée automatiquement.

---

### 4.3 — Corriger les liens morts du header

**Option A — Retrait rapide (recommandée si les pages n'existent pas encore)**

- [ ] **`templates/header.html`** : supprime les deux lignes `<a href="/catalogue">` et `<a href="/collections">` du `<nav>`.

**Option B — Création des pages**

- [ ] **Crée `public/catalogue.html`** : copie `public/index.html` et change le `<title>` en "CodexGame - Catalogue". La page peut utiliser le même `main.js` pour l'instant.
- [ ] **Crée `public/collections.html`** : copie la structure de base (head + placeholders header/footer), et dans le `<main>` mets un message "Fonctionnalité à venir".
- [ ] **Test** : clique sur chaque lien du header → aucun n'ouvre une page d'erreur.

---

### 4.4 — Favicon et Open Graph

- [ ] **Crée ou trouve un favicon** (image 32×32 pixels). Si tu n'en as pas, tu peux en générer un gratuit en ligne avec le nom "CG" stylisé. Place le fichier dans `public/favicon.ico`.

- [ ] **`public/index.html` → dans le `<head>`** : ajoute ces lignes :
  ```html
  <link rel="icon" href="/favicon.ico">
  <meta property="og:title"       content="CodexGame - Bibliothèque de jeux vidéo">
  <meta property="og:description" content="Explorez, recherchez et découvrez des milliers de jeux vidéo.">
  <meta property="og:type"        content="website">
  ```

- [ ] **Répète ces lignes** dans chaque autre page HTML que tu as créée (`game.html`, `catalogue.html`, etc.).

- [ ] **Test** : recharge la page → l'icône doit apparaître dans l'onglet du navigateur.

---

### 4.5 — Compteur de résultats

- [ ] **`public/index.html`** : ajoute cette ligne entre la section filtres et `#games-grid` :
  ```html
  <p id="results-count" class="results-count"></p>
  ```

- [ ] **`src/main.js`** : écris `updateResultsCount(count, total)`. Elle affiche un message différent selon si des filtres sont actifs ou non :
  ```js
  function updateResultsCount(count, total) {
    var el = qs('#results-count')
    if (count === total) {
      el.textContent = total + ' jeux disponibles'
    } else {
      el.textContent = count + ' jeu' + (count > 1 ? 'x' : '') + ' trouvé' + (count > 1 ? 's' : '')
    }
  }
  ```

- [ ] **`src/main.js` → dans `renderFilteredGames`** : appelle `updateResultsCount(filteredGames.length, appState.games.length)` juste après avoir calculé `filteredGames` et avant de découper en pages.

- [ ] **CSS** : ajoute dans un fichier existant :
  ```css
  .results-count {
    margin: 0.8rem 0 0;
    font-size: 0.85rem;
    color: var(--color-text-muted);
  }
  ```

- [ ] **Test** : au démarrage tu vois "27 075 jeux disponibles". Tape une recherche → le compteur se met à jour en temps réel.
