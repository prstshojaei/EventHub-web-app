<?php
session_start();

// Remove all session data and log the admin out
session_destroy();

// Go back to login page
header('Location: login.php');
exit;
?>