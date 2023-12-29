import createMessageElement from "./create-message-element";
import focusInput from "../chatbox/focus-input";
import emptyMessageContainer from '../chatbox/empty-message-container';

const messageContainer = document.getElementById('message-container');
const reply = document.getElementById('reply');
const replyNamePreview = reply.querySelector('div[name=name]');
const replyMessagePreview = reply.querySelector('div[name=message]');
const messageForm = document.getElementById('message-form');
const replyToInput = messageForm.querySelector('input[name=replyTo]');

const channelName = document.getElementById('channel-name');

function appendMessage(message, startingNewMessage) {

	const replyMessage = document.getElementById(`message-${message.reply_to}`);
	const isAuthor = message.sender_id === window.state.user.id;
	
	const channelLastMessage = document.querySelector(`#channel-${message.channel_id} .last-message`);
	if (channelLastMessage) {
		channelLastMessage.innerText = (
			message.sender_id === window.state.user.id ? `${window.state.user.name}: ` : `${channelName.innerText}: `
		) + message.message;
	}

	window.state.messages.push(message);

	messageContainer.insertAdjacentHTML(
		'beforeend',
		createMessageElement(message, startingNewMessage)
	);

	const messageElement = document.getElementById(`message-${message.id}`);

	if (replyMessage) {
		messageElement.firstElementChild.onclick = () => {
			replyMessage.scrollIntoView({ behavior: 'smooth' });
			replyMessage.classList.add('bg-blue-200');
			setTimeout(() => replyMessage.classList.remove('bg-blue-200'), 500);
		}
	}

	document.getElementById(`reply-message-${message.id}-button`).onclick = e => {

		e.stopPropagation();

		window.state.previousMessageReplyElement?.classList.remove('ring-4');

		messageElement.classList.add('ring-4');
		reply.classList.remove('hidden');
		replyToInput.value = message.id;

		replyNamePreview.innerText = isAuthor ? window.state.user.name : channelName.innerText;
		replyMessagePreview.innerText = message.message;

		window.state.previousMessageReplyElement = messageElement;

		document.onkeyup = e => {
			if (e.code !== 'Escape') return;
			messageElement.classList.remove('ring-4');
			reply.classList.add('hidden');
			replyToInput.value = null;
			document.onkeyup = null;
		}

		focusInput();

	};

	if (!isAuthor) return;

	document.getElementById(`delete-message-${message.id}-button`).onclick = async e => {

		e.stopPropagation();

		try {

			await fetch(`/api/message/${message.id}`, {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, text-plain, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": window.state._token
				},
				method: 'delete',
				body: JSON.stringify({
					channelId: message.channel_id,
				})
			});

			window.state.messages.splice(window.state.messages.indexOf(window.state.messages.find(m => m.id === message.id)), 1);
			
			messageElement.remove();

			if  (!window.state.messages.length) {
				emptyMessageContainer.render();
			}

			focusInput();
			
		} catch (e) {

			console.error(e);
			
		}

	};

}

export default appendMessage;
