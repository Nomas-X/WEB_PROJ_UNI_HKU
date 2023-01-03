<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/gradeEssay.php"); ?>
<?php 
	// Check GET request for the exam id.
	if(isset($_GET["id"])) {
		$counter = 1;

		$id = mysqli_real_escape_string($conn, $_GET["id"]);

		$sql = "SELECT * FROM exam_essays WHERE essay_id = $id AND status = 'PENDING'";

		$result = mysqli_query($conn, $sql);

		$essay = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		
		if ($essay) {
			$question_id = mysqli_real_escape_string($conn, $essay["question_id"]);
			$sql = "SELECT question FROM exam_questions WHERE question_id = $question_id";

			$result = mysqli_query($conn, $sql);

			$question = mysqli_fetch_assoc($result);

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
					<?php if ($essay) { ?>
						<div>
							<p>Essay Question:</p>
							<p><?php echo htmlspecialchars($question["question"]); ?></p>
						</div>
						<div>
							<p>Question Grade:</p>
							<p><?php echo nl2br(htmlspecialchars($essay["essay_max_grade"])); ?></p>
						</div>
						<form action="essay.php" method="POST">
							<div>
								<input type="number" class="essay_grade_input" name="submitted_grade" value="0" min="0" max="<?php echo htmlspecialchars($essay["essay_max_grade"]); ?>">
								<input type="hidden" name="essay_id" value="<?php echo htmlspecialchars($essay["essay_id"]); ?>">
								<input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($essay["exam_id"]); ?>">
								<input type="hidden" name="student_number" value="<?php echo htmlspecialchars($essay["student_number"]); ?>">
								<button type="submit" class="grade_button" name="submit_grade">Finalize Grade</button>
							</div>
						</form>
						<hr class="preview_seperator">
						<div>
							<p class="essay_answer_title">Student's Answer:</p>
						</div>
						<div>
							<pre class="essay"><?php echo htmlspecialchars($essay["essay"]); ?></pre>
						</div>
					<?php } else { ?>
						<div>
							<p class="exam_has_been_deleted">The essay you are trying to grade does not exist or has already been graded!</p>
							<p class="exam_has_been_deleted"><a href="gradeEssays.php">Go Back!</a></p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>