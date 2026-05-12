export function qs(selector, parent) {
	const scope = parent || document
	return scope.querySelector(selector)
}

export function qsa(selector, parent) {
	const scope = parent || document
	return Array.from(scope.querySelectorAll(selector))
}

export function createElement(tagName, options, children) {
	const element = document.createElement(tagName)
	const config = options || {}
	const childNodes = children || []

	if (config.className) {
		element.className = config.className
	}

	if (config.text) {
		element.textContent = config.text
	}

	if (config.attrs) {
		Object.keys(config.attrs).forEach(function(key) {
			element.setAttribute(key, config.attrs[key])
		})
	}

	childNodes.forEach(function(child) {
		element.appendChild(child)
	})

	return element
}

export function clearElement(element) {
	element.textContent = ''
}
