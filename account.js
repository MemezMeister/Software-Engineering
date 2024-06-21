document.addEventListener('DOMContentLoaded', function() {
    // mengambil data user
    fetch('get_user_data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            if (data.error) {
                alert(data.error);
                return;
            }

            const { username, profile_picture, tags, disability } = data;

            // mengambil username dan profile picture
            document.getElementById('username').innerText = username;
            document.getElementById('profile-picture').style.backgroundImage = `url(${profile_picture})`;
            
            // mengambil tag
            const tagsContainer = document.getElementById('tags');
            tagsContainer.innerHTML = '';
            tags.forEach(tag => {
                const tagDiv = document.createElement('div');
                tagDiv.classList.add('tag', 'negative');
                tagDiv.innerText = tag;
                const removeButton = document.createElement('span');
                removeButton.classList.add('remove-tag');
                removeButton.innerText = 'x';
                tagDiv.appendChild(removeButton);
                tagsContainer.appendChild(tagDiv);
            });

            // Set current disability
            document.querySelector(`input[name="disability"][value="${disability}"]`).checked = true;
        })
        .catch(error => console.error('Error fetching user data:', error));
    
    // mengurus sign out
    document.getElementById('sign-out-button').addEventListener('click', function() {
        fetch('sign_out.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'explore.html';
                } else {
                    alert('Failed to sign out');
                }
            });
    });

    // tunjukan ui disabilitas saat di klik
    document.getElementById('change-disability-button').addEventListener('click', function() {
        document.getElementById('disability-modal').style.display = 'block';
    });

    // simpan disabilitas ke database
    document.getElementById('save-disability-button').addEventListener('click', function() {
        const selectedDisability = document.querySelector('input[name="disability"]:checked').value;
        fetch('update_disability.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ disability: selectedDisability })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('disability-modal').style.display = 'none';
                location.reload();
            } else {
                alert('Failed to update disability: ' + data.error);
            }
        })
        .catch(error => console.error('Error updating disability:', error));
    });

    // tutup UI ganti disabilitas
    document.querySelectorAll('.close-disability-modal').forEach(element => {
        element.addEventListener('click', function() {
            document.getElementById('disability-modal').style.display = 'none';
        });
    });
});
