document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.tab-button[data-category="made-for-you"]').addEventListener('click', function() {
        fetch('explore_get_user_data.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Error fetching user data: ", data.error);
                    logError("Error fetching user data: " + data.error);
                    return;
                }
                const userTags = data.tags;

                const items = document.getElementsByClassName('game-item');

                for (let i = 0; i < items.length; i++) {
                    const gameTags = items[i].querySelectorAll('.tag');
                    let display = true;

                    gameTags.forEach(tag => {
                        if (tag.classList.contains('negative') && userTags.includes(tag.innerText)) {
                            display = false;
                        }
                    });

                    items[i].style.display = display ? 'flex' : 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                logError('Error fetching user data: ' + error);
            });
    });
});

function logError(errorMessage) {
    fetch('log_errors.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'error_message=' + encodeURIComponent(errorMessage)
    });
}
