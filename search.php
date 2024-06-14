<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'games_db';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = $_GET['query'];

$sql = "SELECT game_id, game_name, game_image,
        (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating, 
        (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags WHERE game_id = g.game_id) AS tags
        FROM games g
        WHERE game_name LIKE ?";

$stmt = $mysqli->prepare($sql);
$searchQuery = "%" . $query . "%";
$stmt->bind_param('s', $searchQuery);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="explore.css">
</head>
<body>
    <div class="container">
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
        <div class="game-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="game-item">';
                    echo '<img src="' . $row['game_image'] . '" alt="' . htmlspecialchars($row['game_name']) . '">';
                    echo '<h2>' . htmlspecialchars($row['game_name']) . '</h2>';
                    echo '<div class="tags">' . htmlspecialchars($row['tags']) . '</div>';
                    echo '<div class="rating">Average Rating: ' . number_format($row['avg_rating'], 1) . '</div>';
                    echo '<a href="game.php?game_id=' . $row['game_id'] . '">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No results found.</p>';
            }

            $stmt->close();
            $mysqli->close();
            ?>
        </div>
    </div>
</body>
</html>
