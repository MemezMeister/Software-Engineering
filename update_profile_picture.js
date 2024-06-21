document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('change-picture-button').addEventListener('click', function() {
        const profilePictureUrl = document.getElementById('profile-picture-url').value;

        console.log('Profile Picture URL:', profilePictureUrl);

        if (!profilePictureUrl) {
            console.error('No URL entered');
            alert('Please enter a profile picture URL');
            return;
        }

        fetch('update_profile_picture.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profile_picture: profilePictureUrl })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response data:', data); 
            if (data.success) {
                alert('Profile picture updated successfully');
                location.reload();
            } else {
                alert('Failed to update profile picture: ' + data.error);
                console.error('Error:', data.error);
            }
        })
        .catch(error => {
            console.error('Error updating profile picture:', error);
            alert('Error updating profile picture: ' + error);
        });
    });
});
