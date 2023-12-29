import focusInput from "../chatbox/focus-input";
import appendMessage from "./append-message";
import markAsRead from "../read/mark-as-read";
import emptyMessageContainer from '../chatbox/empty-message-container';
import noChannelDisplay from "../chatbox/no-channel-display";
import startMessageSocket from "../../sockets/message";

const messageContainer = document.getElementById('message-container');
const channelName = document.getElementById('channel-name');
const channelStatus = document.getElementById('channel-status');
const chatUserProfileImage = document.getElementById('chat-user-profile-image');

async function loadMessage() {

	const channelId = window.state.channelId;

	/**
	 * prevent redundant reload of already fetched messages
	 */
	if (window.state.previousChannelId === channelId) return;

	clearInterval(window.state.friendStatusUpdaterInterval);

	messageContainer.innerHTML = '';

	window.state.previousChannelId = channelId;
	
	try {
			
		const response = await fetch(`/api/channel/${channelId}`);
		const responseJson = await response.json();
		
		/**
		 * If channel does not exist
		 */
		const channel = responseJson.channel;
		if (!channel) {
			noChannelDisplay.render();
			return;
		}

		noChannelDisplay.hide();

		focusInput();

		document.title = `Messenger | ${channel.receiver.name}`;
		channelName.innerText = channel.receiver.name;
		chatUserProfileImage.style.backgroundImage = `url('${channel.receiver.profile_image || window.state.DEFAULT_PROFILE_IMAGE}')`;

		handleFriendStatus(channelId);
		window.state.friendStatusUpdaterInterval = setInterval(() => handleFriendStatus(channelId), 10000);

		window.state.messages = [];

		let addedNewMessageDivider = false;
		let firstNewMessageId;
	
		channel.messages.forEach(m => {
			if (!addedNewMessageDivider && !m.seen && m.sender_id !== window.state.user.id) {
				addedNewMessageDivider = true;
				firstNewMessageId = m.id;
				appendMessage(m, true);
				return;
			}
			appendMessage(m);
		});

		if  (!window.state.messages.length) {
			emptyMessageContainer.render();
		}

		if (!firstNewMessageId) {
			messageContainer.scroll(0, messageContainer.scrollHeight);
		}
		else {
			document.getElementById(`message-${firstNewMessageId}`).scrollIntoView({ behavior: 'smooth' });
		}

		if (messageContainer.scrollHeight === messageContainer.clientHeight) {
			markAsRead(channelId);
		}

		messageContainer.onscroll = () => {
			if (
				messageContainer.scrollHeight - Math.floor(messageContainer.scrollTop) === messageContainer.clientHeight &&
				window.state.messages.some(m => !m.seen && m.sender_id !== window.state.user.id)
			) {
				markAsRead(channelId);
				messageContainer.onscroll = null;
			}
		}

		startMessageSocket(channelId)
		
	} catch (e) {

		console.error(e);
		noChannelDisplay.render();
		
	}

}

async function handleFriendStatus(channelId) {
		
	try {
		
		const response = await fetch(`/api/channel/${channelId}`);
		const responseJson = await response.json();

		if (!responseJson.channel) return;
	
		channelStatus.innerHTML = (
			responseJson.channel.receiver.is_online ?
				'<div class="text-green-500">online</div>' :
				'<div class="text-gray-500">offline</div>'
		);

	} catch (e) {

		console.error(e);
		
	}

}

export default loadMessage;
