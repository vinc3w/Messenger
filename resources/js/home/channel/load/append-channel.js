import createChannelElement from "./create-channel-element";

const channelList = document.getElementById('channel-list');
const newMessageCountContainers = [...document.getElementsByClassName('new-message-count')];
const emptyChannelList = document.getElementById('empty-channel-list');

function appendChannel(friend, matchedQuery) {

	if (matchedQuery && !friend.name.includes(matchedQuery)) return;

	window.state.channels[friend.channel.id] = friend;

	/**
	 * Update total new message count
	 */
	window.state.totalNewMessageCount += friend.channel.newMessageCount || 0;
	newMessageCountContainers.forEach(container => {
		if (!friend.channel.newMessageCount) return;
		container.innerText = window.state.totalNewMessageCount > 9 ? '9+' : window.state.totalNewMessageCount;
	});
	
	channelList.insertAdjacentHTML(
		'beforeend',
		createChannelElement(friend, matchedQuery)
	);

	const channelElement = document.getElementById(`channel-${friend.channel.id}`);

	document.getElementById(`unfriend-${friend.channel.id}-button`).onclick = async () => {

		try {
			
			channelElement.remove();
			delete window.state.channels[friend.channel.id];

			if (!Object.entries(window.state.channels).length) {
				emptyChannelList.classList.remove('hidden');
			}


			if (window.location.pathname === `/app/channel/${friend.channel.id}`) {
				window.history.replaceState(null, null, '/app');
				window.dispatchEvent(new Event('popstate'));
			}

			fetch(`/api/friend/${friend.channel.id}`, {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, text-plain, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": window.state._token
				},
				method: 'delete',
				body: JSON.stringify({
					receiverId: friend.id,
					channelId: friend.channel.id,
				})
			});
			
		} catch (e) {

			console.error(e);
			
		}

	}

}

export default appendChannel;