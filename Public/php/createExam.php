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
		} // Add escape real string
		// This is for testing
		print_r($_POST);
		print_r("<br><br>");
		print_r($questions);
		print_r("<br><br>");
		print_r($quesions_types);
		print_r("<br><br>");
		print_r($answers_1);
		print_r("<br><br>");
		print_r($answers_2);
		print_r("<br><br>");
		print_r($answers_3);
		print_r("<br><br>");
		print_r($answers_4);
		print_r("<br><br>");
		print_r($correct_answers);
		print_r("<br><br>");
		print_r($grades);
		print_r("<br><br>");
		print_r($exam_name);
		print_r("<br><br>");
		print_r($exam_department);
	}
?>