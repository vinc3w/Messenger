function createChannelElement(friend, matchedQuery) {

	return /*html*/`
		<div id="channel-${friend.channel.id}" class="group flex items-center mb-2 w-full rounded-md hover:bg-gray-100 active:bg-gray-200 transition-colors">
			<button class="w-full p-2 pr-0 flex gap-2"
				onclick="
					if (window.location.pathname === \`/app/channel/${friend.channel.id}\` &&
						window.history.state?.split('|')[1] === 'message') return;
					window.history.pushState(window.history.state?.split('|')[0] + '|message', null, \`/app/channel/${friend.channel.id}\`);
					window.dispatchEvent(new Event('popstate'));
				">
				<div style="background-image: url('${friend.profile_image || window.state.DEFAULT_PROFILE_IMAGE}')" class="bg-no-repeat bg-center bg-cover min-w-[2.75rem] w-11 h-11 rounded-lg bg-gray-300"></div>
				<div class="w-full flex items-center">
					<div class="w-full text-left max-w-[169px]">
						<div class="font-semibold  text-ellipsis whitespace-nowrap overflow-hidden">
							${
								matchedQuery ? 
									friend.name.replace(matchedQuery, /*html*/`<span class="bg-blue-200">${matchedQuery}</span>`) :
									friend.name
							}
						</div>
						<div id="channel-${friend.channel.id}-last-message" class="last-message text-sm opacity-70 text-ellipsis whitespace-nowrap overflow-hidden" title="${friend.channel.lastMessage?.message || 'empty chat'}">
							${
								friend.channel.lastMessage ?
									(friend.channel.lastMessage.sender_id === window.state.user.id ? `${window.state.user.name}: ` : `${friend.name}: `)
									+ friend.channel.lastMessage.message :
									'empty chat'
							}
						</div>
					</div>
					<div id="channel-${friend.channel.id}-new-message-count" class="flex justify-center items-center bg-red-500 aspect-square rounded-lg text-white text-xs ml-2 w-[22px] empty:bg-transparent">${(friend.channel.newMessageCount > 9 ? '9+' : friend.channel.newMessageCount) || ''}</div>
				</div>
			</button>
			<div class="group-hover:visible invisible h-full flex justify-center items-center pl-1 pr-2">
				<button id="unfriend-${friend.channel.id}-button" class="transition roudned-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full ease-in-out duration-150" title="unfriend">
					<i class="fa-solid fa-circle-xmark"></i>
				</button>
			</div>
		</div>
	`;

}

export default createChannelElement;
