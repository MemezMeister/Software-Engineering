<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");  // Redirect to login/register page if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Games</title>
    <link rel="stylesheet" href="explore.css">
</head>
<body>
    <header>
        <div class="user-icon">
            <a href="<?php echo isset($_SESSION['user_id']) ? 'account.php' : 'login_register.php'; ?>">
                <img src="<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : 'Software-Engineering/Create_a_cartoonish_gamer_icon_featuring_a_playful.png'; ?>" alt="User Icon">
            </a>
        </div>
        <div class="search-bar">
            <form action="search.php" method="get">
                <input type="text" name="query" placeholder="Search games...">
                <button type="submit">Search</button>
            </form>
        </div>
    </header>
    <div class="container">
        <h1>Explore Games</h1>
        <div class="tabs">
            <button class="tab-button" onclick="showCategory('colorblind')">Colorblind Accessibility</button>
            <button class="tab-button" onclick="showCategory('deaf')">Deaf Accessibility</button>
            <button class="tab-button" onclick="showCategory('colorblind-deaf')">Colorblind and Deaf Accessibility</button>
            <button class="tab-button" onclick="showCategory('non-inclusive')">Non-Inclusive Games</button>
        </div>
        <div class="game-list" id="game-list">
            <?php
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'games_db';

            $mysqli = new mysqli($host, $user, $password, $database);

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            $sql = "SELECT g.game_id, g.game_name, g.game_image, g.accessibility_category,
                    (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating, 
                    (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags WHERE game_id = g.game_id) AS tags
                    FROM games g
                    LEFT JOIN game_views v ON g.game_id = v.game_id
                    GROUP BY g.game_id
                    ORDER BY COUNT(v.view_id) DESC";

            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="game-item" data-category="' . $row['accessibility_category'] . '">';
                    echo '<img src="' . htmlspecialchars($row['game_image']) . '" alt="' . htmlspecialchars($row['game_name']) . '">';
                    echo '<h2>' . htmlspecialchars($row['game_name']) . '</h2>';
                    echo '<div class="tags">' . htmlspecialchars($row['tags']) . '</div>';
                    echo '<div class="rating">Average Rating: ' . number_format($row['avg_rating'], 1) . '</div>';
                    echo '<a href="game.php?game_id=' . $row['game_id'] . '">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No games found.</p>';
            }

            $mysqli->close();
            ?>
        </div>
    </div>
    <script>
        function showCategory(category) {
            var items = document.getElementsByClassName('game-item');
            for (var i = 0; i < items.length; i++) {
                if (items[i].getAttribute('data-category').includes(category) || category === 'all') {
                    items[i].style.display = 'flex';
                } else {
                    items[i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
