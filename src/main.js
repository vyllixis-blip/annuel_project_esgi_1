import { fetchGames } from './api/games.js'
import { createEmptyState } from './components/empty-state.js'
import { createGameCard } from './components/game-card.js'
import { createPriceFilter } from './components/price-filter.js'
import { createGenreFilter } from './components/genre-filter.js'
import { hideLoading, showLoading } from './components/loading.js'
import { createSortSelect } from './components/sort-select.js'
import { injectFooter, injectHeader } from './components/layout.js'
import { clearElement, createElement, debounce, qs, qsa } from './utils/dom.js'
import { readStateFromUrl, writeStateToUrl } from './utils/url.js'

const GAMES_PER_PAGE = 20

const appState = {
    games: [],
    searchTerm: '',
    selectedGenres: [],
    selectedPlatforms: [],
    maxPrice: Infinity,
    sortBy: 'default',
    currentPage: 1,
    isInitialized: false
}

function hydrateStateFromUrl() {
    const stateFromUrl = readStateFromUrl()

    if (typeof stateFromUrl.searchTerm === 'string') {
        appState.searchTerm = stateFromUrl.searchTerm
    }

    if (Array.isArray(stateFromUrl.selectedGenres)) {
        appState.selectedGenres = stateFromUrl.selectedGenres
    }

    if (Array.isArray(stateFromUrl.selectedPlatforms)) {
        appState.selectedPlatforms = stateFromUrl.selectedPlatforms
    }

    if (Number.isInteger(stateFromUrl.currentPage) && stateFromUrl.currentPage > 0) {
        appState.currentPage = stateFromUrl.currentPage
    }

    if (stateFromUrl.maxPrice === Infinity || Number.isFinite(stateFromUrl.maxPrice)) {
        appState.maxPrice = stateFromUrl.maxPrice
    }

    if (typeof stateFromUrl.sortBy === 'string' && stateFromUrl.sortBy) {
        appState.sortBy = stateFromUrl.sortBy
    }
}

function extractUniqueGenres(games) {
    const genreCount = {}

    games.forEach(function(game) {
        game.genres.forEach(function(genre) {
            genreCount[genre] = (genreCount[genre] || 0) + 1
        })
    })

    return Object.keys(genreCount).sort(function(a, b) {
        return genreCount[b] - genreCount[a]
    })
}

export function extractUniquePlatforms(games) {
    const platformCount = {}

    games.forEach(function(game) {
        game.platforms.forEach(function(platform) {
            platformCount[platform] = (platformCount[platform] || 0) + 1
        })
    })

    return Object.keys(platformCount).sort(function(a, b) {
        return platformCount[b] - platformCount[a]
    })
}

function renderGamesGrid(games) {
    const gamesGrid = qs('#games-grid')
    clearElement(gamesGrid)

    if (!games.length) {
        gamesGrid.appendChild(createEmptyState(resetFilters))
        return
    }

    games.forEach(function(game) {
        gamesGrid.appendChild(createGameCard(game))
    })
}

function updateResetButtonVisibility() {
    const resetButton = qs('#reset-filters-btn')

    if (!resetButton) {
        return
    }

    const hasActiveFilters = (
        appState.selectedGenres.length > 0 ||
        appState.selectedPlatforms.length > 0 ||
        appState.maxPrice !== Infinity ||
        appState.sortBy !== 'default'
    )

    resetButton.classList.toggle('hidden', !hasActiveFilters)
}

export function resetFilters() {
    appState.searchTerm = ''
    appState.selectedGenres = []
    appState.selectedPlatforms = []
    appState.maxPrice = Infinity
    appState.sortBy = 'default'
    appState.currentPage = 1

    const searchInput = qs('#search-input')

    if (searchInput) {
        searchInput.value = ''
    }

    const genreFilterHost = qs('#genre-filter')

    if (genreFilterHost) {
        qsa('input:checked', genreFilterHost).forEach(function(input) {
            input.checked = false
        })
    }

    const platformFilterHost = qs('#platform-filter')

    if (platformFilterHost) {
        qsa('input:checked', platformFilterHost).forEach(function(input) {
            input.checked = false
        })
    }

    const priceFilterHost = qs('#price-filter')

    if (priceFilterHost) {
        qsa('input:checked', priceFilterHost).forEach(function(input) {
            input.checked = false
        })

        const defaultPriceInput = qs('input[name="price-filter"][value="Infinity"]', priceFilterHost)

        if (defaultPriceInput) {
            defaultPriceInput.checked = true
        }
    }

    const sortSelect = qs('#sort-select')

    if (sortSelect) {
        sortSelect.value = 'default'
    }

    updateResetButtonVisibility()

    renderFilteredGames()
}

