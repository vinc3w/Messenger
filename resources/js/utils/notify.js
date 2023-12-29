const notifyAudio = new Audio('/assets/audio/notify.wav');

export function notify()  {
	
	try {
		
		notifyAudio.play();

	} catch (e) {
		
		console.error(e);

	}

}
