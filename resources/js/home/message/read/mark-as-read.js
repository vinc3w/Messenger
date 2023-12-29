const newMessageCountContainers = [...document.getElementsByClassName('new-message-count')];

async function markAsRead(channelId, showNewMessageCOunt = true) {

	try {

		/**
		 * put null instead of an id of a message
		 * reason: not updating a single unseen message, updating multiple unseen messages
		 */
		await fetch('/api/message/null', {
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json, text-plain, */*",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": window.state._token
			},
			method: 'PATCH',
			body: JSON.stringify({ channelId })
		});

		if (!window.state.channels[channelId] && !showNewMessageCOunt) return;
		
		window.state.channels[channelId].channel.newMessageCount -= window.state.channels[channelId].channel.newMessageCount;

		newMessageCountContainers.forEach(container => {
			container.innerText = (
				window.state.channels[channelId].channel.newMessageCount > 9 ?
					'9+' :
					window.state.channels[channelId].channel.newMessageCount
			) || '';
		});

		document.getElementById(`channel-${channelId}-new-message-count`).innerText = '';
		
	} catch (e) {
		
		console.log(e)

	}

}

export default markAsRead;
