<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $image_type = $_POST['image_type'] ?? 'local';
    $user_image = $_POST['user_image'] ?? 'C:\\xampp\\htdocs\\Software-Engineering\\default_user_icon.png';

    // Use default image if no image provided
    if (empty($user_image) && $image_type == 'local') {
        $user_image = 'C:\\xampp\\htdocs\\Software-Engineering\\default_user_icon.png';
    }

    // Insert into the database
    $sql = "INSERT INTO users (username, email, password, user_image, image_type) VALUES ('$username', '$email', '$password', '$user_image', '$image_type')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: explore.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
