<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php
	$counter = 1;

	$sql = "SELECT essay_id, exam_id, student_number, essay_max_grade FROM exam_essays WHERE status = 'PENDING' ORDER BY exam_id";

	$result = mysqli_query($conn, $sql);

	$essays = mysqli_fetch_all($result, MYSQLI_ASSOC);

	mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../stylesheets/styles.css">
	<script src="https://kit.fontawesome.com/3646abfb94.js" crossorigin="anonymous"></script>
	<title>Grade Essays</title>
	<link rel="icon" href="../images/logo.png">
</head>
<body>
	<div class="wrapper">
		<div class="sidebar">
			<?php include("../templates/sideBarInstructor.php") ?>
		</div>
		<div class="main_content">
			<div class="header">Welcome <?php print_r($first_name . " " . $last_name); ?>!</div>
			<div class="info">
				<table>
					<caption class="tableCaption">Essay Grading List</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Student Number:</th>
							<th>Student Name:</th>
							<th>Exam Name:</th>
							<th>Exam Course:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($essays as $essay) { ?>
							<?php $essay_student_number = $essay["student_number"] ?>
							<?php $essay_student_number = mysqli_real_escape_string($conn, $essay_student_number); ?>
							<?php $sql = "SELECT first_name, last_name FROM students WHERE student_number = '$essay_student_number'"; ?>
							<?php $result = mysqli_query($conn, $sql); ?>
							<?php $student = mysqli_fetch_assoc($result); ?>
							<?php mysqli_free_result($result); ?>
							<?php $exam_info = $essay["student_number"] ?>
							<?php $exam_id = $essay["exam_id"] ?>
							<?php $exam_id = mysqli_real_escape_string($conn, $exam_id); ?>
							<?php $sql = "SELECT name, course FROM exams WHERE id = $exam_id"; ?>
							<?php $result = mysqli_query($conn, $sql); ?>
							<?php $exam = mysqli_fetch_assoc($result); ?>
							<?php mysqli_free_result($result); ?>
							<tr>
								<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
								<td><?php echo htmlspecialchars($essay["student_number"]); ?></td>
								<td><?php echo htmlspecialchars($student["first_name"] . " " . $student["last_name"]); ?></td>
								<td><?php echo htmlspecialchars($exam["name"]); ?></td>
								<td><?php echo htmlspecialchars($exam["course"]); ?></td>
								<td class="essay_list_td">
									<form class="essay_list_form">
										<button type="button" name="grade_essay" value="Grade" class="grade_essay">
											<a href="essay.php?id=<?php echo htmlspecialchars($essay["essay_id"]); ?>" class="grade_link">
												<span>Grade</span>
											</a>
										</button>
									</form>
								</td>
							</tr>
						<?php } ?>
						<?php mysqli_close($conn); ?>
					</tbody>
				</table>
		  </div>
		</div>
	</div>
</body>
</html>