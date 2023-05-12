<?php
session_start();
// Retrieve the URL from the AJAX request
$url = $_POST['url'];

//retrive the golbal varible that is the user name 
$user = $_SESSION['username'];

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to insert the link into the table
$stmt = $conn->prepare("INSERT INTO saved_links (url, user) VALUES (?, ?)");
$stmt->bind_param("ss", $url, $user);


// Execute the statement
if ($stmt->execute()) {
  echo "Link saved successfully";
} else {
  echo "Error saving link: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
