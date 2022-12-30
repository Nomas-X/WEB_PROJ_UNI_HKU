<?php 
	$std_f_name = $std_l_name = $std_number = $std_password = $std_department = "";
	$errors = ["std_f_name" => "", "std_l_name" => "", "std_number" => "", "std_password" => "", "std_department" => ""];

	if (isset($_POST["add_std_submit"])) {

		if (empty($_POST["std_f_name"])) {
			$errors["std_f_name"] = "A first name is required!";
		} else {
			$std_f_name = $_POST["std_f_name"];
			if (!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u", $std_f_name)) {
				$errors["std_f_name"] = "Invalid first name!";
			}
		}

		if (empty($_POST["std_l_name"])) {
			$errors["std_l_name"] = "A last name is required!";
		} else {
			$std_l_name = $_POST["std_l_name"];
			if (!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u", $std_l_name)) {
				$errors["std_l_name"] = "Invalid last name!";
			}
		}

		if (empty($_POST["std_number"])) {
			$errors["std_number"] = "A student number is required!";
		} else {
			$std_number = $_POST["std_number"];
			if (!preg_match("/^\d+$/u", $std_number)) {
				$errors["std_number"] = "Invalid student number!";
			}
			$sql = "SELECT student_number FROM students WHERE student_number = $std_number";
			$result = mysqli_query($conn, $sql);
			$std_number_check = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			if ($std_number_check) {
				$errors["std_number"] = "Student ID already in the database!";
			}
		}

		if (empty($_POST["std_password"])) {
			$errors["std_f_name"] = "A password is required!";
		} else {
			$std_password = $_POST["std_password"];
			if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/m", $std_password)) {
				$errors["std_password"] = "Invalid password, you need a minimum of 8 character which include 1 upper Case, 1 special character, and 1 number!";
			}
		}

		if (empty($_POST["std_department"])) {
			$errors["std_f_name"] = "A department is required!";
		} else {
			$std_department = $_POST["std_department"];
			if (!preg_match("/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u", $std_department)) {
				$errors["std_department"] = "Invalude department!";
			}
		}

		if (array_filter($errors)) {
			echo "errors in the form!";
		} else {
			$std_f_name = mysqli_real_escape_string($conn, $_POST["std_f_name"]);	
			$std_l_name = mysqli_real_escape_string($conn, $_POST["std_l_name"]);	
			$std_number = mysqli_real_escape_string($conn, $_POST["std_number"]);	
			$std_password = mysqli_real_escape_string($conn, $_POST["std_password"]);
			$std_department = mysqli_real_escape_string($conn, $_POST["std_department"]);	

			// Create sql
			$sql = "INSERT INTO students(first_name, last_name, student_number, password, department) VALUES('$std_f_name','$std_l_name', '$std_number', '$std_password', '$std_department')";

			// Save to db and check
			if (mysqli_query($conn, $sql)) {
				header("location: students.php");
			} else {
				echo "query error: " . mysqli_error($conn);
			}
		}
	}
?>