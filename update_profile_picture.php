<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['profile_picture']) && !empty($input['profile_picture'])) {
    $profile_picture = $input['profile_picture'];

    $sql = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $profile_picture, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update profile picture', 'details' => $stmt->error]); // Added details
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}

$conn->close();
?>
