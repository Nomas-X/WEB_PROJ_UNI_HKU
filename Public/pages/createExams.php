<?php include("../config/db_connect.php"); ?>
<?php include("../php/createExam.php"); ?>

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
			<div class="header">Welcome!! [Insert Name]!</div>  
			<div class="info">
				<form>
					<div>
						<input type="text" class="create_inputs" placeholder="Exam Name">
						<select name="" id="" class="create_inputs">
							<option value="0">Department</option>
							<option value="EEE">EEE | Eletrical and Electrons Engineering</option>
							<option value="COME">COME | Computer Engineering</option>
							<option value="CENG">CENG | Civil Engineering</option>
							<option value="LAW">LAW | Laws and Rights</option>
						</select>
					</div>
					<hr>
					<div>
						<select id="question_type" class="create_inputs" onchange="validateQuestionType()">
							<option value="0">Question Type</option>
							<option value="single_choice">Single Choice</option>
							<!-- Multiple choices grading will be done based on how many answers the student has got right -->
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
						<input type="hidden" name="exam_department" value="">
						<input type="hidden" name="exam_name" value="">
						<button type="submit" class="create_exam" id="create_exam" name="create_exam">Create Exam</button>
					</div>
				</form>
		  </div>
		</div>
	</div>
	<script src="../javascript/createExam.js"></script>
</body>
</html>