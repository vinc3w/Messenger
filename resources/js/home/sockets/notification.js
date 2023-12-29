import appendNotification from "../notification/load/append-notification";
import { notify } from "../../utils/notify";

const notificationCountContainers = [...document.getElementsByClassName('notification-count')];
const emptyNotificationList = document.getElementById('empty-notification-list');

function startNotificationSocket() {

	const channel = Echo.private(`private.notification.${window.state.user.id}`);

	channel.listen('.receive.notification', ({ notification }) => {

		emptyNotificationList.classList.add('hidden');

		appendNotification(notification);

		window.state.notificationCount++;

		notificationCountContainers.forEach(container => {
			container.innerText = window.state.notificationCount > 9 ? '9+' : window.state.notificationCount
		});
		
		notify();

	});

}

export default startNotificationSocket;
