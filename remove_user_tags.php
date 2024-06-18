<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$tag_id = $data['tag_id'];

$sql = "DELETE FROM user_tags WHERE user_id = ? AND tag_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $tag_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to remove tag.']);
}

$stmt->close();
$conn->close();
?>
