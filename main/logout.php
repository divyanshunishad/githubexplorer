<?php
session_start();

// Destroy the session and unset all session variables
session_destroy();
$_SESSION = [];

// Redirect to the main page
header("Location: http://localhost/githubexplorer/index.html");
exit();
?>
