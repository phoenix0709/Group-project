document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const challengeId = urlParams.get('id');

    if (challengeId) {
        fetchChallengeDetails(challengeId);
    } else {
        alert('No challenge ID specified.');
        document.getElementById('challenge-info').innerHTML = '<p>No challenge selected.</p>';
    }
});

function fetchChallengeDetails(id) {
    fetch(`get_challenge.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                displayError(data.error);
            } else {
                displayChallenge(data);
            }
        })
        .catch(error => {
            console.error('Error fetching challenge details:', error);
            displayError('Failed to fetch challenge details. Please try again later.');
        });
}

function displayChallenge(challenge) {
    const challengeInfoDiv = document.getElementById('challenge-info');
    challengeInfoDiv.innerHTML = `
        <h2>${challenge.name}</h2>
        <p><strong>Description:</strong> ${challenge.description}</p>
        <p><strong>Difficulty:</strong> ${challenge.difficulty}</p>
    `;
}

function displayError(message) {
    const challengeInfoDiv = document.getElementById('challenge-info');
    challengeInfoDiv.innerHTML = `<p class="error">${message}</p>`;
}

function launchChallenge(challengeId) {
    if (!challengeId) {
        alert('Challenge ID is missing!');
        return;
    }

    let url;

    // Xác định URL dựa trên challengeId
    if (challengeId === '1') {
        url = './src/CTF_challenge/CTF1/login.html';
    } else if (challengeId === '2') {
        url = './src/CTF_challenge/CTF2/start.html';
    } else if (challengeId === '3') {
        url = './src/CTF_challenge/CTF3/login.html';
    } else if (challengeId === '4') {
        url = './CTF_challenge/CTF4/resource/login.html';
    } else if (challengeId === '5') {
        url = './CTF_challenge/CTF5/resource/login.html';
    } else {
        alert('Challenge not found.');
        return;
    }

    // Mở URL trong một tab mới
    window.open(url, '_blank');
}

// Lắng nghe sự kiện DOMContentLoaded và gắn sự kiện cho nút launch
document.addEventListener('DOMContentLoaded', () => {
    const launchButton = document.getElementById('launch-button');
    const urlParams = new URLSearchParams(window.location.search);
    const challengeId = urlParams.get('id');

    if (launchButton) {
        launchButton.addEventListener('click', () => launchChallenge(challengeId));
    }
});


function submitFlag() {
    const flagInput = document.getElementById('flag').value;
    const message = document.getElementById('flag-message');
    
    const urlParams = new URLSearchParams(window.location.search);
    const challengeId = urlParams.get('id');

    if (flagInput.trim() === '') {
        message.textContent = 'Please enter a flag.';
        message.style.color = 'red';
    } else {
        fetch('check_flag.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${encodeURIComponent(challengeId)}&flag=${encodeURIComponent(flagInput)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                message.textContent = data.message;
                message.style.color = 'green';

                setTimeout(() => {
                    window.location.href = 'challenge.html';
                }, 2000); 
            } else {
                message.textContent = data.message;
                message.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error checking flag:', error);
            message.textContent = 'An error occurred while checking the flag.';
            message.style.color = 'red';
        });
    }
}

