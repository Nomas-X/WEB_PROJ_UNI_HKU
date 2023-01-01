<?php
	$errors = ["exam_name" => "", "exam_course" => "", "exam_deadline" => "", "grades" => "", "missing_grade" => "", "other_errors" => ""];

	if (isset($_POST["create_exam"])) {
		$array_keys = array_keys($_POST);
		$questions = $quesions_types = $answers_1 = $answers_2 = $answers_3 = $answers_4 = $correct_answers = $grades = [];
		$exam_name = $exam_course = $exam_deadline = "";
		$grade_total = 0;

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
			} elseif ($key === "exam_course") {
				$exam_course = $value;
			} elseif ($key === "exam_name") {
				$exam_name = $value;
			} elseif ($key === "exam_deadline") {
				$exam_deadline = $value;
			}
		}

		if ($exam_name === "") {
			$errors["exam_name"] = "Exam name is missing!";
		}
		if ($exam_course === "") {
			$errors["exam_course"] = "Exam course is missing!";
		}
		if ($exam_deadline === "") {
			$errors["exam_deadline"] = "Exam deadline is missing!";
		}

		$exam_name = mysqli_real_escape_string($conn, $_POST["exam_name"]);
		$sql = "SELECT name FROM exams WHERE name = '$exam_name'";
		$result = mysqli_query($conn, $sql);
		$exam_name_check = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		if ($exam_name_check) {
			$errors["other_errors"] = "Exam name already in the database!";
		}

		foreach ($grades as $grade) {
			$grade = (int)$grade;
			if (gettype($grade) === "string") {
				$errors["missing_grade"] = "A question is missing it's grade!";
				break;
			}
			$grade_total += $grade;
		}

		if ($grade_total > 100 || $grade_total < 100) {
			$errors["grades"] = "Grade total must equal 100, current grade total is $grade_total!";
		}

		
		if (array_filter($errors)) {
			echo "errors in the form!";
		} else {
			$exam_name = mysqli_real_escape_string($conn, $_POST["exam_name"]);
			$exam_course = mysqli_real_escape_string($conn, $_POST["exam_course"]);	
			$exam_deadline = str_replace("T", " ", $exam_deadline);
			$exam_deadline = $exam_deadline . ":00";
			$exam_deadline = mysqli_real_escape_string($conn, $exam_deadline);
			$creator = $first_name . " " . $last_name;
			$creator = mysqli_real_escape_string($conn, $creator);

			$sql = "INSERT INTO exams(name, course, created_by, deadline) VALUES('$exam_name','$exam_course', '$creator', '$exam_deadline')";

			if (mysqli_query($conn, $sql)) {
				$sql = "SELECT id FROM exams WHERE name = '$exam_name'";
				$result = mysqli_query($conn, $sql);
				$exam_id = mysqli_fetch_assoc($result);
				mysqli_free_result($result);
				$exam_id = $exam_id["id"];

				for ($i = 0; $i < count($questions); $i++) {
					$question = mysqli_real_escape_string($conn, $questions[$i]);
					$quesion_type = mysqli_real_escape_string($conn, $quesions_types[$i]);
					$answer_1 =  mysqli_real_escape_string($conn, $answers_1[$i]);
					$answer_2 = mysqli_real_escape_string($conn, $answers_2[$i]);
					$answer_3 = mysqli_real_escape_string($conn, $answers_3[$i]);
					$answer_4 = mysqli_real_escape_string($conn, $answers_4[$i]);
					$correct_answer = mysqli_real_escape_string($conn, $correct_answers[$i]);
					$grade = mysqli_real_escape_string($conn, $grades[$i]);
					$sql = "INSERT INTO exam_questions(question, type, answer_1, answer_2, answer_3, answer_4, correct_answer, grade, exam_id) VALUES('$question', '$quesion_type', '$answer_1', '$answer_2', '$answer_3', '$answer_4', '$correct_answer', '$grade', '$exam_id')";
					if (!mysqli_query($conn, $sql)) {
						echo "query error: " . mysqli_error($conn);
					}
				}
				// header("location: createExams.php");
			} else {
				echo "query error: " . mysqli_error($conn);
			}
		}
	}
?>