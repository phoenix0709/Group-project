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
    const launchButton = document.getElementById('launch-button');
    const startsection = document.getElementById('start-button');
    const flagSection = document.getElementById('flag-section');
    const countdownDiv = document.createElement('p');
    countdownDiv.id = 'countdown-timer';
    launchButton.insertAdjacentElement('afterend', countdownDiv);

    let countdown = 10; // 10-second countdown
    countdownDiv.textContent = `Starting in ${countdown} seconds...`;

    const interval = setInterval(() => {
        countdown--;
        countdownDiv.textContent = `Starting in ${countdown} seconds...`;
        if (countdown <= 0) {
            clearInterval(interval);
            countdownDiv.textContent = '';

            // Display content based on challenge ID
            if (challengeId === 1) {
                window.location.href = './src/CTF_challenge/CTF1/login.html'; 
            } else if (challengeId === 2) {
                window.location.href = './src/CTF_challenge/CTF2/start.html'; 
            } else if (challengeId === 3) {
                window.location.href = './src/CTF_challenge/CTF3/login.html'; 
            } else if (challengeId === 4) {
                window.location.href = './CTF_challenge/CTF4/resource/login.html'; 
            } else if (challengeId === 5) {
                window.location.href = './CTF_challenge/CTF5/resource/login.html'; 
            } else {
                flagSection.style.display = 'block';
                launchButton.style.display = 'none';
                startsection.style.display = 'block';
            }
        }
    }, 1000);
}

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


function startChallenge() {
    const urlParams = new URLSearchParams(window.location.search);
    const challengeId = urlParams.get('id'); // take id from URL

    if (!challengeId) {
        alert('Challenge ID is missing!');
        return;
    }

    // navigate by id
    if (challengeId === '1') {
        window.location.href = './src/CTF_challenge/CTF1/login.html';
    } else if (challengeId === '2') {
        window.location.href = './src/CTF_challenge/CTF2/start.html';
    } else if (challengeId === 3) {
        window.location.href = './src/CTF_challenge/CTF3/login.html'; 
    } else if (challengeId === 4) {
        window.location.href = './CTF_challenge/CTF4/resource/login.html'; 
    } else if (challengeId === 5) {
        window.location.href = './CTF_challenge/CTF5/resource/login.html'; 
    } else {
        alert('Challenge not found.');
    }
}
