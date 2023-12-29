import appendChannel from '../channel/load/append-channel';
import sendNotification from './send-notification';

const forms = [...document.getElementsByClassName('add-friend-form')];
const searchChannel = document.getElementById('search-channel-form');
const emptyChannelList = document.getElementById('empty-channel-list');

forms.forEach(
	form => form.addEventListener('submit', async e => {

		e.preventDefault();

		const errorContainer = form.querySelector('div[name="error"]');
		const successContainer = form.querySelector('div[name="success"]');

		errorContainer.innerText = '';
		successContainer.innerText = '';

		const formEntries = Object.fromEntries(new FormData(form));

		try {

			const response = await fetch('/api/friend', {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, text-plain, */*",
					"X-Requested-With": "XMLHttpRequest",
				},
				method: 'post',
				body: JSON.stringify(formEntries)
			})
		
			const responseJson = await response.json();

			if (responseJson.error) {
				errorContainer.innerText = responseJson.error;
				return;
			}

			const friend = responseJson.friend;

			successContainer.innerText = `Added ${friend.name} as channel!`;
			
			window.state.channels[friend.channel.id] = friend;

			emptyChannelList.classList.add('hidden');

			appendChannel(friend, searchChannel.value?.trim());

			window.history.pushState(null, null, `/app/channel/${friend.channel.id}`);
			window.dispatchEvent(new Event('popstate'));

			sendNotification(formEntries.friendId);

		} catch (e) {

			errorContainer.innerText = e.message;
			
		}

	})
);
