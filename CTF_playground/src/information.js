
document.getElementById("editBtn").addEventListener("click", function() {
    document.getElementById("editForm").classList.toggle("hidden");
});

document.getElementById("changePasswordBtn").addEventListener("click", function() {
    document.getElementById("changePasswordPopup").classList.toggle("hidden");
});

document.getElementById("saveBtn").addEventListener("click", function() {
    var fullName = document.getElementById("fullNameInput").value;
    var username = document.getElementById("usernameInput").value;
    var phone = document.getElementById("phoneInput").value;
    var email = document.getElementById("emailInput").value;
    var dob = document.getElementById("dobInput").value;
    var gender = document.getElementById("genderInput").value;

    document.getElementById("fullName").textContent = fullName;
    document.getElementById("username").textContent = username;
    document.getElementById("phone").textContent = phone;
    document.getElementById("email").textContent = email;
    document.getElementById("dob").textContent = new Date(dob).toLocaleDateString();
    document.getElementById("gender").textContent = gender;

    document.getElementById("editForm").classList.add("hidden");
});

document.getElementById("submitChangePasswordBtn").addEventListener("click", function() {
    var oldPassword = document.getElementById("oldPasswordInput").value;
    var newPassword = document.getElementById("newPasswordInput").value;
    var confirmPassword = document.getElementById("confirmPasswordInput").value;

    if (newPassword === confirmPassword) {
        alert("Password changed successfully!");
        document.getElementById("changePasswordPopup").classList.add("hidden");
    } else {
        alert("New passwords do not match!");
    }
});

document.getElementById("closeChangePasswordBtn").addEventListener("click", function() {
    document.getElementById("changePasswordPopup").classList.add("hidden");
});

document.getElementById("BackBtn").addEventListener("click", function() {
    window.location.href = "Challenge.html";
});

document.getElementById("logoutBtn").addEventListener("click", function() {
    window.location.href = "Login_or_register.html";
});