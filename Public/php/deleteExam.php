<?php 
	if (isset($_POST["exam_delete"])) {
		$exam_to_delete = mysqli_real_escape_string($conn, $_POST["exam_to_delete"]);

		$sql = "DELETE FROM exams WHERE id = $exam_to_delete";

		if (mysqli_query($conn, $sql)) {
			$sql = "DELETE FROM exam_questions WHERE exam_id = $exam_to_delete";
			if (mysqli_query($conn, $sql)) {
				header("Location: examList.php");
			} else {
				echo "query error: " . mysqli_error($conn);
			}
		} else {
			echo "query error: " . mysqli_error($conn);
		}
	}
?>