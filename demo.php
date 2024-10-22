<?php
session_start(); // Start the session
include 'config/config.php'; // Include the config file

// Check if session has any data
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION); // Display all session data in a readable format
    echo "</pre>";
} else {
    echo "No session data available.";
}
?>
