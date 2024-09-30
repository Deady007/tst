const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.querySelector('.container');

signUpButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm_password');
const passwordIcon = document.getElementById('password-icon');
const confirmPasswordIcon = document.getElementById('confirm-password-icon');

passwordInput.addEventListener('input', function() {
    const passwordValue = passwordInput.value;
    if (passwordValue.length < 8) {
        passwordIcon.innerHTML = '❌'; // Error icon
        passwordIcon.className = 'icon error';
        passwordIcon.style.display = 'inline'; 
    } else {
        passwordIcon.innerHTML = '✓'; // Success icon
        passwordIcon.className = 'icon success';
        passwordIcon.style.display = 'inline'; 
    }
});

confirmPasswordInput.addEventListener('input', function() {
    const confirmPasswordValue = confirmPasswordInput.value;
    if (confirmPasswordValue !== passwordInput.value) {
        confirmPasswordIcon.innerHTML = '❌'; // Error icon
        confirmPasswordIcon.className = 'icon error';
        confirmPasswordIcon.style.display = 'inline'; 
    } else {
        confirmPasswordIcon.innerHTML = '✓'; // Success icon
        confirmPasswordIcon.className = 'icon success';
        confirmPasswordIcon.style.display = 'inline'; 
    }
});
