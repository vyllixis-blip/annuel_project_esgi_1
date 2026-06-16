import { createElement, createTagList } from '../utils/dom.js'

function createInfoRow(className, label, value) {
	return createElement('p', {
		className: className,
		text: label + ' : ' + value
	})
}

function formatPriceDisplay(price) {
	if (price === 'N/A' || price === null || price === undefined) {
		return 'N/A'
	}

	const numericPrice = Number.parseFloat(String(price).replace(',', '.'))

	if (!Number.isFinite(numericPrice)) {
		return 'N/A'
	}

	if (numericPrice <= 0) {
		return 'Gratuit'
	}

	return numericPrice.toFixed(2).replace('.', ',') + ' €'
}

function formatReleaseDateDisplay(releaseDate) {
	if (!releaseDate || releaseDate === 'N/A') {
		return 'N/A'
	}

	const parsedDate = new Date(releaseDate)

	if (Number.isNaN(parsedDate.getTime())) {
		return 'N/A'
	}

	return parsedDate.toLocaleDateString('fr-FR', {
		day: 'numeric',
		month: 'long',
		year: 'numeric'
	})
}

export function createScoreBadge(scorePercent) {
	if (scorePercent === null || scorePercent === undefined) {
		return createElement('span', {
			className: 'score-badge',
			text: 'N/A'
		})
	}

	if (scorePercent >= 80) {
		return createElement('span', {
			className: 'score-badge score--good',
			text: scorePercent + ' %'
		})
	}

	if (scorePercent >= 50) {
		return createElement('span', {
			className: 'score-badge score--ok',
			text: scorePercent + ' %'
		})
	}

	return createElement('span', {
		className: 'score-badge score--bad',
		text: scorePercent + ' %'
	})
}

function getScoreMeta(scorePercent) {
	if (scorePercent === null || scorePercent === undefined || !Number.isFinite(Number(scorePercent))) {
		return {
			value: 0,
			className: '',
			text: 'Aucune note'
		}
	}

	if (scorePercent < 50) {
		return {
			value: scorePercent,
			className: 'score--bad',
			text: scorePercent + ' % · Deconseille'
		}
	}

	if (scorePercent < 80) {
		return {
			value: scorePercent,
			className: 'score--ok',
			text: scorePercent + ' % · Mitige'
		}
	}

	return {
		value: scorePercent,
		className: 'score--good',
		text: scorePercent + ' % · Tres recommande'
	}
}

export function createGameCard(game) {
	const coverImage = createElement('img', {
		className: 'game-cover game-card-cover',
		attrs: {
			src: 'https://cdn.akamai.steamstatic.com/steam/apps/' + game.appid + '/header.jpg',
			alt: game.name,
			loading: 'lazy'
		}
	})

	coverImage.addEventListener('load', function() {
		coverImage.style.opacity = '1'
	})

	coverImage.addEventListener('error', function() {
		const gameName = String(game.name || '').trim().toUpperCase()
		const initials = gameName.slice(0, 2) || '??'

		const placeholder = createElement('div', {
			className: 'game-cover game-cover-placeholder',
			attrs: {
				'aria-label': 'Image indisponible pour ' + game.name
			}
		}, [
			createElement('span', {
				className: 'game-cover-initials',
				text: initials
			})
		])

		coverImage.replaceWith(placeholder)
	})

	if (coverImage.complete) {
		coverImage.style.opacity = '1'
	}

	const title = createElement('h3', {
		className: 'game-name',
		text: game.name
	})
	const scoreMeta = getScoreMeta(game.scorePercent)

	const scoreFillClassName = (function() {
		if (!scoreMeta.className) {
			return 'score-bar-fill'
		}

		return 'score-bar-fill ' + scoreMeta.className
	})()

	const scoreBarFill = createElement('div', {
		className: scoreFillClassName,
		attrs: {
			style: 'width: ' + scoreMeta.value + '%'
		}
	})

	const scoreBarTrack = createElement('div', {
		className: 'score-bar-track',
		attrs: {
			'aria-label': scoreMeta.className
				? 'Score de recommandation: ' + scoreMeta.value + '%'
				: 'Score de recommandation indisponible'
		}
	}, [scoreBarFill])

	const scoreLabel = createElement('p', {
		className: 'score-label' + (scoreMeta.className ? ' ' + scoreMeta.className : ''),
		text: scoreMeta.text
	})

	const dateDisplay = formatReleaseDateDisplay(game.releaseDate)
	const priceDisplay = formatPriceDisplay(game.price)
	const releaseDate = createInfoRow('release-date', 'Date de sortie', dateDisplay)
	const price = createInfoRow('price', 'Prix', priceDisplay)
	const developer = createInfoRow('developer', 'Developpeur', game.developer || 'N/A')
	const platformTags = createElement('div', {
		className: 'card-meta-row'
	}, [
		createElement('span', {
			className: 'card-meta-label',
			text: 'Plateformes'
		}),
		createTagList(game.platforms, 'card-tag-list platform-tags')
	])
	const genreTags = createElement('div', {
		className: 'card-meta-row'
	}, [
		createElement('span', {
			className: 'card-meta-label',
			text: 'Genres'
		}),
		createTagList(game.genres, 'card-tag-list genre-tags')
	])
	const cardContent = createElement('div', {
		className: 'game-card-content'
	}, [title, scoreBarTrack, scoreLabel, releaseDate, price, developer, platformTags, genreTags])

	const card = createElement(
		'article',
		{ className: 'game-card' },
		[coverImage, cardContent]
	)

	return createElement('a', {
		className: 'game-card-link',
		attrs: {
			href: '/game.html?id=' + encodeURIComponent(game.appid)
		}
	}, [card])
}
