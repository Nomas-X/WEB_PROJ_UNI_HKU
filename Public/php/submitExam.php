<?php

	if (isset($_POST["submit_exam"])) {
		$answers = $questions_ids = [];
		$exam_id = 0;
		$grade_total = 0;
		$status = "COMPLETE";

		foreach($_POST as $key => $value) {
			if(preg_match("/^question_[0-9]+_id$/", $key)) {
				array_push($questions_ids, $value);
			} elseif (preg_match("/^question_[0-9]+_answer$/", $key)) {
				array_push($answers, $value);
			} elseif (preg_match("/exam_id/", $key)) {
				$exam_id = (int)$value;
			}
		}

		$sql = "SELECT question_id, correct_answer, type, grade FROM exam_questions WHERE exam_id = $exam_id";

		$result = mysqli_query($conn, $sql);

		$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

		mysqli_free_result($result);

		for ($i = 0 ; $i < count($questions_ids); $i++) { 
			foreach ($questions as $question) {
				if ($question["question_id"] === $questions_ids[$i]) {
					if ($question["type"] === "essay") {
						$status = "PENDING";
						$essay = mysqli_real_escape_string($conn, $answers[$i]);
						$sql = "INSERT INTO exam_essays(exam_id, student_number, essay) VALUES ($exam_id, '$student_number', '$essay')";
						if (!mysqli_query($conn, $sql)) {
							echo "query error: " . mysqli_error($conn);
						}
					} elseif ($question["type"] === "multiple_choices") {
						$answers_array = explode(",", $answers[$i]);
						$correct_answers_array = explode(",", $question["correct_answer"]);
						array_pop($answers_array);
						array_pop($correct_answers_array);
						$number_of_correct_options = count($correct_answers_array);
						$grade_per_option = $question["grade"] / $number_of_correct_options;
						$j = 0;

						foreach ($answers_array as $value) {
							if ($j >= $number_of_correct_options || $j >= count($answers_array)) {
								break;
							}
							if ($answers_array[$j] === $correct_answers_array[$j]) {
								$grade_total += $grade_per_option;
							}
							$j++;	
						}

					} elseif ($question["correct_answer"] === $answers[$i]) {
						$grade_total += $question["grade"];
					}
				}
			}
		}

		$sql = "INSERT INTO exam_results(student_number, exam_id, status, grade) VALUES ('$student_number', $exam_id, '$status', $grade_total)";

		if (!mysqli_query($conn, $sql)) {
			echo "query error: " . mysqli_error($conn);
		} else {
			header("location: myResults.php");
		}
	}
?>