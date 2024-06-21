<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

function log_error($message) {
    error_log($message, 3, 'error_log.txt');
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$input_raw = file_get_contents('php://input');

log_error('Raw input: ' . $input_raw);

if (!$input_raw) {
    echo json_encode(['error' => 'No input received']);
    exit();
}

$input = json_decode($input_raw, true);

log_error('Decoded input: ' . print_r($input, true));

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'JSON decode error: ' . json_last_error_msg()]);
    exit();
}

if (isset($input['profile_picture']) && !empty($input['profile_picture'])) {
    $profile_picture = $input['profile_picture'];

    log_error('Profile picture URL: ' . $profile_picture);

    if (!filter_var($profile_picture, FILTER_VALIDATE_URL)) {
        echo json_encode(['error' => 'Invalid URL format']);
        exit();
    }

    $sql = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $profile_picture, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update profile picture', 'details' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}

$conn->close();
?>
