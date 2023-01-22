const search = document.querySelector('.search')
const li = document.querySelectorAll('.order')

const compare = e => {
	const text = e.target.value.toLowerCase()

    console.log(li)
	console.log(text)
	li.forEach(el => {
		const task = el.textContent
		if (task.toLowerCase().indexOf(text) !== -1) {
			el.style.display = 'block'
		} else {
			el.style.display = 'none'
		}
	})
}

// const enterCheck = e => {
//    if (e.key === 'Enter'){compare()}

search.addEventListener('keyup', compare)