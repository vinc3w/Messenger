const chat = document.getElementById('chat');
const noChannelDisplay = document.getElementById('no-channel-display');

export default {
	render: () => {
		chat.classList.add('hidden');
		noChannelDisplay.classList.remove('hidden');
	},
	hide: () => {
		chat.classList.remove('hidden');
		noChannelDisplay.classList.add('hidden');
	}	
};
