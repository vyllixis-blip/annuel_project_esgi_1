import { fetchGames } from './api/games.js'
import { createGameCard } from './components/game-card.js'
import { createGenreFilter } from './components/genre-filter.js'
import { injectFooter, injectHeader } from './components/layout.js'
import { clearElement, qs } from './utils/dom.js'

const appState = {
    games: [],
    searchTerm: '',
    selectedGenres: []
}

function extractUniqueGenres(games) {
    const genreSet = new Set()

    games.forEach(function(game) {
        game.genres.forEach(function(genre) {
            genreSet.add(genre)
        })
    })

    return Array.from(genreSet).sort(function(a, b) {
        return a.localeCompare(b, 'fr')
    })
}

function renderGamesGrid(games) {
    const gamesGrid = qs('#games-grid')
    clearElement(gamesGrid)

    games.forEach(function(game) {
        gamesGrid.appendChild(createGameCard(game))
    })
}

function matchesSearch(game, searchTerm) {
    return game.name.toLowerCase().includes(searchTerm)
}

function matchesGenres(game, selectedGenres) {
    if (!selectedGenres.length) {
        return true
    }

    return selectedGenres.every(function(genre) {
        return game.genres.includes(genre)
    })
}

function renderFilteredGames() {
    const filteredGames = appState.games.filter(function(game) {
        return matchesSearch(game, appState.searchTerm) && matchesGenres(game, appState.selectedGenres)
    })

    renderGamesGrid(filteredGames)
}

function initSearch() {
    const searchInput = qs('#search-input')

    searchInput.addEventListener('input', function(event) {
        appState.searchTerm = event.target.value.trim().toLowerCase()
        renderFilteredGames()
    })
}

function initGenreFilter(games) {
    const filterHost = qs('#genre-filter')
    clearElement(filterHost)

    const genres = extractUniqueGenres(games)
    const filterElement = createGenreFilter(genres, function(selectedGenres) {
        appState.selectedGenres = selectedGenres
        renderFilteredGames()
    })

    filterHost.appendChild(filterElement)
}

function initApp() {
    injectHeader().catch(function(error) {
        console.error('injectHeader :', error)
    })

    injectFooter().catch(function(error) {
        console.error('injectFooter :', error)
    })

    fetchGames()
        .then(function(games) {
            appState.games = games
            initSearch()
            initGenreFilter(games)
            renderFilteredGames()
        })
        .catch(function(error) {
            console.error('initApp :', error)
        })
}

initApp()
