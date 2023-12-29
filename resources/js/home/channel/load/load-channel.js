import appendChannel from "./append-channel";

import '../../friend/add-friend';
import '../search/search-channel';

const emptyChannelList = document.getElementById('empty-channel-list');

async function loadChannel() {

	try {

		const response = await fetch('/api/friend');
		const responseJson = await response.json();

		window.state.totalNewMessageCount = 0;
		window.state.channels = {};

		responseJson.friends.forEach(f => appendChannel(f));

		if (!Object.entries(window.state.channels).length) {
			emptyChannelList.classList.remove('hidden');
		}

	} catch (e) {

		console.error(e)
		
	}

};

loadChannel();
