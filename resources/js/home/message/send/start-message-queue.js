import appendMessage from "../load/append-message";
import emptyMessageContainer from '../chatbox/empty-message-container';

const messageContainer = document.getElementById('message-container');
const messageError = document.getElementById('message-error');

async function startMessageQueue(channelId, formEntries) {

	if (!window.state.messageQueue) {
		window.state.messageQueue = {};
	}

	if (!window.state.messageQueue?.[channelId]) {
		window.state.messageQueue[channelId] = {
			isRunning: false,
			messages: []
		};
	}

	window.state.messageQueue[channelId].messages.push(formEntries);
	
	if (window.state.messageQueue[channelId].isRunning) return;

	window.state.messageQueue[channelId].isRunning = true;

	for (let i = 0;; i++) {

		if (!window.state.messageQueue[channelId].messages[i]) {
			delete window.state.messageQueue[channelId];
			break;
		}

		const response = await fetch('/api/message', {
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json, text-plain, */*",
				"X-Requested-With": "XMLHttpRequest",
			},
			method: 'post',
			body: JSON.stringify(window.state.messageQueue[channelId].messages[i])
		});

		const responseJson = await response.json();

		emptyMessageContainer.hide();

		if (channelId !== window.state.channelId) {
			/**
			 * since this code is in appendMessage adn appendMessage may not run,
			 * I have copied the code to here 
			 */
			const channelLastMessage = document.querySelector(`#channel-${channelId} .last-message`);
			channelLastMessage.innerText = `${window.state.user.name}: ` + window.messageQueue[channelId].messages[i].message;
			continue;
		}

		if (responseJson.error) {
			messageError.insertAdjacentHTML(
				`beforeend`,
				`<div>${responseJson.error}</div>`
			);
			return;
		}

		appendMessage(responseJson.message);

		messageContainer.scroll(0, messageContainer.scrollHeight);

	}

}

export default startMessageQueue;
