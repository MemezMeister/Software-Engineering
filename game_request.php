<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game_name = $_POST['game_name'];
    $game_link = $_POST['game_link'];
    $game_description = $_POST['game_description'];

    if (empty($game_name) || empty($game_link) || empty($game_description)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    $sql = "INSERT INTO game_requests (game_name, game_link, game_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $game_name, $game_link, $game_description);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
