<?php
	$current_password = $new_password = $new_password_confirm = "";
	$errors = ["current_password" => "", "new_password" => "", "new_password_confirm" => ""];
	$password_update = "";
	$password_regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

	if (isset($_POST["change_password"])) {
		if (empty($_POST["current_password"])) {
			$errors["current_password"] = "Current password is required!";
		} else {
			$current_password = $_POST["current_password"];
			if ($user_type === "Instructor") {
				$sql = "SELECT password FROM instructors WHERE email = '$email'";
			} elseif ($user_type === "Student") {
				$sql = "SELECT password FROM students WHERE student_number = $student_number";
			}
			$result = mysqli_query($conn, $sql);
			$password_check = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			if ($password_check["password"] !== $current_password) {
				$errors["current_password"] = "Incorrect current password!";
			}
		}
		if (empty($_POST["new_password"])) {
			$errors["new_password"] = "New password is required!";
		} else {
			$new_password = $_POST["new_password"];
			if (!preg_match($password_regex, $new_password)) {
				$errors["new_password"] = "Invalid password, you need a minimum of 8 character which include 1 upper Case, 1 special character, and 1 number!";
			}
		}
		if (empty($_POST["new_password_confirm"])) {
			$errors["new_password_confirm"] = "New password confirmation is required!";
		} else {
			$new_password_confirm = $_POST["new_password_confirm"];
			if ($new_password !== $new_password_confirm) {
				$errors["new_password_confirm"] = "Password confirmation does not match!";
			}
		}

		if (array_filter($errors)) {
			echo "errors in the form!";
		} else {
			$current_password = mysqli_real_escape_string($conn, $_POST["current_password"]);	
			$new_password = mysqli_real_escape_string($conn, $_POST["new_password"]);	

			if ($user_type === "Instructor") {
				$sql = "UPDATE instructors SET password = '$new_password' WHERE email = '$email'";
			} elseif ($user_type === "Student") {
				$sql = "UPDATE students SET password = '$new_password' WHERE student_number = $student_number";
			}

			if (mysqli_query($conn, $sql)) {
				$password_update = "Password was changed successfully!";
			} else {
				echo "query error: " . mysqli_error($conn);
			}
		}
	}
?>