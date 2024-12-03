const getElement = (id) => document.getElementById(id);

const showError = (elementId, message) => {
    getElement(elementId).textContent = message;
};

const showSuccess = (elementId, message) => {
    getElement(elementId).textContent = message;
};

function toggleForm(showLogin) {
    getElement("login-form").style.display = showLogin ? "block" : "none";
    getElement("register-form").style.display = showLogin ? "none" : "block";
    if (showLogin) clearLoginError();
}

async function handleRequest(url, data, successCallback, errorCallback) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.error) {
            errorCallback(result.error);
        } else if (result.success) {
            successCallback(result.success);
        }
    } catch (error) {
        errorCallback('An error occurred.');
    }
}

function register(event) {
    event.preventDefault();
    
    const fullName = getElement('full-name').value;
    const username = getElement('new-username').value;
    const password = getElement('new-password').value;
    const confirmPassword = getElement('confirm-password').value;

    if (password !== confirmPassword) {
        showError('register-error', "Passwords do not match.");
        return;
    }

    const userData = { fullName, username, password };

    handleRequest('register.php', userData, 
        (successMessage) => {
            showSuccess('registration-success', successMessage);
            toggleForm(true); 
        },
        (errorMessage) => showError('register-error', errorMessage)
    );
}

function login(event) {
    event.preventDefault();

    const username = getElement('username').value;
    const password = getElement('password').value;

    const loginData = { username, password };

    handleRequest('login.php', loginData, 
        () => window.location.href = 'Challenge.html', 
        (errorMessage) => showError('login-error', errorMessage)
    );
}

function clearLoginError() {
    getElement('login-error').textContent = '';
}

function showRegisterForm() {
    toggleForm(false); 
}

function showLoginForm() {
    toggleForm(true);  
}
