import { fetchGames } from '../api/games.js'
import { injectFooter, injectHeader } from '../components/layout.js'
import { clearElement, createElement, qs } from '../utils/dom.js'

export function getGameIdFromUrl() {
    return new URLSearchParams(globalThis.location.search).get('id')
}

function createDetailValue(label, value) {
    return createElement('div', {
        className: 'detail-value'
    }, [
        createElement('p', {
            className: 'detail-value-label',
            text: label
        }),
        createElement('p', {
            className: 'detail-value-content',
            text: value
        })
    ])
}

function createSectionBlock(title, values) {
    const items = values.map(function(value) {
        return createDetailValue(value.label, value.content)
    })

    return createElement('section', {
        className: 'detail-section'
    }, [
        createElement('h3', {
            className: 'detail-section-title',
            text: title
        }),
        createElement('div', {
            className: 'detail-section-grid'
        }, items)
    ])
}

function formatList(values) {
    if (!Array.isArray(values) || !values.length) {
        return 'N/A'
    }

    return values.join(', ')
}

function formatPlaytime(minutes) {
    const numericValue = Number(minutes)

    if (!Number.isFinite(numericValue) || numericValue <= 0) {
        return 'N/A'
    }

    return numericValue + ' min'
}

function formatRequiredAge(requiredAge) {
    const numericAge = Number(requiredAge)

    if (!Number.isFinite(numericAge) || numericAge <= 0) {
        return 'Tout public'
    }

    return numericAge + '+'
}

function formatScore(scorePercent) {
    if (!Number.isFinite(scorePercent)) {
        return 'N/A'
    }

    return scorePercent + ' %'
}

export function renderGameDetail(game) {
    const host = qs('#game-detail')

    if (!host) {
        return
    }

    clearElement(host)

    if (!game) {
        host.appendChild(createElement('p', {
            className: 'game-detail-error',
            text: 'Jeu introuvable. Verifiez le parametre id dans l\'URL.'
        }))
        return
    }

    const heroImage = createElement('img', {
        className: 'detail-hero-image',
        attrs: {
            src: 'https://cdn.akamai.steamstatic.com/steam/apps/' + game.appid + '/capsule_616x353.jpg',
            alt: game.name,
            loading: 'lazy'
        }
    })

    heroImage.addEventListener('error', function() {
        heroImage.style.opacity = '0'
    })

    const hero = createElement('section', {
        className: 'detail-hero'
    }, [
        heroImage,
        createElement('div', {
            className: 'detail-hero-overlay'
        }, [
            createElement('h2', {
                className: 'detail-hero-title',
                text: game.name
            }),
            createElement('p', {
                className: 'detail-hero-subtitle',
                text: 'AppID : ' + game.appid + ' · Sortie : ' + game.releaseDate
            })
        ])
    ])

    const primaryInfo = createElement('section', {
        className: 'detail-primary'
    }, [
        createDetailValue('Prix', game.price),
        createDetailValue('Score', formatScore(game.scorePercent)),
        createDetailValue('Developpeur', game.developer),
        createDetailValue('Editeur', game.publisher)
    ])

    const secondaryInfo = createElement('div', {
        className: 'detail-sections'
    }, [
        createSectionBlock('Classification', [
            { label: 'Genres', content: formatList(game.genres) },
            { label: 'Plateformes', content: formatList(game.platforms) },
            { label: 'Categories', content: formatList(game.categories) }
        ]),
        createSectionBlock('Statistiques', [
            { label: 'Achievements', content: game.achievements },
            { label: 'Temps moyen', content: formatPlaytime(game.averagePlaytime) },
            { label: 'Temps median', content: formatPlaytime(game.medianPlaytime) },
            { label: 'Proprietaires', content: game.owners || 'N/A' },
            { label: 'Age requis', content: formatRequiredAge(game.requiredAge) },
            { label: 'Notes positives', content: String(game.positiveRatings) },
            { label: 'Notes negatives', content: String(game.negativeRatings) }
        ])
    ])

    const card = createElement('article', {
        className: 'game-detail-card'
    }, [
        hero,
        createElement('div', {
            className: 'detail-body'
        }, [primaryInfo, secondaryInfo])
    ])

    host.appendChild(card)
}

function initGameDetailPage() {
    injectHeader().catch(function(error) {
        console.error('injectHeader :', error)
    })

    injectFooter().catch(function(error) {
        console.error('injectFooter :', error)
    })

    const gameId = getGameIdFromUrl()

    if (!gameId) {
        renderGameDetail(null)
        return
    }

    fetchGames()
        .then(function(games) {
            const game = games.find(function(currentGame) {
                return String(currentGame.appid) === String(gameId)
            })

            renderGameDetail(game || null)
        })
        .catch(function(error) {
            console.error('initGameDetailPage :', error)
            renderGameDetail(null)
        })
}

document.addEventListener('DOMContentLoaded', initGameDetailPage)
