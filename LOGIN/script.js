document.addEventListener('DOMContentLoaded', () => {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.querySelector('.container');

    signUpButton.addEventListener('click', () => {
        container.classList.add('right-panel-active');
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
    });

    // Add event listener specifically to the sign-up form
    const signUpForm = document.querySelector('.sign-up-container form');
    if (signUpForm) {
        signUpForm.addEventListener('submit', function(event) {
            const password = this.querySelector('input[type="password"]:nth-of-type(1)').value;
            const confirmPassword = this.querySelector('input[type="password"]:nth-of-type(2)').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                event.preventDefault(); // Prevent the form from being submitted
            }
        });
    } else {
        console.error('Sign-up form not found!');
    }
});
