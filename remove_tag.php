<?php
session_start();
require 'config.php'; // Adjust the path if needed

header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit();
}

if (!isset($_GET['tag'])) {
    echo json_encode(['success' => false, 'error' => 'Tag not specified.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$tag_name = $_GET['tag'];

// Get the tag ID from the tag name
$sql = "SELECT tag_id FROM tags WHERE tag_name = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}
$stmt->bind_param('s', $tag_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Tag not found.']);
    exit();
}

$tag_id = $result->fetch_assoc()['tag_id'];

// Remove the tag from the user
$sql = "DELETE FROM user_tags WHERE user_id = ? AND tag_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}
$stmt->bind_param('ii', $user_id, $tag_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute statement failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
