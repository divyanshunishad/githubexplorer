<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    // Redirect to the main page
    header("Location: http://localhost/githubexplorer/index.html");
    exit(); // Terminate the current script
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Github Explorer</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="style.css">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<!-- menubar js-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<!--staring menu bar -->
	<nav class="navbar navbar-inverse navbar-fixed-top ">
		<div class="container-fluid ">
		  <div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="http://localhost/githubexplorer/main/index.php">Github Explorer</a>
		  </div>
		  <div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
			  <li><a href="http://localhost/githubexplorer/main/index.php">Home</a></li>
			  <li class="active"><a href="bookmark.php">Saved Link</a></li>
			  <li><a href="aboutus.html">About us</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
			</ul>
		  </div>
		</div>
	  </nav>
    <!--end menu bar -->
    <div class="container"> 
      <!-- data retrived will be showed here -->
      <?php


// Retrieve the username from the session
$user = $_SESSION['username'];

// Assuming you have a MySQL database
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

// Retrieve the saved links for the user from the table
$sql = "SELECT * FROM saved_links WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $url = $row["url"];
        // Display the link as a list item with a clickable anchor tag
        echo "<li><a href='$url' target='_blank'>$url</a></li>";
    }
    echo "</ul>";
} else {
    echo "No saved links found";
}

$stmt->close();
$conn->close();
?>

<!-- end data retrived showed -->
	

    </div>
	
	
  
	<!--footer started-->
	<div class="footer">
		<p style="margin: 10px 0px 0px;">Made by Divyanshu.<span class="glyphicon glyphicon-heart"></span> </p>
	</div>
	<!--footer end-->


</body>
</html>

