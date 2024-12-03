document.addEventListener("DOMContentLoaded", function() {
    const fullNameElem = document.getElementById("fullName");
    const usernameElem = document.getElementById("username");
    const phoneElem = document.getElementById("phone");
    const emailElem = document.getElementById("email");
    const dobElem = document.getElementById("dob");
    const genderElem = document.getElementById("gender");
    const fullNameInput = document.getElementById("fullNameInput");
    const usernameInput = document.getElementById("usernameInput");
    const phoneInput = document.getElementById("phoneInput");
    const emailInput = document.getElementById("emailInput");
    const dobInput = document.getElementById("dobInput");
    const genderInput = document.getElementById("genderInput");
    const editForm = document.getElementById("editForm");
    const changePasswordPopup = document.getElementById("changePasswordPopup");

    // Fetch user data
    fetchUserData();

    function fetchUserData() {
        fetch('information.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    fullNameElem.textContent = data.full_name;
                    usernameElem.textContent = data.username;
                    phoneElem.textContent = data.phone;
                    emailElem.textContent = data.email;
                    dobElem.textContent = new Date(data.dob).toLocaleDateString();
                    genderElem.textContent = data.gender;

                    fullNameInput.value = data.full_name;
                    usernameInput.value = data.username;
                    phoneInput.value = data.phone;
                    emailInput.value = data.email;
                    dobInput.value = data.dob;
                    genderInput.value = data.gender;
                }
            })
            .catch(error => {
                alert('Error fetching user data: ' + error);
            });
    }

    // Event listeners for UI interactions
    document.addEventListener('click', function(e) {
        if (e.target.id === "editBtn") {
            editForm.classList.toggle("hidden");
        }

        if (e.target.id === "changePasswordBtn") {
            changePasswordPopup.classList.toggle("hidden");
        }

        if (e.target.id === "saveBtn") {
            const fullName = fullNameInput.value;
            const username = usernameInput.value;
            const phone = phoneInput.value;
            const email = emailInput.value;
            const dob = dobInput.value;
            const gender = genderInput.value;

            fullNameElem.textContent = fullName;
            usernameElem.textContent = username;
            phoneElem.textContent = phone;
            emailElem.textContent = email;
            dobElem.textContent = new Date(dob).toLocaleDateString();
            genderElem.textContent = gender;

            editForm.classList.add("hidden");
        }

        if (e.target.id === "submitChangePasswordBtn") {
            const oldPassword = document.getElementById("oldPasswordInput").value;
            const newPassword = document.getElementById("newPasswordInput").value;
            const confirmPassword = document.getElementById("confirmPasswordInput").value;

            if (newPassword === confirmPassword) {
                alert("Password changed successfully!");
                changePasswordPopup.classList.add("hidden");
            } else {
                alert("New passwords do not match!");
            }
        }

        if (e.target.id === "closeChangePasswordBtn") {
            changePasswordPopup.classList.add("hidden");
        }

        if (e.target.id === "BackBtn") {
            window.location.href = "Challenge.html";
        }

        if (e.target.id === "logoutBtn") {
            window.location.href = "Login_or_register.html";
        }
    });
});
