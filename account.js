document.addEventListener('DOMContentLoaded', function() {
    fetch('get_user_data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the data for debugging
            if (data.error) {
                alert(data.error);
                return;
            }

            const { username, profile_picture, tags } = data;

            // Update the username and profile picture
            document.getElementById('username').innerText = username;
            document.getElementById('profile-picture').style.backgroundImage = `url(${profile_picture})`;

            // Populate tags
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
        })
        .catch(error => console.error('Error fetching user data:', error));

    document.getElementById('add-tag-button').addEventListener('click', function() {
        fetch('get_available_tags.php')
            .then(response => response.json())
            .then(data => {
                const tagModal = document.createElement('div');
                tagModal.classList.add('tag-modal');

                const tagModalContent = document.createElement('div');
                tagModalContent.classList.add('tag-modal-content');

                const closeModalButton = document.createElement('span');
                closeModalButton.classList.add('close-tag-modal');
                closeModalButton.innerText = '×';
                closeModalButton.onclick = () => document.body.removeChild(tagModal);
                tagModalContent.appendChild(closeModalButton);

                data.tags.forEach(tag => {
                    const tagDiv = document.createElement('div');
                    tagDiv.classList.add('tag', 'negative');
                    tagDiv.innerText = tag;
                    tagDiv.onclick = () => addTag(tag);
                    tagModalContent.appendChild(tagDiv);
                });

                tagModal.appendChild(tagModalContent);
                document.body.appendChild(tagModal);
            })
            .catch(error => console.error('Error fetching available tags:', error));
    });

    function addTag(tag) {
        fetch(`add_tag.php?tag=${tag}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to add tag');
                }
            })
            .catch(error => console.error('Error adding tag:', error));
    }
});
