import createNotificationElement from "./create-notification-element";

const notificationList = document.getElementById('notification-list');
const notificationCountContainers = [...document.getElementsByClassName('notification-count')];
const emptyNotificationList = document.getElementById('empty-notification-list');

function appendNotification(notification) {

	notificationList.insertAdjacentHTML( 'beforeend', createNotificationElement(notification));

	const notificationElement = document.getElementById(`notification-${notification.id}`);
	
	document.getElementById(`delete-notification-${notification.id}-button`).onclick = async () => {
		
		try {

			await fetch(`/api/notification/${notification.id}`, {
				headers: {
					"Content-Type": "application/json",
					"Accept": "application/json, text-plain, */*",
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-Token": window.state._token
				},
				method: 'delete',
			});

			notificationElement.remove();

			if (!--window.state.notificationCount) {
				emptyNotificationList.classList.remove('hidden');
			}

			notificationCountContainers.forEach(container => {
				container.innerText = (window.state.notificationCount > 9 ? '9+' : window.state.notificationCount) || '';
			});
			
		} catch (e) {
			
			console.error(e);

		}

	}

}

export default appendNotification;
