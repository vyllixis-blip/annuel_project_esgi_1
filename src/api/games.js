function normalizeGenres(rawGenres) {
	if (Array.isArray(rawGenres)) {
		return rawGenres.map(function(genre) { return String(genre).trim() }).filter(Boolean)
	}

	if (typeof rawGenres === 'string') {
		return rawGenres.split(';').map(function(genre) { return genre.trim() }).filter(Boolean)
	}

	return []
}

function normalizePlatforms(rawPlatforms) {
	if (Array.isArray(rawPlatforms)) {
		return rawPlatforms.map(function(platform) { return String(platform).trim() }).filter(Boolean)
	}

	if (typeof rawPlatforms === 'string') {
		return rawPlatforms.split(';').map(function(platform) { return platform.trim() }).filter(Boolean)
	}

	return []
}

function normalizeGame(rawGame) {
	return {
		name: rawGame.name || 'Jeu inconnu',
		releaseDate: rawGame.release_date || 'N/A',
		price: rawGame.price || 'N/A',
		positiveRatings: rawGame.positive_ratings || 0,
		negativeRatings: rawGame.negative_ratings || 0,
		platforms: normalizePlatforms(rawGame.platforms),
		genres: normalizeGenres(rawGame.genres)
	}
}

export function fetchGames() {
	return fetch('/data/games.json')
		.then(function(response) {
			if (!response.ok) {
				throw new Error('Impossible de charger les jeux')
			}

			return response.json()
		})
		.then(function(rawGames) {
			return rawGames.map(normalizeGame)
		})
}
