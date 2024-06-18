<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

// Fetch all available tags
$sql = "SELECT tag_name FROM tags";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    exit();
}

$tags = [];

while ($row = $result->fetch_assoc()) {
    $tags[] = $row['tag_name'];
}

echo json_encode(['tags' => $tags]);

$conn->close();
?>
