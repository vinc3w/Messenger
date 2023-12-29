import appendChannel from '../channel/load/append-channel';
import { notify } from '../../utils/notify';

const searchChannel = document.getElementById('search-channel-form');
const newMessageCountContainers = [...document.getElementsByClassName('new-message-count')];
const emptyChannelList = document.getElementById('empty-channel-list');

function startChannelSocket() {

	const channel = Echo.private(`private.channel.${window.state.user.id}`);

	channel.listen('.added.as.friend', ({ friend }) => {

		appendChannel(friend, searchChannel.value?.trim());

		window.channels[friend.channel.id] = friend;
		window.channels[friend.channel.id].channel.newMessageCount = 0;

		emptyChannelList.classList.add('hidden');

	});

	channel.listen('.removed.as.friend', ({ channel }) => {

		const channelElement = document.getElementById(`channel-${channel.id}`);
		
		channelElement.remove();
		delete window.state.channels[channel.id];

		window.state.totalNewMessageCount -= channel.newMessageCount;

		newMessageCountContainers.forEach(container => {
			container.innerText = (window.state.totalNewMessageCount > 9 ? '9+' : window.state.totalNewMessageCount || '');
		})

		if (!Object.entries(window.state.channels).length) {
			emptyChannelList.classList.remove('hidden');
		}

		if (window.location.pathname === `/app/channel/${channel.id}`) {
			window.history.replaceState(window.history.state?.split('|')[0] + '|app', null, '/app');
			window.dispatchEvent(new Event('popstate'));
		}

	});

	channel.listen('.receive.message', ({ sender, message }) => {

		const lastMessageContainer = document.getElementById(`channel-${message.channel_id}-last-message`);
		const channelNewMessageCountContainer = document.getElementById(`channel-${message.channel_id}-new-message-count`);

		lastMessageContainer.innerText = (message.sender_id === window.state.user.id ? `${window.state.user.name}: ` : `${sender.name}: `) + message.message;
		channelNewMessageCountContainer.innerText = ++window.state.channels[message.channel_id].channel.newMessageCount > 9 ?
			'9+' :
			window.state.channels[message.channel_id].channel.newMessageCount;

		window.state.totalNewMessageCount++;

		newMessageCountContainers.forEach(container => {
			container.innerText = window.state.totalNewMessageCount > 9 ? '9+' : window.state.totalNewMessageCount;
		});
		
		if (window.state.channelId != message.channel_id) {
			notify();
		}

	});

}

export default startChannelSocket;
