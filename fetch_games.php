<?php
require 'config.php';

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT g.game_id, g.game_name, g.game_image, g.accessibility_category,
        (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating, 
        (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags gt JOIN tags t ON gt.tag_id = t.tag_id WHERE gt.game_id = g.game_id AND gt.tag_type = 'positive') AS positive_tags,
        (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags gt JOIN tags t ON gt.tag_id = t.tag_id WHERE gt.game_id = g.game_id AND gt.tag_type = 'negative') AS negative_tags
        FROM games g
        LEFT JOIN game_views v ON g.game_id = v.game_id
        GROUP BY g.game_id
        ORDER BY COUNT(v.view_id) DESC";

$result = $mysqli->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed: ' . $mysqli->error]);
    exit();
}

$games = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
} else {
    echo json_encode(['error' => 'No games found.']);
    exit();
}

$mysqli->close();

header('Content-Type: application/json');
echo json_encode($games);
?>
