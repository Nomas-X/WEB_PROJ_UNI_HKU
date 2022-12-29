<?php 
	// Connection to database
	$conn = mysqli_connect("localhost", "Redwan", "Password", "xero_exams");

	// Check connection
	if (!$conn) {
		echo "Connection error: " . mysqli_connect_error();
	}
?>