import { formatAMPM } from "../../../utils/time";
import { HTMLSafeString } from "../../../utils/safe";

const channelName = document.getElementById('channel-name');

function createMessageElement(message, startingNewMessage) {

	const createdAt = formatAMPM(new Date(message.created_at));
	const replyMessage = document.getElementById(`message-${message.reply_to}`);
	const isAuthor = message.sender_id === window.state.user.id;

	const startingNewMessageElement = startingNewMessage ?
		/*html*/`
			<div class="flex items-center justify-center mb-4 mt-2">
				<div class="bg-gray-200 px-2 py-1 rounded">New Messages</div>
			</div>
		` :
		''

	const repliedMessageElement = message.reply_to ? 
		/*html*/`
			<div class="${isAuthor ? 'bg-green-300' : 'bg-orange-300'} w-full rounded-lg px-2 py-1 mb-1">
				${
					message.reply_to && !replyMessage ? 
						'<div class="opacity-50">Message deleted</div>' :
						/*html*/`
							<div name="name" class="text-sm opacity-70">${replyMessage.getAttribute('is-author') === 'true' ? window.state.user.name : channelName.innerText}</div>
							<div name="reply-message" class="max-h-24 overflow-auto">${replyMessage.querySelector('div[name=message]').innerText}</div>
						`
				}
			</div>
		` :
		'';

	return isAuthor ? /*html*/`
		${ startingNewMessageElement }
		<div id="message-${message.id}" is-author="true" class="flex justify-end mt-1 rounded-lg">
			<div class="group relative bg-green-200 w-fit p-2 rounded-lg flex flex-col items-end">
				${ repliedMessageElement }
				<div name="message">${HTMLSafeString(message.message)}</div>
				<div class="inline-block text-xs opacity-70 mt-1">${createdAt}</div>
				<div class="bg-green-200 rounded-xl absolute top-full right-0 hidden z-40 group-hover:flex">
					<button id="reply-message-${message.id}-button" class="p-1 rounded-full hover:bg-green-300  active:bg-green-400 transition-colors" title="reply">
						<i class="fa-solid fa-reply block h-5 w-5"></i>
					</button>
					<button id="delete-message-${message.id}-button" class="p-1 rounded-full hover:bg-green-300 active:bg-green-400 transition-colors" title="delete">
						<i class="fa-solid fa-trash block h-5 w-5 text-red-500"></i>
					</button>
				</div>
			</div>
		</div>
	` :
	/*html*/`
		${ startingNewMessageElement }
		<div id="message-${message.id}" is-author="false" class="mt-1 rounded-lg">
			<div class="group relative bg-orange-200 w-fit p-2 rounded-lg flex flex-col">
				${ repliedMessageElement }
				<div name="message">${HTMLSafeString(message.message)}</div>
				<div class="inline-block opacity-70 mt-1 text-xs">${createdAt}</div>
				<div class="bg-orange-200 rounded-xl absolute top-full right-0 hidden z-40 group-hover:flex">
					<button id="reply-message-${message.id}-button" class="p-1 rounded-full hover:bg-orange-300  active:bg-orange-400 transition-colors" title="reply">
						<i class="fa-solid fa-reply block h-5 w-5"></i>
					</button>
				</div>
			</div>
		</div>
	`;

}

export default createMessageElement;