function buildPageNumbers(totalPages) {
    const pages = []
    const delta = 2

    for (let i = 1; i <= totalPages; i++) {
        if (
            i === 1 ||
            i === totalPages ||
            (i >= appState.currentPage - delta && i <= appState.currentPage + delta)
        ) {
            pages.push(i)
        }
    }

    const withEllipsis = []

    pages.forEach(function(page, index) {
        if (index > 0 && page - pages[index - 1] > 1) {
            withEllipsis.push(null)
        }
        withEllipsis.push(page)
    })

    return withEllipsis
}

function goToPage(page) {
    appState.currentPage = page
    renderFilteredGames()
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

function renderPagination(totalGames) {
    const pagination = qs('#pagination')
    clearElement(pagination)

    const totalPages = Math.ceil(totalGames / GAMES_PER_PAGE)

    if (totalPages <= 1) {
        return
    }

    const prevButton = createElement('button', {
        className: 'pagination-btn',
        attrs: {
            'aria-label': 'Page précédente',
            ...(appState.currentPage === 1 && { disabled: '' })
        }
    })
    prevButton.textContent = '←'

    if (appState.currentPage > 1) {
        prevButton.addEventListener('click', function() {
            goToPage(appState.currentPage - 1)
        })
    }

    pagination.appendChild(prevButton)

    buildPageNumbers(totalPages).forEach(function(page) {
        if (page === null) {
            const ellipsis = createElement('span', {
                className: 'pagination-ellipsis',
                text: '…'
            })
            pagination.appendChild(ellipsis)
            return
        }

        const isActive = page === appState.currentPage
        const pageBtn = createElement('button', {
            className: 'pagination-btn' + (isActive ? ' pagination-btn--active' : ''),
            attrs: {
                'aria-label': 'Page ' + page,
                'aria-current': isActive ? 'page' : null,
                ...(isActive && { disabled: '' })
            },
            text: String(page)
        })

        if (!isActive) {
            pageBtn.addEventListener('click', function() {
                goToPage(page)
            })
        }

        pagination.appendChild(pageBtn)
    })

    const nextButton = createElement('button', {
        className: 'pagination-btn',
        attrs: {
            'aria-label': 'Page suivante',
            ...(appState.currentPage === totalPages && { disabled: '' })
        }
    })
    nextButton.textContent = '→'

    if (appState.currentPage < totalPages) {
        nextButton.addEventListener('click', function() {
            goToPage(appState.currentPage + 1)
        })
    }

    pagination.appendChild(nextButton)
}

function formatCount(value) {
    return Number(value).toLocaleString('fr-FR')
}

function formatPlatformName(platform) {
    if (!platform) {
        return ''
    }

    if (platform.length <= 3) {
        return platform.toUpperCase()
    }

    return platform.charAt(0).toUpperCase() + platform.slice(1)
}

function renderHeroStats(games) {
    const statsHost = qs('#hero-stats')

    if (!statsHost) {
        return
    }

    clearElement(statsHost)

    const genresSet = new Set()
    const platformsSet = new Set()

    games.forEach(function(game) {
        game.genres.forEach(function(genre) {
            genresSet.add(genre)
        })

        game.platforms.forEach(function(platform) {
            platformsSet.add(platform)
        })
    })

    const prioritizedPlatforms = ['windows', 'mac', 'linux'].filter(function(platform) {
        return platformsSet.has(platform)
    })

    const platformLabel = prioritizedPlatforms.length
        ? prioritizedPlatforms.map(formatPlatformName).join(' / ')
        : Array.from(platformsSet).slice(0, 3).map(formatPlatformName).join(' / ') || 'N/A'

    const stats = [
        { value: formatCount(games.length), label: 'jeux' },
        { value: formatCount(genresSet.size), label: 'genres' },
        { value: platformLabel, label: 'plateformes' }
    ]

    stats.forEach(function(stat) {
        const statItem = createElement('span', {
            className: 'hero-stat-item'
        }, [
            createElement('span', {
                className: 'hero-stat-value',
                text: stat.value
            }),
            createElement('span', {
                className: 'hero-stat-label',
                text: stat.label
            })
        ])

        statsHost.appendChild(statItem)
    })
}

export function updateResultsCount(count, total) {
    const counter = qs('#results-count')

    if (!counter) {
        return
    }

    if (count === total) {
        counter.textContent = formatCount(total) + ' jeux disponibles'
        return
    }

    counter.textContent = formatCount(count) + ' jeux trouvés'
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

export function matchesPlatforms(game, selectedPlatforms) {
    if (!selectedPlatforms.length) {
        return true
    }

    return selectedPlatforms.some(function(platform) {
        return game.platforms.includes(platform)
    })
}

export function matchesPrice(game, maxPrice) {
    if (maxPrice === Infinity) {
        return true
    }

    if (game.price === 'N/A') {
        return false
    }

    const parsedPrice = Number.parseFloat(String(game.price).replace(',', '.'))

    if (!Number.isFinite(parsedPrice)) {
        return false
    }

    return parsedPrice <= maxPrice
}

function normalizePrice(price) {
    const parsedPrice = Number.parseFloat(String(price).replace(',', '.'))

    if (!Number.isFinite(parsedPrice)) {
        return 0
    }

    return parsedPrice
}

function normalizePositiveRatings(positiveRatings) {
    const parsedRatings = Number(positiveRatings)

    if (!Number.isFinite(parsedRatings)) {
        return 0
    }

    return parsedRatings
}

function normalizeReleaseDate(releaseDate) {
    const timeValue = Date.parse(releaseDate)

    if (!Number.isFinite(timeValue)) {
        return 0
    }

    return timeValue
}

export function applySorting(games) {
    const sortedGames = games.slice()

    switch (appState.sortBy) {
        case 'name-asc':
            sortedGames.sort(function(a, b) {
                return a.name.localeCompare(b.name, 'fr', { sensitivity: 'base' })
            })
            break
        case 'positive-desc':
            sortedGames.sort(function(a, b) {
                return normalizePositiveRatings(b.positiveRatings) - normalizePositiveRatings(a.positiveRatings)
            })
            break
        case 'price-asc':
            sortedGames.sort(function(a, b) {
                return normalizePrice(a.price) - normalizePrice(b.price)
            })
            break
        case 'price-desc':
            sortedGames.sort(function(a, b) {
                return normalizePrice(b.price) - normalizePrice(a.price)
            })
            break
        case 'release-desc':
            sortedGames.sort(function(a, b) {
                return normalizeReleaseDate(b.releaseDate) - normalizeReleaseDate(a.releaseDate)
            })
            break
        default:
            break
    }

    return sortedGames
}

function renderFilteredGames() {
    const filteredGames = appState.games.filter(function(game) {
        return (
            matchesSearch(game, appState.searchTerm) &&
            matchesGenres(game, appState.selectedGenres) &&
            matchesPlatforms(game, appState.selectedPlatforms) &&
            matchesPrice(game, appState.maxPrice)
        )
    })

    updateResultsCount(filteredGames.length, appState.games.length)

    const sortedGames = applySorting(filteredGames)

    const totalPages = Math.ceil(sortedGames.length / GAMES_PER_PAGE)

    if (appState.currentPage > totalPages) {
        appState.currentPage = 1
    }

    const start = (appState.currentPage - 1) * GAMES_PER_PAGE
    const pageGames = sortedGames.slice(start, start + GAMES_PER_PAGE)

    renderGamesGrid(pageGames)
    renderPagination(sortedGames.length)
    writeStateToUrl(appState)
}

function initSearch() {
    const searchInput = qs('#search-input')

    if (searchInput) {
        searchInput.value = appState.searchTerm
    }

    const handleSearchInput = debounce(function(event) {
        appState.searchTerm = event.target.value.trim().toLowerCase()
        appState.currentPage = 1
        updateResetButtonVisibility()
        renderFilteredGames()
    }, 250)

    searchInput.addEventListener('input', handleSearchInput)
}

function initGenreFilter(games) {
    const filterHost = qs('#genre-filter')
    clearElement(filterHost)

    const genres = extractUniqueGenres(games)
    const filterElement = createGenreFilter(genres, function(selectedGenres) {
        appState.selectedGenres = selectedGenres
        appState.currentPage = 1
        updateResetButtonVisibility()
        renderFilteredGames()
    }, {
        maxVisible: 7,
        searchPlaceholder: 'Rechercher un genre'
    })

    filterHost.appendChild(filterElement)

    qsa('input[type="checkbox"]', filterHost).forEach(function(input) {
        input.checked = appState.selectedGenres.includes(input.value)
    })
}

export function initPlatformFilter(games) {
    const filterHost = qs('#platform-filter')

    if (!filterHost) {
        return
    }

    clearElement(filterHost)

    const platforms = extractUniquePlatforms(games)
    const filterElement = createGenreFilter(platforms, function(selectedPlatforms) {
        appState.selectedPlatforms = selectedPlatforms
        appState.currentPage = 1
        updateResetButtonVisibility()
        renderFilteredGames()
    }, {
        maxVisible: 7,
        searchPlaceholder: 'Rechercher une plateforme'
    })

    filterHost.appendChild(filterElement)

    qsa('input[type="checkbox"]', filterHost).forEach(function(input) {
        input.checked = appState.selectedPlatforms.includes(input.value)
    })
}

export function initSort() {
    const searchSection = qs('.search-section')

    if (!searchSection) {
        return
    }

    const existingSortControl = qs('.sort-control', searchSection)

    if (existingSortControl) {
        existingSortControl.remove()
    }

    const sortElement = createSortSelect(function(sortByValue) {
        appState.sortBy = sortByValue
        appState.currentPage = 1
        updateResetButtonVisibility()
        renderFilteredGames()
    })

    const genreLabel = qs('.genre-label', searchSection)

    if (genreLabel) {
        genreLabel.before(sortElement)
    } else {
        searchSection.appendChild(sortElement)
    }

    const sortSelect = qs('#sort-select', sortElement)

    if (sortSelect) {
        sortSelect.value = appState.sortBy
    }
}

export function initPriceFilter() {
    const filterHost = qs('#price-filter')

    if (!filterHost) {
        return
    }

    clearElement(filterHost)

    const filterElement = createPriceFilter(function(maxPrice) {
        appState.maxPrice = maxPrice
        appState.currentPage = 1
        updateResetButtonVisibility()
        renderFilteredGames()
    })

    filterHost.appendChild(filterElement)

    qsa('input[name="price-filter"]', filterHost).forEach(function(input) {
        input.checked = String(appState.maxPrice) === input.value
    })
}

function initApp() {
    const gamesGrid = qs('#games-grid')
    const resetFiltersButton = qs('#reset-filters-btn')

    hydrateStateFromUrl()

    if (resetFiltersButton) {
        resetFiltersButton.addEventListener('click', resetFilters)
    }

    injectHeader().catch(function(error) {
        console.error('injectHeader :', error)
    })

    injectFooter().catch(function(error) {
        console.error('injectFooter :', error)
    })

    showLoading(gamesGrid)

    fetchGames({
        strategy: 'progressive',
        onBackgroundGames: function(nextGames) {
            appState.games = appState.games.concat(nextGames)
            renderHeroStats(appState.games)

            if (appState.isInitialized) {
                renderFilteredGames()
            }
        }
    })
        .then(function(games) {
            appState.games = games
            initSearch()
            initSort()
            initGenreFilter(games)
            initPlatformFilter(games)
            initPriceFilter()
            renderHeroStats(appState.games)
            updateResetButtonVisibility()
            appState.isInitialized = true
            hideLoading(gamesGrid)
            renderFilteredGames()
        })
        .catch(function(error) {
            console.error('initApp :', error)
            hideLoading(gamesGrid)
        })
}

initApp()
