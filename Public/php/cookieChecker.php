<?php
	$user_type = $_COOKIE["user_type"] ?? NULL;
	$first_name = $_COOKIE["first_name"] ?? NULL;
	$last_name = $_COOKIE["last_name"] ?? NULL;
	$email = $_COOKIE["email"] ?? NULL;
	$student_number = $_COOKIE["student_number"] ?? NULL;
	$department = $_COOKIE["department"] ?? NULL;
	$logged_in = $_COOKIE["logged_in"] ?? false;

	if (!$logged_in) {
		header("location: login.php");
	}
?>