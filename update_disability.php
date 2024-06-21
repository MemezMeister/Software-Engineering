<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['disability'])) {
    echo json_encode(['success' => false, 'error' => 'Disability not specified.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$disability = $data['disability'];

$sql = "UPDATE users SET disability = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Database prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('si', $disability, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
