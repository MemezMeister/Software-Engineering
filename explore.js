document.addEventListener("DOMContentLoaded", function() {
    console.log("DOMContentLoaded event fired in explore.js"); 

    fetch('fetch_games.php')
        .then(response => {
            console.log("Response received from fetch_games.php"); 
            return response.json();
        })
        .then(data => {
            console.log('Game Data:', data); 
            if (data.error) {
                console.error("Error fetching game data: ", data.error);
                logError("Error fetching game data: " + data.error);
                return;
            }
            
            const gameList = document.getElementById('game-list');
            gameList.innerHTML = '';

            data.forEach(game => {
                const gameItem = document.createElement('div');
                gameItem.className = 'game-item';
                gameItem.setAttribute('data-category', game.accessibility_category);

                const avgRating = game.avg_rating ? Number(game.avg_rating).toFixed(1) : '0.0';
                const positiveTags = game.positive_tags ? game.positive_tags.split(', ').map(tag => `<div class="tag positive" data-message="Safe for ${tag}">${tag}</div>`).join('') : '';
                const negativeTags = game.negative_tags ? game.negative_tags.split(', ').map(tag => `<div class="tag negative" data-message="Not Safe for ${tag}">${tag}</div>`).join('') : '';

                const stars = [...Array(5)].map((_, i) => i < Math.round(avgRating) ? '★' : '☆').join('');

                gameItem.innerHTML = `
                    <img src="${game.game_image}" alt="${game.game_name}">
                    <h2>${game.game_name}</h2>
                    <div class="tags">${positiveTags} ${negativeTags}</div>
                    <div class="rating">${stars}</div>
                    <a href="game.html?game_id=${game.game_id}">View Details</a>
                `;

                gameList.appendChild(gameItem);
            });
        })
        .catch(error => {
            console.error('Error fetching game data:', error);
            logError('Error fetching game data: ' + error);
        });
});

function showCategory(category) {
    const items = document.getElementsByClassName('game-item');
    for (let i = 0; i < items.length; i++) {
        if (items[i].getAttribute('data-category').includes(category) || category === 'all') {
            items[i].style.display = 'flex';
        } else {
            items[i].style.display = 'none';
        }
    }
}

function logError(errorMessage) {
    fetch('log_errors.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'error_message=' + encodeURIComponent(errorMessage)
    });
}
