import startChannelSocket from './channel';
import startNotificationSocket from './notification';

function startSockets() {

	startChannelSocket();
	startNotificationSocket();

}

export default startSockets;
