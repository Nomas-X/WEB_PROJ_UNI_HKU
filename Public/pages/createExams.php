<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/createExam.php"); ?>
<?php 
	// Write query for all students
	$sql = "SELECT * FROM courses";

	// Make query and get result
	$result = mysqli_query($conn, $sql);
	
	// Fetch the resulting rows as an array
	$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Free result from memory
	mysqli_free_result($result);

	// Close the connection
	mysqli_close($conn);
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
				<form>
					<div class="errors_container">
						<div class="exam_create_error"><?php echo $errors["exam_name"]; ?></div>
						<div class="exam_create_error"><?php echo $errors["exam_course"]; ?></div>
						<div class="exam_create_error"><?php echo $errors["exam_deadline"]; ?></div>
						<div class="exam_create_error"><?php echo $errors["missing_grade"]; ?></div>
						<div class="exam_create_error"><?php echo $errors["grades"]; ?></div>
						<div class="exam_create_error"><?php echo $errors["other_errors"]; ?></div>
					</div>
					<div>
						<input type="text" class="create_inputs" id="name_selector" placeholder="Exam Name">
						<select name="" class="create_inputs" id="course_selector">
							<option value="">Course</option>
							<?php if ($courses) { ?>
								<?php foreach ($courses as $course) { ?>
									<option value="<?php echo htmlspecialchars($course["code"]); ?>"><?php echo htmlspecialchars($course["code"] . " | " . htmlspecialchars($course["name"])); ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<label class="create_exam_label">Deadline:</label>
						<input type="datetime-local" class="create_inputs deadline_input" id="deadline_selector" placeholder="Deadline">
					</div>
					<hr>
					<div>
						<select id="question_type" class="create_inputs" onchange="validateQuestionType()">
							<option value="0">Question Type</option>
							<option value="single_choice">Single Choice</option>
							<option value="multiple_choices">Multiple Choices</option> 
							<option value="order_answers">Order The Answers</option>
							<option value="fill_blank">Fill the Blank</option>
							<option value="essay">Essay</option>
						</select>
						<button type="button" class="add_question_inactive" id="add_question">Add Question</button>
					</div>
				</form>
				<hr>
				<form action="createExams.php" method="POST" class="questions_container" id="questions_container">
					<div id="create_exam_submit">
						<input type="hidden" name="exam_name" id="exam_name" value="">
						<input type="hidden" name="exam_course" id="exam_course" value="">
						<input type="hidden" name="exam_deadline" id="exam_deadline" value="">
						<button type="submit" class="create_exam" id="create_exam" name="create_exam">Create Exam</button>
					</div>
				</form>
		  </div>
		</div>
	</div>
	<script src="../javascript/createExam.js"></script>
</body>
</html>