<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $log_file = 'error_log.txt';
    $error_message = $_POST['error_message'];
    
    file_put_contents($log_file, $error_message . PHP_EOL, FILE_APPEND);
}
?>
