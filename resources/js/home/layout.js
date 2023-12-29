import loadMessage from "./message/load/load-message";

const appContainer = document.getElementById('app-container');
const chatContainer = document.getElementById('chat-container');
const appTitle = document.getElementById('app-title');
const channelPage = document.getElementById('channel');
const notificationPage = document.getElementById('notification');
const profilePage = document.getElementById('profile');

function setLayout() {

	const params = window.location.pathname.split('/');
 	window.state.channelId = params[params.length - 1];

	channelPage.classList.add('hidden');
	notificationPage.classList.add('hidden');
	profilePage.classList.add('hidden');
	
	let [page, mobile] = window.history.state?.split('|') || [null, null];
 
	switch (page) {
		case 'notification':
			notificationPage.classList.remove('hidden');
			document.title = 'Messenger | Notification';
			appTitle.innerText = "Notifcation";
			break;
		case 'profile':
			profilePage.classList.remove('hidden');
			document.title = 'Messenger | Profile';
			appTitle.innerText = "Profile";
			break;
		case 'channel':
		default:
			channelPage.classList.remove('hidden');
			appTitle.innerText = "Channel";
			if (mobile === 'message') {
				document.title = `Messenger | ${window.state.channels?.[window.state.channelId]?.name}`;
			}
			else {
				document.title = 'Messenger | Channel';
			}
			break;
	}

	switch (mobile) {
		case 'message':
			chatContainer.classList.remove('max-md:hidden');
			appContainer.classList.add('max-md:hidden');
			break;
		case 'app':
		default:
			appContainer.classList.remove('max-md:hidden');
			chatContainer.classList.add('max-md:hidden');
	}

	// Run when URL changes
	loadMessage();
	
};

export default setLayout;
