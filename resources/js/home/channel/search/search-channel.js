import appendChannel from "../load/append-channel";

const channelList = document.getElementById('channel-list');
const searchChannel = document.getElementById('search-channel-form');

searchChannel.addEventListener('keyup', e => {

	const value = searchChannel.value?.trim();

	channelList.innerHTML = '';

	if (!value) {
		for (const f of Object.values(window.state.channels)) {
			appendChannel(f);
		}
		return;
	}

	for (const f of Object.values(window.state.channels)) {
		appendChannel(f, value);
	}

});
