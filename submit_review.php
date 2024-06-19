<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game_id = $conn->real_escape_string($_POST['game_id']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $review_text = $conn->real_escape_string($_POST['review_text']);

    $sql = "INSERT INTO user_reviews (game_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiis', $game_id, $user_id, $rating, $review_text);

    if ($stmt->execute()) {
        header("Location: game.php?game_id=" . $game_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
