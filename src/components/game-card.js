import { createElement } from '../utils/dom.js'

function createInfoRow(className, label, value) {
	return createElement('p', {
		className: className,
		text: label + ' : ' + value
	})
}

export function createGameCard(game) {
	const title = createElement('h3', {
		className: 'game-name',
		text: game.name
	})

	const releaseDate = createInfoRow('release-date', 'Date de sortie', game.releaseDate)
	const price = createInfoRow('price', 'Prix', game.price)
	const positiveRatings = createInfoRow('positive-ratings', 'Notes positives', game.positiveRatings)
	const negativeRatings = createInfoRow('negative-ratings', 'Notes negatives', game.negativeRatings)
	const platforms = createInfoRow('platforms', 'Plateformes', game.platforms.join(', '))
	const genres = createInfoRow('genres', 'Genres', game.genres.join(', '))

	return createElement(
		'article',
		{ className: 'game-card' },
		[title, releaseDate, price, positiveRatings, negativeRatings, platforms, genres]
	)
}
