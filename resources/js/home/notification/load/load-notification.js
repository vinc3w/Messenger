import appendNotification from "./append-notification";

const notificationCountContainers = [...document.getElementsByClassName('notification-count')];
const emptyNotificationList = document.getElementById('empty-notification-list');

async function loadNotification() {

	try {

		const response = await fetch('/api/notification');
		const responseJson = await response.json();

		responseJson.notifications.forEach(n => appendNotification(n));

		notificationCountContainers.forEach(
			container => container.innerText = responseJson.notifications.length || ''
		);

		window.state.notificationCount = responseJson.notifications.length;

		if (!window.state.notificationCount) {
			emptyNotificationList.classList.remove('hidden');
		}
		
	} catch (e) {

		console.error(e);
		
	}

}

loadNotification();
