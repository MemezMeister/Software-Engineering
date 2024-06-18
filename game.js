document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const gameId = urlParams.get('game_id');

    fetch(`game.php?game_id=${gameId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the data for debugging
            if (data.error) {
                alert(data.error);
                return;
            }

            const { is_logged_in, user_image, username, game, reviews } = data;

            // Populate game details
            document.getElementById('game-name').innerText = game.game_name;
            document.getElementById('game-image').src = game.game_image;
            document.getElementById('game-image').alt = game.game_name;

            // Populate links
            const links = document.getElementById('links');
            if (game.steam_link) {
                links.innerHTML += `<a href="${game.steam_link}"><img src="steam_icon.png" alt="Steam"></a>`;
            }
            if (game.epicgames_link) {
                links.innerHTML += `<a href="${game.epicgames_link}"><img src="epicgames_icon.png" alt="Epic Games"></a>`;
            }
            if (game.other_link) {
                links.innerHTML += `<a href="${game.other_link}"><img src="other_icon.png" alt="Other"></a>`;
            }

            // Populate average rating
            const avgRating = document.getElementById('avg-rating');
            const rating = parseFloat(game.avg_rating);
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    avgRating.innerHTML += '★';
                } else if (i - rating < 1) {
                    avgRating.innerHTML += '<span class="star half">★</span>';
                } else {
                    avgRating.innerHTML += '☆';
                }
            }

            // Populate tags
            const tags = document.getElementById('tags');
            if (game.positive_tags) {
                game.positive_tags.split(', ').forEach(tag => {
                    tags.innerHTML += `<div class="tag positive" data-message="Safe for ${tag}">${tag}</div>`;
                });
            }
            if (game.negative_tags) {
                game.negative_tags.split(', ').forEach(tag => {
                    tags.innerHTML += `<div class="tag negative" data-message="Not Safe for ${tag}">${tag}</div>`;
                });
            }

            // Populate reviews
            const reviewsList = document.getElementById('reviews-list');
            if (reviews.length > 0) {
                reviews.forEach(review => {
                    const reviewItem = document.createElement('div');
                    reviewItem.classList.add('review');
                    reviewItem.innerHTML = `
                        <div class="review-header">
                            <h3>${review.username}</h3>
                            <div class="star-rating read-only">
                                ${[...Array(5)].map((_, i) => (i < review.rating ? '★' : '☆')).join('')}
                            </div>
                        </div>
                        <p>${review.review_text}</p>
                    `;
                    reviewsList.appendChild(reviewItem);
                });
            } else {
                reviewsList.innerHTML = '<p>No reviews yet.</p>';
            }

            // Show review form if logged in
            if (is_logged_in) {
                document.getElementById('game_id').value = gameId;
                document.getElementById('user_id').value = data.user_id;
                document.getElementById('username').innerText = username;
                document.getElementById('write-review').style.display = 'block';
            } else {
                const loginButton = document.createElement('a');
                loginButton.classList.add('btn');
                loginButton.href = 'login_register.php';
                loginButton.innerText = 'Log in to write a review';
                document.getElementById('reviews-list').appendChild(loginButton);
            }

            // User icon
            const userLink = document.getElementById('user-link');
            if (is_logged_in) {
                userLink.innerHTML = `<img src="${user_image}" alt="User Icon">`;
                userLink.href = 'account.php';
            } else {
                userLink.innerHTML = 'Login';
                userLink.href = 'login_register.php';
                userLink.className = 'login-btn';
            }
        })
        .catch(error => console.error('Error fetching game data:', error));

    // Write review button event listener
    document.getElementById('write-review-button').addEventListener('click', function() {
        document.getElementById('write-review-form').style.display = 'block';
    });
});
