<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, profile_picture, disability FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user['tags'] = [];

    $tag_sql = "SELECT t.tag_name FROM user_tags ut JOIN tags t ON ut.tag_id = t.tag_id WHERE ut.user_id = ?";
    $tag_stmt = $conn->prepare($tag_sql);
    $tag_stmt->bind_param('i', $user_id);
    $tag_stmt->execute();
    $tag_result = $tag_stmt->get_result();

    while ($tag = $tag_result->fetch_assoc()) {
        $user['tags'][] = $tag['tag_name'];
    }

    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
