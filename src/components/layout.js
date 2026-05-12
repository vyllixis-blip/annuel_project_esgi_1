import { qs } from '../utils/dom.js'

function includePartial(selector, filePath) {
	const target = qs(selector)

	if (!target) {
		return Promise.resolve()
	}

	return fetch(filePath)
		.then(function(response) {
			if (!response.ok) {
				throw new Error('Impossible de charger ' + filePath)
			}

			return response.text()
		})
		.then(function(html) {
			target.innerHTML = html
		})
}

export function injectHeader() {
	return includePartial('#header-placeholder', '/templates/header.html')
}

export function injectFooter() {
	return includePartial('#footer-placeholder', '/templates/footer.html')
}
