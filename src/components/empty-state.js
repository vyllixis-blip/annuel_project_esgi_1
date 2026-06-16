import { createElement } from '../utils/dom.js'

export function createEmptyState(onReset) {
    const title = createElement('h3', {
        className: 'empty-state-title',
        text: 'Aucun jeu trouve pour ces criteres.'
    })

    const description = createElement('p', {
        className: 'empty-state-description',
        text: 'Essayez d\'elargir votre recherche ou de retirer certains filtres.'
    })

    const resetButton = createElement('button', {
        className: 'empty-state-reset-btn',
        attrs: { type: 'button' },
        text: 'Reinitialiser les filtres'
    })

    resetButton.addEventListener('click', function() {
        onReset()
    })

    return createElement('div', {
        className: 'empty-state'
    }, [title, description, resetButton])
}
