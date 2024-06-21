document.addEventListener("DOMContentLoaded", function() {
    fetch('explore_get_user_data.php')
        .then(response => response.json())
        .then(data => {
            console.log('User Data:', data); 
            if (data.error) {

                const userIcon = document.querySelector('.user-icon');
                userIcon.innerHTML = '<a class="login-btn" href="login_register.php">Login</a>';
            } else {
                const { profile_picture } = data;
                document.getElementById('user-image').style.backgroundImage = `url(${profile_picture})`;
                document.getElementById('user-link').href = 'account.html';
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            const userIcon = document.querySelector('.user-icon');
            userIcon.innerHTML = '<a class="login-btn" href="login_register.php">Login</a>';
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
