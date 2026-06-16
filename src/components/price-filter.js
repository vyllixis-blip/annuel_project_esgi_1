import { createElement } from '../utils/dom.js'

const PRICE_RANGES = [
    { label: 'Tous', max: Infinity },
    { label: 'Gratuit', max: 0 },
    { label: '< 5 EUR', max: 5 },
    { label: '< 15 EUR', max: 15 },
    { label: '< 30 EUR', max: 30 }
]

export function createPriceFilter(onFilter) {
    const wrapper = createElement('div', { className: 'price-filter-group' })

    PRICE_RANGES.forEach(function(range, index) {
        const radio = createElement('input', {
            attrs: {
                type: 'radio',
                name: 'price-filter',
                value: String(range.max),
                'aria-label': 'Filtrer par prix ' + range.label,
                ...(index === 0 && { checked: '' })
            }
        })

        radio.addEventListener('change', function() {
            if (!radio.checked) {
                return
            }

            onFilter(range.max)
        })

        const label = createElement('label', { text: range.label }, [radio])
        wrapper.appendChild(label)
    })

    return wrapper
}
