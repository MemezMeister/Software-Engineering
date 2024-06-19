<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log'); // Make sure this path is writable

if (!isset($_GET['game_id'])) {
    echo json_encode(['error' => 'No game ID provided.']);
    exit();
}

$game_id = $conn->real_escape_string($_GET['game_id']);

$sql = "SELECT g.game_name, g.game_image, g.steam_link, g.epicgames_link, g.other_link,
        (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating,
        COALESCE((SELECT GROUP_CONCAT(t.tag_name SEPARATOR ', ') FROM game_tags gt 
         JOIN tags t ON gt.tag_id = t.tag_id 
         WHERE gt.game_id = g.game_id AND gt.tag_type = 'positive'), '') AS positive_tags,
        COALESCE((SELECT GROUP_CONCAT(t.tag_name SEPARATOR ', ') FROM game_tags gt 
         JOIN tags t ON gt.tag_id = t.tag_id 
         WHERE gt.game_id = g.game_id AND gt.tag_type = 'negative'), '') AS negative_tags
        FROM games g
        WHERE g.game_id = '$game_id'";

$result = $conn->query($sql);
if ($result === false) {
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit();
}

if ($result->num_rows > 0) {
    $game = $result->fetch_assoc();
} else {
    echo json_encode(['error' => 'Game not found.']);
    exit();
}

$reviews_sql = "SELECT ur.rating, ur.review_text, u.username FROM user_reviews ur JOIN users u ON ur.user_id = u.user_id WHERE ur.game_id = '$game_id'";
$reviews_result = $conn->query($reviews_sql);
if ($reviews_result === false) {
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit();
}

$reviews = [];
if ($reviews_result->num_rows > 0) {
    while ($review = $reviews_result->fetch_assoc()) {
        $reviews[] = $review;
    }
}

$response = [
    'is_logged_in' => isset($_SESSION['user_id']),
    'user_id' => $_SESSION['user_id'] ?? null,
    'user_image' => $_SESSION['user_image'] ?? 'Software-Engineering/Create_a_cartoonish_gamer_icon_featuring_a_playful.png',
    'username' => $_SESSION['username'] ?? null,
    'game' => $game,
    'reviews' => $reviews
];

// Debugging: Output the response for debugging
echo json_encode($response, JSON_PRETTY_PRINT);
?>
