document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('change-picture-button').addEventListener('click', function() {
        const profilePictureUrl = document.getElementById('profile-picture-url').value;

        fetch(`update_profile_picture.php?url=${encodeURIComponent(profilePictureUrl)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update profile picture');
                }
            })
            .catch(error => console.error('Error updating profile picture:', error));
    });
});
