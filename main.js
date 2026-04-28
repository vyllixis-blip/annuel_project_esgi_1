function actialisationGames() {
    const searchInput = document.getElementById('search').value.toLowerCase();
    const gameCards = document.getElementsByClassName('game-card');
    Array.from(gameCards).forEach(card => {
        const title = card.querySelector('.name').textContent.toLowerCase();
        if (title.includes(searchInput)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}

document.getElementById('search').addEventListener('input', function() {
    actialisationGames()
})

function getAllGames() {
    fetch('./steam.json')
        .then(response => response.json())
        .then(data => {
            const gamesGrid = document.getElementsByClassName('games-grid')[0]
            data.forEach(game => {
                const gameCard = document.createElement('div');
                gameCard.classList.add('game-card');

                const title = document.createElement('h3');
                title.className = 'name';
                title.textContent = game.name;

                const release = document.createElement('p');
                release.textContent = `Release Date: ${game.release_date}`;

                const price = document.createElement('p');
                price.textContent = `Price: ${game.price}`;

                const pos = document.createElement('p');
                pos.textContent = `Positive Ratings: ${game.positive_ratings}`;

                const neg = document.createElement('p');
                neg.textContent = `Negative Ratings: ${game.negative_ratings}`;

                const platforms = document.createElement('p');
                platforms.textContent = `Platforms: ${
                    Array.isArray(game.platforms) ? game.platforms.join(', ') : game.platforms
                }`;

                const genres = document.createElement('p');
                genres.textContent = `Genres: ${
                    Array.isArray(game.genres) ? game.genres.join(', ') : game.genres
                }`;

                gameCard.append(title, release, price, pos, neg, platforms, genres);
                gamesGrid.appendChild(gameCard);
            })
        })
        .catch(error => console.error('Error fetching games:', error))
}

getAllGames()

async function includePartial(selector, filePath) {
	const target = document.querySelector(selector)

	if (!target) {
		return;
	}

	try {
		const response = await fetch(filePath)
		if (!response.ok) {
			throw new Error(`Impossible de charger ${filePath}`)
		}

		target.innerHTML = await response.text()
	} catch (error) {
		console.error(error.message)
	}
}

async function initLayout() {
	await includePartial('#header-placeholder', '/components/header.html')
	await includePartial('#footer-placeholder', '/components/footer.html')
}

initLayout()
