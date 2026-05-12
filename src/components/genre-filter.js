import { createElement } from '../utils/dom.js'

export function createGenreFilter(genres, onFilter) {
	const wrapper = createElement('div', { className: 'genre-filter-group' })

	genres.forEach(function(genre) {
		const checkbox = createElement('input', {
			attrs: {
				type: 'checkbox',
				value: genre,
				'aria-label': 'Filtrer par genre ' + genre
			}
		})

		checkbox.addEventListener('change', function() {
			const selectedGenres = Array.from(wrapper.querySelectorAll('input:checked')).map(function(input) {
				return input.value
			})

			onFilter(selectedGenres)
		})

		const label = createElement('label', { text: genre }, [checkbox])
		wrapper.appendChild(label)
	})

	return wrapper
}
