import { createElement } from '../utils/dom.js'

export function createSortSelect(onSort) {
    const wrapper = createElement('div', {
        className: 'sort-control'
    })

    const label = createElement('label', {
        className: 'sort-label',
        text: 'Trier les resultats'
    })

    const select = createElement('select', {
        className: 'sort-select',
        attrs: {
            id: 'sort-select',
            'aria-label': 'Trier les jeux'
        }
    })

    const options = [
        { value: 'default', text: 'Par defaut' },
        { value: 'name-asc', text: 'Nom (A → Z)' },
        { value: 'positive-desc', text: 'Note positive (max → min)' },
        { value: 'price-asc', text: 'Prix croissant' },
        { value: 'price-desc', text: 'Prix decroissant' },
        { value: 'release-desc', text: 'Date de sortie (plus recente)' }
    ]

    options.forEach(function(optionData) {
        const option = createElement('option', {
            attrs: { value: optionData.value },
            text: optionData.text
        })

        select.appendChild(option)
    })

    label.setAttribute('for', 'sort-select')

    select.addEventListener('change', function(event) {
        onSort(event.target.value)
    })

    wrapper.appendChild(label)
    wrapper.appendChild(select)

    return wrapper
}
