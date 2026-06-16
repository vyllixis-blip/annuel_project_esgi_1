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

function normalizeDelimitedValue(rawValue) {
	if (Array.isArray(rawValue)) {
		return rawValue.map(function(value) { return String(value).trim() }).filter(Boolean)
	}

	if (typeof rawValue === 'string') {
		return rawValue.split(';').map(function(value) { return value.trim() }).filter(Boolean)
	}

	return []
}

export function calculateScore(positiveRatings, negativeRatings) {
	const positive = Number(positiveRatings)
	const negative = Number(negativeRatings)

	if (!Number.isFinite(positive) || !Number.isFinite(negative)) {
		return null
	}

	const total = positive + negative

	if (total <= 0) {
		return null
	}

	return Math.round((positive / total) * 100)
}

function normalizeGame(rawGame) {
	const positiveRatings = rawGame.positive_ratings || 0
	const negativeRatings = rawGame.negative_ratings || 0

	return {
		appid: rawGame.appid || '',
		name: rawGame.name || 'Jeu inconnu',
		releaseDate: rawGame.release_date || 'N/A',
		developer: rawGame.developer || 'N/A',
		publisher: rawGame.publisher || 'N/A',
		price: rawGame.price || 'N/A',
		requiredAge: rawGame.required_age || '0',
		categories: normalizeDelimitedValue(rawGame.categories),
		achievements: rawGame.achievements || '0',
		positiveRatings: positiveRatings,
		negativeRatings: negativeRatings,
		scorePercent: calculateScore(positiveRatings, negativeRatings),
		averagePlaytime: rawGame.average_playtime || '0',
		medianPlaytime: rawGame.median_playtime || '0',
		owners: rawGame.owners || 'N/A',
		platforms: normalizePlatforms(rawGame.platforms),
		genres: normalizeGenres(rawGame.genres)
	}
}

function fetchRawJson(filePath) {
	return fetch(filePath)
		.then(function(response) {
			if (!response.ok) {
				throw new Error('Impossible de charger ' + filePath)
			}

			return response.json()
		})
	}

function normalizeGames(rawGames) {
	return rawGames.map(normalizeGame)
}

function loadAllGames() {
	return fetchRawJson('/data/games.json').then(normalizeGames)
}

function notifyBackgroundGames(rawChunkGames, onBackgroundGames) {
	if (typeof onBackgroundGames !== 'function') {
		return
	}

	onBackgroundGames(normalizeGames(rawChunkGames))
}

function fetchBackgroundChunk(filePath, onBackgroundGames) {
	return fetchRawJson(filePath)
		.then(function(rawChunkGames) {
			notifyBackgroundGames(rawChunkGames, onBackgroundGames)
		})
		.catch(function(error) {
			console.error('Chargement en fond impossible :', error)
		})
}

function startBackgroundChunkLoading(filePaths, onBackgroundGames) {
	filePaths.forEach(function(filePath) {
		fetchBackgroundChunk(filePath, onBackgroundGames)
	})
}

function loadProgressiveGames(onBackgroundGames) {
	return fetchRawJson('/data/games-index.json')
		.then(function(indexData) {
			if (!indexData || !Array.isArray(indexData.files) || !indexData.files.length) {
				throw new Error('Index de jeux invalide')
			}

			const firstFilePath = '/data/' + indexData.files[0]
			const backgroundFilePaths = indexData.files.slice(1).map(function(fileName) {
				return '/data/' + fileName
			})

			return fetchRawJson(firstFilePath)
				.then(function(firstChunkGames) {
					const normalizedFirstChunk = normalizeGames(firstChunkGames)
					startBackgroundChunkLoading(backgroundFilePaths, onBackgroundGames)

					return normalizedFirstChunk
				})
		})
		.catch(function(error) {
			console.error('Mode progressif indisponible, fallback complet :', error)
			return loadAllGames()
		})
}

export function fetchGames(options) {
	const config = options || {}

	if (config.strategy === 'progressive') {
		return loadProgressiveGames(config.onBackgroundGames)
	}

	return loadAllGames()
		.then(function(games) {
			return games
		})
}
