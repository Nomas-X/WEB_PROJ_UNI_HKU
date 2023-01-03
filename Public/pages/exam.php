<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/studentsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/submitExam.php"); ?>
<?php 
	// Check GET request for the exam id.
	if(isset($_GET["id"])) {
		$question_counter = 1;

		$id = mysqli_real_escape_string($conn, $_GET["id"]);
		$student_number = mysqli_real_escape_string($conn, $student_number);

		$sql = "SELECT * from exam_results WHERE student_number = '$student_number' AND exam_id = $id";

		$result = mysqli_query($conn, $sql);

		$exam_result_check = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		$sql = "SELECT * FROM exams WHERE id = $id";

		$result = mysqli_query($conn, $sql);

		$exam = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		if (!$exam_result_check) {
			if ($exam) {
				$sql = "SELECT question, type, answer_1, answer_2, answer_3, answer_4, grade, question_id FROM exam_questions WHERE exam_id = $id ORDER BY type DESC";
	
				$result = mysqli_query($conn, $sql);
	
				$questions_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
				mysqli_free_result($result);
	
			}
		}
		
		mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../stylesheets/styles.css">
	<script src="https://kit.fontawesome.com/3646abfb94.js" crossorigin="anonymous"></script>
	<title>Document</title>
</head>
<body>
	<div class="wrapper">
		<div class="sidebar">
			<?php include("../templates/sideBarStudent.php") ?>
		</div>
		<div class="main_content">
			<div class="header">Goodluck <?php print_r($first_name . " " . $last_name); ?>!</div>
			<div class="info">
				<div>
					<?php if ($exam_result_check) { ?>
						<div>
							<p class="exam_has_been_deleted">You have already taken and submitted this exam, if this is a mistake contact your instructor!</p>
							<p class="exam_has_been_deleted"><a href="activeExams.php">Go Back!</a></p>
						</div>
					<?php } elseif (!$exam) { ?>
						<div>
							<p class="exam_has_been_deleted">The exam you are trying to take does not exist or has been deleted!</p>
							<p class="exam_has_been_deleted"><a href="activeExams.php">Go Back!</a></p>
						</div>
					<?php } elseif (time() > strtotime($exam["deadline"])) { ?>
						<div>
							<p class="exam_has_been_deleted">The exam you are trying to take is beyond it's deadline!</p>
							<p class="exam_has_been_deleted"><a href="activeExams.php">Go Back!</a></p>
						</div>
					<?php } elseif (!$exam_result_check) { ?>
						<div>
							<p>Exam name:</p>
							<p><?php echo htmlspecialchars($exam["name"]); ?></p>
						</div>
						<div>
							<p>Course:</p>
							<p><?php echo htmlspecialchars($exam["course"]); ?></p>
						</div>
						<div>
							<p>Created by:</p>
							<p><?php echo htmlspecialchars($exam["created_by"]); ?></p>
						</div>
						<div>
							<p>Created at:</p>
							<p><?php echo htmlspecialchars($exam["created_at"]); ?></p>
						</div>
						<div>
							<p>Deadline:</p>
							<p><?php echo htmlspecialchars($exam["deadline"]); ?></p>
						</div>
						<hr class="preview_seperator">
						<form action="exam.php?id=<?php echo htmlspecialchars($exam["id"]); ?>" method="POST">
							<?php foreach ($questions_info as $question_info) { ?>
								<p class="question_preview_title">Question #<?php echo htmlspecialchars($question_counter) . " (" . htmlspecialchars(str_replace("_", " ", $question_info["type"])) . ") [{$question_info['grade']} points]:"; ?></p>
								<input type="hidden" name="question_<?php echo $question_counter; ?>_id" value="<?php echo htmlspecialchars($question_info["question_id"]); ?>">
								<p class="question_preview_question"><?php echo htmlspecialchars($question_info["question"]); ?></p>
								<?php if ($question_info["type"] === "single_choice" || $question_info["type"] === "multiple_choices" || $question_info["type"] === "order_answers") { ?>
									<p class="question_preview_options">Option 1: <?php echo htmlspecialchars($question_info["answer_1"]); ?></p>
									<p class="question_preview_options">Option 2: <?php echo htmlspecialchars($question_info["answer_2"]); ?></p>
									<p class="question_preview_options">Option 3: <?php echo htmlspecialchars($question_info["answer_3"]); ?></p>
									<p class="question_preview_options">Option 4: <?php echo htmlspecialchars($question_info["answer_4"]); ?></p>
								<?php } ?>
								<p class="exam_answer">Your Answer:</p>
								<?php if ($question_info["type"] === "single_choice") { ?>
									<label class="exam_answer">Option 1</label>
									<input type="radio" name="question_<?php echo $question_counter; ?>_answer" value="1" required>
									<span>|</span>
									<label class="exam_answer">Option 2</label>
									<input type="radio" name="question_<?php echo $question_counter; ?>_answer" value="2" required>
									<span>|</span>
									<label class="exam_answer">Option 3</label>
									<input type="radio" name="question_<?php echo $question_counter; ?>_answer" value="3" required>
									<span>|</span>
									<label class="exam_answer">Option 4</label>
									<input type="radio" name="question_<?php echo $question_counter; ?>_answer" value="4" required>
								<?php } elseif ($question_info["type"] === "order_answers") { ?>
									<label class="exam_answer">Seperate order by commas only:</label>
									<input type="text" class="exam_answer_input" name="question_<?php echo $question_counter; ?>_answer" pattern="^[1-4],[1-4],[1-4],[1-4]$" placeholder="1,2,3,4" required>
								<?php } elseif ($question_info["type"] === "multiple_choices") { ?>
									<label class="exam_answer">Option 1</label>
									<input type="checkbox" name="question_<?php echo $question_counter; ?>_answer" value="1" onchange="setCheckboxAnswer('question_<?php echo $question_counter; ?>_answer');">
									<span>|</span>
									<label class="exam_answer">Option 2</label>
									<input type="checkbox" name="question_<?php echo $question_counter; ?>_answer" value="2" onchange="setCheckboxAnswer('question_<?php echo $question_counter; ?>_answer');">
									<span>|</span>
									<label class="exam_answer">Option 3</label>
									<input type="checkbox" name="question_<?php echo $question_counter; ?>_answer" value="3" onchange="setCheckboxAnswer('question_<?php echo $question_counter; ?>_answer');">
									<span>|</span>
									<label class="exam_answer">Option 4</label>
									<input type="checkbox" name="question_<?php echo $question_counter; ?>_answer" value="4" onchange="setCheckboxAnswer('question_<?php echo $question_counter; ?>_answer');">
								<?php } elseif ($question_info["type"] === "fill_blank") { ?>
									<input type="text" class="exam_answer_fill_blank" name="question_<?php echo $question_counter; ?>_answer" placeholder="your answer" required>
								<?php } elseif ($question_info["type"] === "essay") { ?>
									<textarea cols="100" rows="20" class="exam_answer_essay" name="question_<?php echo $question_counter; ?>_answer" placeholder="Write your essay." required></textarea>
								<?php } ?>
								<hr class="question_preview_seperator">
								<?php $question_counter++; ?>
							<?php } ?>
							<div>
								<input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam["id"]); ?>">
								<button type="submit" class="submit_exam" id="submit_exam" name="submit_exam">Submit Exam</button>
							</div>
						</form>
					<?php } else { ?>
						<div>
							<p class="exam_has_been_deleted">The exam you are trying to take does not exist or has been deleted!</p>
							<p class="exam_has_been_deleted"><a href="activeExams.php">Go Back!</a></p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<script src="../javascript/exam.js"></script>
</body>
</html>