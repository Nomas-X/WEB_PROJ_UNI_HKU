<?php 
	if (isset($_POST["std_delete"])) {
		$std_to_delete = mysqli_real_escape_string($conn, $_POST["std_to_delete"]);

		$sql = "DELETE FROM students WHERE student_number=$std_to_delete";

		if (mysqli_query($conn, $sql)) {
			header("Location: students.php");
		} else {
			echo "query error: " . mysqli_error($conn);
		}
	}
?>