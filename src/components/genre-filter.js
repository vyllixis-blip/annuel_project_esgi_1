import { createElement } from '../utils/dom.js'

export function createGenreFilter(genres, onFilter, options) {
	const config = options || {}
	const maxVisible = Number.isInteger(config.maxVisible) && config.maxVisible > 0 ? config.maxVisible : 7
	const showSearch = config.showSearch !== false
	const searchPlaceholder = config.searchPlaceholder || 'Rechercher un filtre'

	const panel = createElement('div', { className: 'genre-filter-panel' })
	const wrapper = createElement('div', {
		className: 'genre-filter-group filter-list',
		attrs: {
			style: 'max-height: calc(' + maxVisible + ' * 2.35rem)'
		}
	})

	const filterLabels = []

	function applySearchFilter(searchTerm) {
		const normalizedSearch = searchTerm.trim().toLowerCase()

		filterLabels.forEach(function(label) {
			const value = label.dataset.value || ''
			label.classList.toggle('hidden', normalizedSearch.length > 0 && !value.includes(normalizedSearch))
		})
	}

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

		const text = createElement('span', {
			className: 'genre-filter-text',
			text: genre
		})

		const label = createElement('label', {
			attrs: {
				'data-value': genre.toLowerCase()
			}
		}, [checkbox, text])

		filterLabels.push(label)
		wrapper.appendChild(label)
	})

	if (showSearch) {
		const searchInput = createElement('input', {
			className: 'filter-search-input',
			attrs: {
				type: 'search',
				placeholder: searchPlaceholder,
				'aria-label': searchPlaceholder
			}
		})

		searchInput.addEventListener('input', function(event) {
			applySearchFilter(event.target.value)
		})

		panel.appendChild(searchInput)
	}

	panel.appendChild(wrapper)

	return panel
}
