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

function startChallenge(challengeId) {
    const launchButton = document.getElementById('launch-button');
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
                window.location.href = './CTF_challenge/CTF1/resource/login.html'; 
            } else if (challengeId === 2) {
                window.location.href = './CTF_challenge/CTF2/resource/start.html'; 
            } else {
                flagSection.style.display = 'block';
                launchButton.style.display = 'none';
            }
        }
    }, 1000);
}

function submitFlag() {
    const flagInput = document.getElementById('flag').value;
    const message = document.getElementById('flag-message');

    if (flagInput.trim() === '') {
        message.textContent = 'Please enter a flag.';
        message.style.color = 'red';
    } else {
        message.textContent = 'Flag submitted successfully!';
        message.style.color = 'green';
    }
}
