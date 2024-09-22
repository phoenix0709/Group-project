function filterChallenges(difficulty) {
    // Get all the challenge cards
    const challenges = document.querySelectorAll('.challenge-card');

    challenges.forEach(card => {
        // Show all if 'all' is selected
        if (difficulty === 'all') {
            card.classList.remove('hidden');
        } else {
            // Show/Hide based on difficulty
            if (card.classList.contains(difficulty)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        }
    });
}
