<?php
session_start();

function displayPopup() {
    if (isset($_SESSION['error'])) {
        echo '<div class="popup" id="popup">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="popup" id="popup">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
}
?>
