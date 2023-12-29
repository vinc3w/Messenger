const messageContainer = document.getElementById('message-container');
const emptyMessageContainer = document.getElementById('empty-message-container');

export default {
	render: () => {
		messageContainer.classList.add('hidden');
		emptyMessageContainer.classList.remove('hidden');
	},
	hide: () => {
		messageContainer.classList.remove('hidden');
		emptyMessageContainer.classList.add('hidden');
	}	
};
