const profileImageImg = document.getElementById('profile-image-view');
const sideBarProfileImageImg = document.getElementById('side-bar-profile-image');
const uploadProfileImageInput = document.getElementById('upload-profile-image-input');
const uploadProfileImageform = document.getElementById('upload-profile-image-form');
const removeProfileImageForm = document.getElementById('remove-profile-image-form');
const updateProfileInformationForm = document.getElementById('update-profile-information-form');
const updatePasswordForm = document.getElementById('update-password-form');

uploadProfileImageInput.addEventListener('change', async e => {

	const fd = new FormData(uploadProfileImageform);

	try {

		const response = await fetch(`/api/profile/update-profile-image/${window.state.user.id}`, {
			headers: {
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": window.state._token
			},
			method: 'post',
			body: fd
		});
		const responseJson = await response.json();

		profileImageImg.style.backgroundImage = `url('${responseJson.imagePath}')`;
		sideBarProfileImageImg.style.backgroundImage = `url('${responseJson.imagePath}')`;
		
	} catch (e) {
		
		console.error(e)

	}

});

removeProfileImageForm.addEventListener('submit', async e => {

	e.preventDefault();

	try {

		const r = await fetch(`/api/profile/remove-profile-image/${window.state.user.id}`, {
			headers: {
				'Content-Type': 'application/json',
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-Token": _token
			},
			method: 'post',
		});
		console.log(await r.json())

		profileImageImg.style.backgroundImage = `url('${window.state.DEFAULT_PROFILE_IMAGE}')`;
		sideBarProfileImageImg.style.backgroundImage = `url('${window.state.DEFAULT_PROFILE_IMAGE}')`;
		
	} catch (e) {
		
		console.error(e)

	}

});

updateProfileInformationForm?.addEventListener('submit', async e => {
	
	const nameError = document.getElementById('update-profile-information-form-name-error');
	const emailError = document.getElementById('update-profile-information-form-email-error');
	const verifyEmail = document.getElementById('update-profile-information-form-verify-email');
	const saveIndicator = document.getElementById('update-profile-information-form-save-indicator');

	e.preventDefault();

	const formEntries = Object.fromEntries(new FormData(updateProfileInformationForm));
	const { _method } = formEntries;

	try {

		const response = await fetch(`/api/profile/update-information/${window.state.user.id}`, {
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json, text-plain, */*",
				"X-Requested-With": "XMLHttpRequest",
			},
			method: _method,
			body: JSON.stringify(formEntries)
		});
		
		const jsonResponse = await response.json();
	
		if (jsonResponse.errors) {
			// errors of each input is given in array form
			const { name, email } = jsonResponse.errors;
			nameError.innerHTML = '';
			emailError.innerHTML = '';
			name?.forEach(i => nameError.innerHTML += `<div>${i}</div>`);
			email?.forEach(i => emailError.innerHTML += `<div>${i}</div>`);
			return;
		}
		
		if (window.state.user.email !== formEntries.email) {
			verifyEmail.classList.remove('hidden');
		}
	
		if (jsonResponse.status === 'profile-updated') {
			saveIndicator.classList.remove('hidden');
			setTimeout(() => {
				saveIndicator.classList.add('hidden');
			}, 2000);
		}

	} catch (e) {

		emailError.innerHTML = e.message;
		
	}

});

updatePasswordForm?.addEventListener('submit', async e => {

	const currentPasswordError = document.getElementById('update-password-form-current-password-error');
	const passwordError = document.getElementById('update-password-form-password-error');
	const passwordConfirmationError = document.getElementById('update-password-form-password-confirmation-error');
	const saveIndicator = document.getElementById('update-password-form-save-indicator');

	e.preventDefault();

	const formEntries = Object.fromEntries(new FormData(updatePasswordForm));
	const { _method } = formEntries;

	try {

		const response = await fetch('/api/password', {
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json, text-plain, */*",
				"X-Requested-With": "XMLHttpRequest",
			},
			method: _method,
			body: JSON.stringify(formEntries)
		});
		
		const jsonResponse = await response.json();
	
		if (jsonResponse.errors) {
			const { current_password, password, password_confirmation } = jsonResponse.errors;
			currentPasswordError.innerHTML = '';
			passwordError.innerHTML = '';
			passwordConfirmationError.innerHTML = '';
			current_password?.forEach(i => currentPasswordError.innerHTML += `<div>${i}</div>`);
			password?.forEach(i => passwordError.innerHTML += `<div>${i}</div>`);
			password_confirmation?.forEach(i => passwordConfirmationError.innerHTML += `<div>${i}</div>`);
		}
	
		if (jsonResponse.status === 'password-updated') {
			saveIndicator.classList.remove('hidden');
			setTimeout(() => {
				saveIndicator.classList.add('hidden');
			}, 2000);
		}

	}
	catch(e) {

		passwordConfirmationError.innerHTML = e.message;

	}

});
