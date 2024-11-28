
    function showRegisterForm() {
        document.getElementById("login-form").style.display = "none";
        document.getElementById("register-form").style.display = "block";
    }

    function showLoginForm() {
        document.getElementById("register-form").style.display = "none";
        document.getElementById("login-form").style.display = "block";
        clearLoginError();
    }

    async function register(event) {
        event.preventDefault();
        const fullName = document.getElementById('full-name').value;
        const username = document.getElementById('new-username').value;
        const password = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (password !== confirmPassword) {
            document.getElementById('register-error').textContent = "Passwords do not match.";
            return;
        }

        const userData = {
            fullName,
            username,
            password
        };

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const result = await response.json();

            if (result.error) {
                document.getElementById('register-error').textContent = result.error;
            } else if (result.success) {
                document.getElementById('registration-success').textContent = result.success;
                showLoginForm();
            }
        } catch (error) {
            document.getElementById('register-error').textContent = 'Error registering user.';
        }
    }

    async function login(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        const loginData = {
            username,
            password
        };

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(loginData)
            });

            const result = await response.json();

            if (result.error) {
                document.getElementById('login-error').textContent = result.error;
            } else if (result.success) {
                window.location.href = 'Challenge.html';  // Redirect to the challenge page
            }
        } catch (error) {
            document.getElementById('login-error').textContent = 'Error logging in.';
        }
    }

    // Function to clear login error
    function clearLoginError() {
        document.getElementById('login-error').textContent = '';
    }
