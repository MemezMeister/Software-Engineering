<?php
require 'config.php';
    //PENGAMBILAN tag
$sql = "SELECT tag_id as id, tag_name as name, tag_type as type FROM tags";
$result = $conn->query($sql);

$tags = [];
while ($row = $result->fetch_assoc()) {
    $tags[] = $row;
}

echo json_encode($tags);

$conn->close();
?>
