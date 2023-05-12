<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input from the form and sanitize it
$username = $_POST['username'];
$password = $_POST['password'];

// Sanitize user input
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Check if the user exists in the database
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // User found, store username in a session variable
    $_SESSION['username'] = $username;

    //User found, store password in a session variable
    $_SESSION['password'] = $password;

    // Store the main page URL in a session variable
    $_SESSION['main_page_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Redirect to the main page
    header("Location: http://localhost/githubexplorer/main/index.php" );
} else {
    // User not found, redirect to an error page
    header("Location: error.html");
}

$conn->close();
?>
