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

if (!$stmt) {
    echo json_encode(['error' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Database execute failed: ' . $stmt->error]);
    exit();
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user['tags'] = [];

    $tag_sql = "SELECT t.tag_id as id, t.tag_name as name FROM user_tags ut JOIN tags t ON ut.tag_id = t.tag_id WHERE ut.user_id = ?";
    $tag_stmt = $conn->prepare($tag_sql);

    if (!$tag_stmt) {
        echo json_encode(['error' => 'Tag query prepare failed: ' . $conn->error]);
        exit();
    }

    $tag_stmt->bind_param('i', $user_id);

    if (!$tag_stmt->execute()) {
        echo json_encode(['error' => 'Tag query execute failed: ' . $tag_stmt->error]);
        exit();
    }

    $tag_result = $tag_stmt->get_result();

    while ($tag = $tag_result->fetch_assoc()) {
        $user['tags'][] = $tag['name'];
    }

    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
