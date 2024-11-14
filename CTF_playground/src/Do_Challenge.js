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
