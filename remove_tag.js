document.addEventListener('DOMContentLoaded', function() {
    const tagsContainer = document.getElementById('tags');
    tagsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-tag')) {
            const tag = event.target.parentElement.innerText.replace('x', '').trim();

            fetch(`remove_tag.php?tag=${encodeURIComponent(tag)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to remove tag: ' + data.error);
                    }
                })
                .catch(error => console.error('Error removing tag:', error));
        }
    });
});
