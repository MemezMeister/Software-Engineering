<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = $_POST['game_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    $sql = "INSERT INTO user_reviews (game_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $game_id, $user_id, $rating, $review_text);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Review submitted successfully.";
    } else {
        $_SESSION['error'] = "An error occurred. Please try again.";
    }
    header("Location: game.php?game_id=" . $game_id);
    exit();
}
?>
