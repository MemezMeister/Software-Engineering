document.getElementById('game-request-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const gameName = document.getElementById('game-name').value;
    const gameLink = document.getElementById('game-link').value;
    const gameDescription = document.getElementById('game-description').value;

    fetch('game_request.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `game_name=${encodeURIComponent(gameName)}&game_link=${encodeURIComponent(gameLink)}&game_description=${encodeURIComponent(gameDescription)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Game request submitted successfully!');
        } else {
            alert('Failed to submit game request. Please try again.');
        }
    })
    .catch(error => console.error('Error:', error));
});
