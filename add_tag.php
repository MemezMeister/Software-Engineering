<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

if (!isset($_GET['tag'])) {
    echo json_encode(['error' => 'No tag provided']);
    exit();
}

$user_id = $_SESSION['user_id'];
$tag_name = $conn->real_escape_string($_GET['tag']);

// pengecekan jika tag ada dalam sistem
$tag_sql = "SELECT tag_id FROM tags WHERE tag_name = ?";
$tag_stmt = $conn->prepare($tag_sql);
$tag_stmt->bind_param('s', $tag_name);
$tag_stmt->execute();
$tag_result = $tag_stmt->get_result();

if ($tag_result->num_rows === 0) {
    echo json_encode(['error' => 'Tag not found']);
    exit();
}

$tag = $tag_result->fetch_assoc();
$tag_id = $tag['tag_id'];

// cek jika user sudah ada tag tersebut
$user_tag_sql = "SELECT * FROM user_tags WHERE user_id = ? AND tag_id = ?";
$user_tag_stmt = $conn->prepare($user_tag_sql);
$user_tag_stmt->bind_param('ii', $user_id, $tag_id);
$user_tag_stmt->execute();
$user_tag_result = $user_tag_stmt->get_result();

if ($user_tag_result->num_rows > 0) {
    echo json_encode(['error' => 'User already has this tag']);
    exit();
}

// penambahan tag
$add_tag_sql = "INSERT INTO user_tags (user_id, tag_id) VALUES (?, ?)";
$add_tag_stmt = $conn->prepare($add_tag_sql);
$add_tag_stmt->bind_param('ii', $user_id, $tag_id);

if ($add_tag_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to add tag']);
}

$tag_stmt->close();
$user_tag_stmt->close();
$add_tag_stmt->close();
$conn->close();
?>
