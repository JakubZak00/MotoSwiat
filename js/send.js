function sendIt() {
	const name = document.querySelector('#name').value
	const email = document.querySelector('#email').value
	const subject = document.querySelector('#subject').value
	const message = document.querySelector('#message').value

	const url =
		'https://script.google.com/macros/s/AKfycbwjD7Hw9wvuccwhi3ijxrYssdD7AYnwqC7wDaqjSksBf10cqQFUh1oJfZFi7BAyL1bu/exec'
	const encoded_data = encodeURI(JSON.stringify({ name: name, email: email, subject: subject, message: message }))
	const request = `${url}?data=${encoded_data}`
	fetch(request)
		.then(resp => resp.json())
		.then(data => console.log(data))
}
