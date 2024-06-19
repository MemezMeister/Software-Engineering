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

$sql = "SELECT g.game_id, g.game_name, g.game_image,
        (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating, 
        (SELECT GROUP_CONCAT(t.tag_name SEPARATOR ', ') FROM game_tags gt JOIN tags t ON gt.tag_id = t.tag_id WHERE gt.game_id = g.game_id) AS tags
        FROM games g
        WHERE g.game_name LIKE ?";

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
    <header>
        <div class="user-icon">
            <a id="user-link"><img id="user-image" alt=""></a>
        </div>
        <div class="logo">
            <a href="explore.html"><img src="WebsiteLogo.png" alt="Website Logo"></a>
        </div>
        <div class="search-bar">
            <form action="search.php" method="get">
                <button class="request-game-btn" onclick="window.location.href='game_request.html';">Request a Game</button>
                <input type="text" name="query" placeholder="Search games...">
                <button type="submit">Search</button>
            </form>
        </div>
    </header>
    <div class="container">
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
        <div class="game-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $positiveTags = '';
                    $negativeTags = '';
                    $tagsArray = explode(', ', $row['tags']);
                    foreach ($tagsArray as $tag) {
                        if (in_array($tag, ['Safe Tag 1', 'Safe Tag 2'])) { // Add your positive tags here
                            $positiveTags .= "<div class='tag positive' data-message='Safe for $tag'>$tag</div>";
                        } else {
                            $negativeTags .= "<div class='tag negative' data-message='Not Safe for $tag'>$tag</div>";
                        }
                    }
                    echo '<div class="game-item">';
                    echo '<img src="' . htmlspecialchars($row['game_image']) . '" alt="' . htmlspecialchars($row['game_name']) . '">';
                    echo '<h2>' . htmlspecialchars($row['game_name']) . '</h2>';
                    echo '<div class="tags">' . $positiveTags . ' ' . $negativeTags . '</div>';
                    echo '<div class="rating">' . str_repeat('★', round($row['avg_rating'])) . str_repeat('☆', 5 - round($row['avg_rating'])) . '</div>';
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
