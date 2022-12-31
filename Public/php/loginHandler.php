<?php 
	$login_type = $login_id = $login_password = "";
	$errors = ["login_type" => "", "login_id" => "", "login_password" => "", "login_wrong" => ""];
	$cookieExpireTime = 14400;
	$logged_in = $_COOKIE["logged_in"] ?? false;
	$user_type = $_COOKIE["user_type"] ?? NULL;

	if ($logged_in) {
		if ($user_type === "Student") {
			header("location: activeExams.php");
		} elseif ($user_type === "Instructor") {
			header("location: examList.php");
		}
	}

	if (isset($_POST["login_submit"])) {
		if (empty($_POST["login_type"])) {
			$errors["login_type"] = "You must select login type!";
		} else {
			$login_type = $_POST["login_type"];
			if ($login_type !== "Student" && $login_type !== "Instructor") {
				$errors["login_type"] = "Invalid login type!";
			}
		}

		if (empty($_POST["login_id"])) {
			$errors["login_id"] = "Login ID is missing!";
		} else {
			$login_id = $_POST["login_id"];
			if ($login_type === "Student") {
				if (!preg_match("/^\d+$/u", $login_id)) {
					$errors["login_id"] = "Invalid student number!";
				}
			} elseif ($login_type === "Instructor") {
				if (!filter_var($login_id, FILTER_VALIDATE_EMAIL)) {
					$errors["login_id"] = "Invalid email!";
				}
			}
		}

		if (empty($_POST["login_password"])) {
			$errors["login_password"] = "Password is missing!";
		} else {
			$login_password = $_POST["login_password"];
		}

		if (array_filter($errors)) {
			echo "errors in the form!";
		} else {
			$login_type = mysqli_real_escape_string($conn, $_POST["login_type"]);	
			$login_id = mysqli_real_escape_string($conn, $_POST["login_id"]);
			$login_password = mysqli_real_escape_string($conn, $_POST["login_password"]);

			// Create sql
			if ($login_type === "Student") {
				$sql = "SELECT * FROM students WHERE student_number = $login_id";
			} elseif ($login_type === "Instructor") {
				$sql = "SELECT * FROM instructors WHERE email = '$login_id'";
			}

			// Make query and get result
			$result = mysqli_query($conn, $sql);
			
			// Fetch the resulting rows as an array
			$user = mysqli_fetch_assoc($result);

			// Free result from memory
			mysqli_free_result($result);

			// Close the connection
			mysqli_close($conn);

			if ($user) {
				if ($login_password === $user["password"]) {
					setcookie("user_type", $login_type, time() + $cookieExpireTime);
					setcookie("first_name", $user["first_name"], time() + $cookieExpireTime);
					setcookie("last_name", $user["last_name"], time() + $cookieExpireTime);
					setcookie("logged_in", true, time() + $cookieExpireTime);
					
					if ($login_type === "Student") {
						setcookie("student_number", $user["student_number"], time() + $cookieExpireTime);
						setcookie("department", $user["department"], time() + $cookieExpireTime);
						header("location: students.php");
					} elseif ($login_type === "Instructor") {
						setcookie("email", $user["email"], time() + $cookieExpireTime);
						header("location: examList.php");
					}
				} else {
					$errors["login_wrong"] = "Wrong password or email/student ID!";
				}
			} else {
				$errors["login_wrong"] = "Wrong password or email/student ID!";
			}
		}
	}
?>