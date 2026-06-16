import { clearElement, createElement } from '../utils/dom.js'

export function showLoading(container) {
    if (!container) {
        return
    }

    clearElement(container)

    const wrapper = createElement('div', {
        className: 'loading-state',
        attrs: {
            role: 'status',
            'aria-live': 'polite',
            'aria-label': 'Chargement des jeux'
        }
    })

    const spinner = createElement('span', {
        className: 'loading-spinner',
        attrs: { 'aria-hidden': 'true' }
    })

    const text = createElement('p', {
        className: 'loading-text',
        text: 'Chargement des jeux en cours...'
    })

    const skeletonGrid = createElement('div', {
        className: 'loading-skeleton-grid',
        attrs: { 'aria-hidden': 'true' }
    })

    for (let index = 0; index < 6; index++) {
        skeletonGrid.appendChild(createElement('div', {
            className: 'loading-skeleton-card'
        }))
    }

    wrapper.appendChild(spinner)
    wrapper.appendChild(text)
    wrapper.appendChild(skeletonGrid)

    container.appendChild(wrapper)
}

export function hideLoading(container) {
    if (!container) {
        return
    }

    clearElement(container)
}
