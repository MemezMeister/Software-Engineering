document.addEventListener('DOMContentLoaded', function() {
    // Show the disability modal when the change button is clicked
    document.getElementById('change-disability-button').addEventListener('click', function() {
        document.getElementById('disability-modal').style.display = 'block';
    });

    // Save the selected disability when the save button is clicked
    document.getElementById('save-disability-button').addEventListener('click', function() {
        const selectedDisability = document.querySelector('input[name="disability"]:checked').value;
        console.log('Selected Disability:', selectedDisability); // Debugging line
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

    // Close the disability modal when the close button is clicked
    document.querySelectorAll('.close-disability-modal').forEach(element => {
        element.addEventListener('click', function() {
            document.getElementById('disability-modal').style.display = 'none';
        });
    });
});
