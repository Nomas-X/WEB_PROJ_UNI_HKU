<?php
	if (isset($_POST["submit_grade"])) {
		$grade = mysqli_real_escape_string($conn, $_POST["submitted_grade"]);	
		$essay_id = mysqli_real_escape_string($conn, $_POST["essay_id"]);	
		$exam_id = mysqli_real_escape_string($conn, $_POST["exam_id"]);	
		$essay_student_number = mysqli_real_escape_string($conn, $_POST["student_number"]);

		$sql = "UPDATE exam_essays SET final_grade = $grade, status = 'GRADED' WHERE essay_id = $essay_id";

		if (mysqli_query($conn, $sql)) {
			$sql = "SELECT * FROM exam_essays WHERE exam_id = $exam_id AND status = 'PENDING'";

			$result = mysqli_query($conn, $sql);

			$essay = mysqli_fetch_assoc($result);
	
			mysqli_free_result($result);

			if ($essay) {
				$sql = "UPDATE exam_results SET grade = grade + $grade WHERE exam_id = $exam_id AND student_number = '$essay_student_number'";
			} else {
				$sql = "UPDATE exam_results SET grade = grade + $grade, status = 'COMPLETE' WHERE exam_id = $exam_id AND student_number = '$essay_student_number'";
			}
			
			if (mysqli_query($conn, $sql)) {
				header("location: gradeEssays.php");
			} else {
				echo "quere error: " . mysqli_error($conn);
			}
		} else {
			echo "query error: " . mysqli_error($conn);
		}
	}
?>