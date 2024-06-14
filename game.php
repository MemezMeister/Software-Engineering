<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");
    exit();
}

require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Details</title>
    <link rel="stylesheet" href="game.css">
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
        <div class="reviews">
            <h2>Whats your opinion?</h2>
            <form action="submit_review.php" method="post">
                <input type="hidden" name="game_id" value="<?php echo $_GET['game_id']; ?>">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="review">
                    <h3><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></h3>
                    <div class="rating">
                        <label for="star1"><input type="radio" id="star1" name="rating" value="1">★</label>
                        <label for="star2"><input type="radio" id="star2" name="rating" value="2">★★</label>
                        <label for="star3"><input type="radio" id="star3" name="rating" value="3">★★★</label>
                        <label for="star4"><input type="radio" id="star4" name="rating" value="4">★★★★</label>
                        <label for="star5"><input type="radio" id="star5" name="rating" value="5">★★★★★</label>
                    </div>
                    <textarea name="review_text" rows="5" placeholder="Write your review here..."></textarea>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
        <div class="game-details">
            <?php
            $game_id = $conn->real_escape_string($_GET['game_id']);
            $sql = "SELECT g.game_name, g.game_image, g.steam_link, g.epicgames_link, g.other_link,
                    (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating,
                    (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags WHERE game_id = g.game_id) AS tags
                    FROM games g
                    WHERE g.game_id = '$game_id'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h1>' . htmlspecialchars($row['game_name']) . '</h1>';
                echo '<div class="links">';
                if (!empty($row['steam_link'])) {
                    echo '<a href="' . htmlspecialchars($row['steam_link']) . '"><img src="steam_icon.png" alt="Steam"></a>';
                }
                if (!empty($row['epicgames_link'])) {
                    echo '<a href="' . htmlspecialchars($row['epicgames_link']) . '"><img src="epicgames_icon.png" alt="Epic Games"></a>';
                }
                if (!empty($row['other_link'])) {
                    echo '<a href="' . htmlspecialchars($row['other_link']) . '"><img src="other_icon.png" alt="Other"></a>';
                }
                echo '</div>';
                echo '<div class="rating">Average Rating: ' . number_format($row['avg_rating'], 1) . '</div>';
                echo '<div class="tags">' . htmlspecialchars($row['tags']) . '</div>';
                echo '<img src="' . htmlspecialchars($row['game_image']) . '" alt="' . htmlspecialchars($row['game_name']) . '">';
            } else {
                echo '<p>Game not found.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
