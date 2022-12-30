<?php include("../config/db_connect.php"); ?>
<?php
	$errors = ["exam_name" => "", "exam_department" => "", "other_errors" => ""];

	if (isset($_POST["create_exam"])) {
		$array_keys = array_keys($_POST);
		$questions = $quesions_types = $answers_1 = $answers_2 = $answers_3 = $answers_4 = $correct_answers = $grades = [];
		$exam_name = $exam_department = "";

		foreach($_POST as $key => $value) {
			if(preg_match("/^question_[0-9]+$/", $key)) {
				array_push($questions, $value);
			} elseif (preg_match("/^question_[0-9]+_type$/", $key)) {
				array_push($quesions_types, $value);
				if ($value === "essay") {
					array_push($answers_1, NULL);
					array_push($answers_2, NULL);
					array_push($answers_3, NULL);
					array_push($answers_4, NULL);
					array_push($correct_answers, NULL);
				}
			} elseif (preg_match("/question_[0-9]+_option_[0-9]+/", $key) || preg_match("/^question_[0-9]+_answer$/", $key)) {
				if (preg_match("/question_[0-9]+_option_1/", $key)) {
					array_push($answers_1, $value);
				} elseif (preg_match("/question_[0-9]+_option_2/", $key)) {
					array_push($answers_2, $value);
				} elseif (preg_match("/question_[0-9]+_option_3/", $key)) {
					array_push($answers_3, $value);
				} elseif (preg_match("/question_[0-9]+_option_4/", $key)) {
					array_push($answers_4, $value);
				} elseif (preg_match("/^question_[0-9]+_answer$/", $key)) {
					array_push($answers_1, NULL);
					array_push($answers_2, NULL);
					array_push($answers_3, NULL);
					array_push($answers_4, NULL);
					array_push($correct_answers, $value);
				}
			} elseif (preg_match("/^question_[0-9]+_answer_selector$/", $key) || preg_match("/^question_[0-9]+_answer_order$/", $key)) {
				array_push($correct_answers, $value);
			} elseif (preg_match("/^question_[0-9]+_grade$/", $key)) {
				array_push($grades, $value);
			} elseif ($key === "exam_department") {
				$exam_department = $value;
			} elseif ($key === "exam_name") {
				$exam_name = $value;
			}
		}

		if ($exam_name === "") {
			$errors["exam_name"] = "Exam name is missing!";
		}
		if ($exam_department === "") {
			$errors["exam_department"] = "Exam department is missing!";
		}

		$exam_name = mysqli_real_escape_string($conn, $_POST["exam_name"]);
		$sql = "SELECT name FROM exams WHERE name = '$exam_name'";
		$result = mysqli_query($conn, $sql);
		$exam_name_check = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if ($exam_name_check) {
			$errors["other_errors"] = "Exam name already in the database!";
		}

		
		if (array_filter($errors)) {
			echo "errors in the form!";
		} else {
			$exam_name = mysqli_real_escape_string($conn, $_POST["exam_name"]);
			$exam_department = mysqli_real_escape_string($conn, $_POST["exam_department"]);	

			$sql = "INSERT INTO exams(name, department) VALUES('$exam_name','$exam_department')";

			if (mysqli_query($conn, $sql)) {
				$sql = "SELECT id FROM exams WHERE name = '$exam_name'";
				$result = mysqli_query($conn, $sql);
				$exam_id = mysqli_fetch_assoc($result);
				mysqli_free_result($result);
				$exam_id = $exam_id["id"];

				for ($i = 0; $i < count($questions); $i++) {
					$sql = "INSERT INTO exam_questions(question, type, answer_1, answer_2, answer_3, answer_4, correct_answer, grade, exam_id) VALUES('$questions[$i]', '$quesions_types[$i]', '$answers_1[$i]', '$answers_2[$i]', '$answers_3[$i]', '$answers_4[$i]', '$correct_answers[$i]', '$grades[$i]', '$exam_id')";
					if (!mysqli_query($conn, $sql)) {
						echo "query error: " . mysqli_error($conn);
					}
				}
				header("location: createExams.php");
			} else {
				echo "query error: " . mysqli_error($conn);
			}
		}
	}
?>