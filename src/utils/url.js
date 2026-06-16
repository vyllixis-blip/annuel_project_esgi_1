export function readStateFromUrl() {
    const params = new URLSearchParams(globalThis.location.search)
    const state = {}

    const search = params.get('search')

    if (search) {
        state.searchTerm = search.trim().toLowerCase()
    }

    const genres = params.get('genres')

    if (genres) {
        state.selectedGenres = genres
            .split(',')
            .map(function(value) { return value.trim() })
            .filter(Boolean)
    }

    const platforms = params.get('platforms')

    if (platforms) {
        state.selectedPlatforms = platforms
            .split(',')
            .map(function(value) { return value.trim() })
            .filter(Boolean)
    }

    const page = Number.parseInt(params.get('page') || '', 10)

    if (Number.isInteger(page) && page > 0) {
        state.currentPage = page
    }

    const maxPriceRaw = params.get('maxPrice')

    if (maxPriceRaw === 'Infinity') {
        state.maxPrice = Infinity
    } else if (maxPriceRaw !== null) {
        const parsedMaxPrice = Number.parseFloat(maxPriceRaw)

        if (Number.isFinite(parsedMaxPrice)) {
            state.maxPrice = parsedMaxPrice
        }
    }

    const sortBy = params.get('sort')

    if (sortBy) {
        state.sortBy = sortBy
    }

    return state
}

export function writeStateToUrl(state) {
    if (!globalThis.history || typeof globalThis.history.replaceState !== 'function') {
        return
    }

    const params = new URLSearchParams()

    if (state.searchTerm) {
        params.set('search', state.searchTerm)
    }

    if (Array.isArray(state.selectedGenres) && state.selectedGenres.length) {
        params.set('genres', state.selectedGenres.join(','))
    }

    if (Array.isArray(state.selectedPlatforms) && state.selectedPlatforms.length) {
        params.set('platforms', state.selectedPlatforms.join(','))
    }

    if (Number.isFinite(state.maxPrice) && state.maxPrice !== Infinity) {
        params.set('maxPrice', String(state.maxPrice))
    }

    if (state.sortBy && state.sortBy !== 'default') {
        params.set('sort', state.sortBy)
    }

    if (state.currentPage > 1) {
        params.set('page', String(state.currentPage))
    }

    const query = params.toString()
    const nextUrl = query
        ? globalThis.location.pathname + '?' + query
        : globalThis.location.pathname

    globalThis.history.replaceState(null, '', nextUrl)
}
