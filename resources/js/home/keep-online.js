function keepUserStatusOnline() {

	const handler = () => {
		try {

			fetch('/api/keep-online', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, text-plain, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": window.state._token
				},
				method: 'put'
			});
			
		} catch (e) {
	
			console.error(e.message);
			
		}
	}

	handler();
	setInterval(handler, 10000);

}

export default keepUserStatusOnline;
