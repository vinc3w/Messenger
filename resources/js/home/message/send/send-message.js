import startMessageQueue from "./start-message-queue";

const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const messageError = document.getElementById('message-error');
const channelIdInput = messageForm.querySelector('input[name=channelId]');
const replyToInput = messageForm.querySelector('input[name=replyTo]');
const reply = document.getElementById('reply');
const replyCancelBtn = reply.querySelector('button[name=cancel-btn]');

messageForm.addEventListener('submit', async e => {

	e.preventDefault();

	if (!messageInput.value) return;

	messageError.innerHTML = '';

	const channelId = window.state.channelId;
	channelIdInput.value = channelId;

	try {

		const formEntries = Object.fromEntries(new FormData(messageForm));
		startMessageQueue(channelId, formEntries);
		
		replyToInput.value = '';
		messageInput.value = '';
		
	} catch (e) {

		console.error(e);
		
	}

});

replyCancelBtn.addEventListener('click', () => {
	
	window.state.previousMessageReplyElement.classList.remove('ring-4');
	reply.classList.add('hidden');
	replyToInput.value = null;

});

messageForm.addEventListener('submit', e => {
	
	window.state.previousMessageReplyElement?.classList.remove('ring-4');
	reply.classList.add('hidden');

});
