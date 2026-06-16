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
			if (config.attrs[key] !== null && config.attrs[key] !== undefined) {
				element.setAttribute(key, config.attrs[key])
			}
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

export function debounce(fn, delay) {
	let timer

	return function() {
		const args = arguments

		clearTimeout(timer)
		timer = setTimeout(() => {
			fn.apply(this, args)
		}, delay)
	}
}

export function createTagList(items, className) {
	const normalizedItems = Array.isArray(items)
		? items.map(function(item) { return String(item).trim() }).filter(Boolean)
		: []

	const tags = normalizedItems.map(function(item) {
		return createElement('span', {
			className: 'card-tag',
			text: item
		})
	})

	if (!tags.length) {
		tags.push(createElement('span', {
			className: 'card-tag card-tag--empty',
			text: 'N/A'
		}))
	}

	return createElement('div', {
		className: className || 'card-tag-list'
	}, tags)
}
