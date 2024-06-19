document.addEventListener("DOMContentLoaded", function() {
    console.log("DOMContentLoaded event fired in explore_account.js"); // Debugging line

    // Fetch user data to update profile picture
    fetch('explore_get_user_data.php')
        .then(response => {
            console.log("Response received from explore_get_user_data.php"); // Debugging line
            return response.json();
        })
        .then(data => {
            console.log('User Data:', data); // Debugging line
            if (data.error) {
                console.error("Error fetching user data: ", data.error);
                logError("Error fetching user data: " + data.error);
                return;
            }
            const { username, profile_picture, tags } = data;
            document.getElementById('user-image').src = profile_picture;
            document.getElementById('user-link').href = 'account.html';
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            logError('Error fetching user data: ' + error);
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
});
