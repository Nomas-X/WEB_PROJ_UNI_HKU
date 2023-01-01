<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php 
	// Check GET request for the exam id.
	if(isset($_GET["id"])) {
		$counter = 1;

		$id = mysqli_real_escape_string($conn, $_GET["id"]);

		$sql = "SELECT * FROM exams WHERE id = $id";

		$result = mysqli_query($conn, $sql);

		$exam = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		
		if ($exam) {
			$sql = "SELECT * FROM exam_questions WHERE exam_id = $id ORDER BY type DESC";

			$result = mysqli_query($conn, $sql);

			$questions_info = mysqli_fetch_all($result, MYSQLI_ASSOC);

			mysqli_free_result($result);

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
			<?php include("../templates/sideBarInstructor.php") ?>
		</div>
		<div class="main_content">
			<div class="header">Welcome <?php print_r($first_name . " " . $last_name); ?>!</div>
			<div class="info">
				<div>
					<?php if ($exam) { ?>
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
						<?php foreach ($questions_info as $question_info) { ?>
							<p class="question_preview_title">Question #<?php echo htmlspecialchars($counter) . " (" . htmlspecialchars(str_replace("_", " ", $question_info["type"])) . "):"; $counter++; ?></p>
							<p class="question_preview_question"><?php echo htmlspecialchars($question_info["question"]); ?></p>
							<?php if ($question_info["type"] === "single_choice" || $question_info["type"] === "multiple_choices" || $question_info["type"] === "order_answers") { ?>
								<p class="question_preview_options">Option 1: <?php echo htmlspecialchars($question_info["answer_1"]); ?></p>
								<p class="question_preview_options">Option 2: <?php echo htmlspecialchars($question_info["answer_2"]); ?></p>
								<p class="question_preview_options">Option 3: <?php echo htmlspecialchars($question_info["answer_3"]); ?></p>
								<p class="question_preview_options">Option 4: <?php echo htmlspecialchars($question_info["answer_4"]); ?></p>
							<?php } ?>
							<?php if ($question_info["type"] === "essay") { ?>
								<p class="question_preview_answer">Essay answers will be sent to the instructors!</p>
							<?php } else { ?>
								<p class="question_preview_answer">Correct answer(s): <?php echo htmlspecialchars($question_info["correct_answer"]); ?></p>
							<?php } ?>
							<p class ="question_preview_grade">Grade: <?php echo htmlspecialchars($question_info["grade"]); ?>/100</p>
							<hr class="question_preview_seperator">
						<?php } ?>
					<?php } else { ?>
						<div>
							<p class="exam_has_been_deleted">The exam you are trying to view does not exist or has been deleted!</p>
							<p class="exam_has_been_deleted"><a href="examList.php">Go Back!</a></p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>