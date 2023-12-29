function sendNotification(receiverId) {

	try {

		fetch('/api/notification', {
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json, text-plain, */*",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": window.state._token
			},
			method: 'post',
			body: JSON.stringify({ receiverId })
		});

	} catch (e) {
		
		console.error(e);

	}

}

export default sendNotification;