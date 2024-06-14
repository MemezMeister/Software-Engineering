<?php
session_start();

if (!isset($_GET['game_id'])) {
    echo "No game ID provided.";
    exit();
}

require 'config.php';

$is_logged_in = isset($_SESSION['user_id']);

// Fetch game details
$game_id = $conn->real_escape_string($_GET['game_id']);
$sql = "SELECT g.game_name, g.game_image, g.steam_link, g.epicgames_link, g.other_link,
        (SELECT AVG(rating) FROM user_reviews WHERE game_id = g.game_id) AS avg_rating,
        (SELECT GROUP_CONCAT(tag_name SEPARATOR ', ') FROM game_tags WHERE game_id = g.game_id) AS tags
        FROM games g
        WHERE g.game_id = '$game_id'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Game not found.";
    exit();
}

// Fetch user reviews
$reviews_sql = "SELECT ur.rating, ur.review_text, u.username FROM user_reviews ur JOIN users u ON ur.user_id = u.user_id WHERE ur.game_id = '$game_id'";
$reviews_result = $conn->query($reviews_sql);
$reviews = [];
if ($reviews_result->num_rows > 0) {
    while ($review = $reviews_result->fetch_assoc()) {
        $reviews[] = $review;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['game_name']); ?></title>
    <link rel="stylesheet" href="game.css">
</head>
<body>
    <header>
        <div class="user-icon">
            <a href="<?php echo $is_logged_in ? 'account.php' : 'login_register.php'; ?>">
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
        <div class="reviews" style="float:left; width:45%; margin-right: 5%;">
            <h2>Reviews</h2>
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="review-header">
                            <h3><?php echo htmlspecialchars($review['username']); ?></h3>
                            <div class="star-rating read-only">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label><?php echo $i <= $review['rating'] ? '★' : '☆'; ?></label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet.</p>
            <?php endif; ?>
            <?php if ($is_logged_in): ?>
                <button id="write-review-button">Write your own</button>
                <div id="write-review-form" style="display:none;">
                    <form action="submit_review.php" method="post">
                        <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($game_id); ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <div class="review-header">
                            <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                            </div>
                        </div>
                        <textarea name="review_text" rows="5" placeholder="Write your review here..."></textarea>
                        <button type="submit" class="btn">Submit</button>
                    </form>
                </div>
            <?php else: ?>
                <p><a href="login_register.php">Log in</a> to write a review.</p>
            <?php endif; ?>
        </div>
        <div class="game-details" style="float:right; width:45%;">
            <h1><?php echo htmlspecialchars($row['game_name']); ?></h1>
            <div class="links">
                <?php if (!empty($row['steam_link'])): ?>
                    <a href="<?php echo htmlspecialchars($row['steam_link']); ?>"><img src="steam_icon.png" alt="Steam"></a>
                <?php endif; ?>
                <?php if (!empty($row['epicgames_link'])): ?>
                    <a href="<?php echo htmlspecialchars($row['epicgames_link']); ?>"><img src="epicgames_icon.png" alt="Epic Games"></a>
                <?php endif; ?>
                <?php if (!empty($row['other_link'])): ?>
                    <a href="<?php echo htmlspecialchars($row['other_link']); ?>"><img src="other_icon.png" alt="Other"></a>
                <?php endif; ?>
            </div>
            <div class="rating-container">
                <div class="rating-title">Accessibility Rating</div>
                <div class="rating">
                    <?php
                    $avg_rating = number_format($row['avg_rating'], 1);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $avg_rating) {
                            echo '★';
                        } elseif ($i - $avg_rating < 1) {
                            echo '<span class="star half">★</span>';
                        } else {
                            echo '☆';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="tags">
                <?php
                $tags = explode(', ', $row['tags']);
                foreach ($tags as $tag) {
                    echo '<div>' . htmlspecialchars($tag) . '</div>';
                }
                ?>
            </div>
            <img src="<?php echo htmlspecialchars($row['game_image']); ?>" alt="<?php echo htmlspecialchars($row['game_name']); ?>">
        </div>
    </div>
    <script>
        document.getElementById('write-review-button').addEventListener('click', function() {
            document.getElementById('write-review-form').style.display = 'block';
        });
    </script>
</body>
</html>
