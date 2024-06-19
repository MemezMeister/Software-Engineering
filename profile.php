<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");  // Redirect to login/register page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $email = $row['email'];
        $user_image = $row['user_image'];
        $image_type = $row['image_type'];

        // Check if the image is local or online
        if ($image_type == 'local') {
            $image_src = str_replace('C:\\xampp\\htdocs\\Software-Engineering\\', '', $user_image);
        } else {
            $image_src = $user_image;
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
        <img src="<?php echo htmlspecialchars($image_src); ?>" alt="Profile Picture">
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
    </div>
</body>
</html>
