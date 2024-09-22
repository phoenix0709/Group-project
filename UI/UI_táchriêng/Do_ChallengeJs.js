// Time logic
const startTime = new Date().getTime() + 3600000; // 1 hour from now

function updateTimer() {
    const now = new Date().getTime();
    const distance = startTime - now;

    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timer").innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    if (distance < 0) {
        clearInterval(timerInterval);
        document.getElementById("timer").innerHTML = "EXPIRED";
    }
}

const timerInterval = setInterval(updateTimer, 1000);

// Flag submission logic
function submitFlag() {
    const correctFlag = "FLAG{correct_flag}";
    const userFlag = document.getElementById("flag").value;
    const messageElement = document.getElementById("flag-message");

    if (userFlag === correctFlag) {
        messageElement.textContent = "Correct flag! You earned 100 points!";
        messageElement.style.color = "green";
    } else {
        messageElement.textContent = "Incorrect flag. Try again!";
        messageElement.style.color = "red";
    }
}
