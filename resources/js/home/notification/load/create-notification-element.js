import { formatAMPM } from "../../../utils/time";

function createNotificationElement(notification) {

	const receivedAt = formatAMPM(new Date(notification.created_at));
	
	const { receiver } = notification;

	return /*html*/`
		<div id="notification-${notification.id}" class="w-full">
			<div class="flex">
				<div>
					<div style="background-image: url('${receiver.profile_image || window.state.DEFAULT_PROFILE_IMAGE}')" class="bg-no-repeat bg-center bg-cover min-w-[2.75rem] w-11 h-11 rounded-lg bg-gray-300"></div>
				</div>	
				<div class="w-full mx-2">
					<div class="">${notification.message}</div>
					<div class="text-xs opacity-70">${receivedAt}</div>
				</div>
				<div class="flex items-center flex-grow">
					<button id="delete-notification-${notification.id}-button" class="hover:text-gray-700 focus:text-gray-700 active:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full grid place-items-center h-[16px] transition ease-in-out duration-150" title="remove">
						<i class="fa-solid fa-circle-xmark"></i>
					</button>
				</div>
			</div>
			<hr class="w-full my-3"/>
		</div>
	`;

}

export default createNotificationElement;
