const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const signupBtn = document.getElementById('signup');
const passwordInput = document.getElementById('pass');
const confirmPasswordInput = document.getElementById('confirm_pass');
const passwordAlert = document.getElementById('wrong_pass_alert');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

function validatePassword() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword) {
        passwordAlert.style.color = 'green';
        passwordAlert.textContent = '🗹 Password Matched';
        signupBtn.disabled = false;
        signupBtn.style.opacity = 1;
    } else {
        passwordAlert.style.color = 'red';
        passwordAlert.textContent = '☒ Passwords do not match';
        signupBtn.disabled = true;
        signupBtn.style.opacity = 0.4;
    }
}

function handleSignup(event) {
    event.preventDefault();
    const name = document.querySelector('input[placeholder="Name"]').value;
    const email = document.querySelector('input[placeholder="Email"]').value;
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (name && email && password && confirmPassword) {
        if (password === confirmPassword) {
            alert("Your registration is successful!");
            // Here you would typically send the data to your server
        } else {
            alert("Passwords do not match. Please try again.");
        }
    } else {
        alert("Please fill all the fields");
    }
}

passwordInput.addEventListener('input', validatePassword);
confirmPasswordInput.addEventListener('input', validatePassword);
signupBtn.addEventListener('click', handleSignup);