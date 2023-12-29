import keepUserStatusOnline from "./keep-online";
import setLayout from "./layout";
import startSockets from "./sockets/start";

import './message/send/send-message';
import './profile/profile';
import './friend/add-friend';

import './channel/load/load-channel';
import './notification/load/load-notification';

window.state._token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
window.state.DEFAULT_PROFILE_IMAGE = '/assets/images/default-profile-image.jpg';

window.addEventListener('load', () => {
	window.dispatchEvent(new Event('popstate'));
});

window.addEventListener('popstate', setLayout);

keepUserStatusOnline();
startSockets();
