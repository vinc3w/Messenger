import appendMessage from '../message/load/append-message';
import emptyMessageContainer from '../message/chatbox/empty-message-container';
import markAsRead from '../message/read/mark-as-read';

const messageContainer = document.getElementById('message-container');

function startMessageSocket(channelId) {

	const channel = Echo.private(`private.chat.${channelId}`);
	
	channel.listen('.receive.message', ({ message }) => {

		if (message.sender_id === window.state.user.id) return;

		appendMessage(message);

		messageContainer.scroll(0, messageContainer.scrollHeight);
		emptyMessageContainer.hide();

		markAsRead(channelId, false);

	});

	channel.listen('.delete.message', ({ messageId }) => {

		const messageElement = document.getElementById(`message-${messageId}`);

		if (!messageElement) return;

		window.state.messages.splice(window.state.messages.indexOf(window.state.messages.find(m => m.id === messageId)), 1);

		messageElement.remove();

		if  (!window.state.messages.length) {
			emptyMessageContainer.render();
		}

	});

}

export default startMessageSocket;
