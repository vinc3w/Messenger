const messageInput = document.getElementById('message-input');


/**
 * reset and reassign message input value to its original value
 * reason: move cursor to the end of input value
 */
function focusInput() {

	messageInput.focus();
	const messageValue = messageInput.value;
	messageInput.value = '';
	messageInput.value = messageValue;

}

export default focusInput;

