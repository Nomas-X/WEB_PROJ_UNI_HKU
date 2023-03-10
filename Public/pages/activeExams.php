<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/studentsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php 
	$counter = 1;

	$sql = "SELECT name, id, course, created_at, deadline FROM exams ORDER BY created_at";

	$result = mysqli_query($conn, $sql);
	
	$exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

	mysqli_free_result($result);

	$student_courses_array = explode(",", $student_courses);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../stylesheets/styles.css">
	<script src="https://kit.fontawesome.com/3646abfb94.js" crossorigin="anonymous"></script>
	<title>Active Exams</title>
	<link rel="icon" href="../images/logo.png">
</head>
<body>
	<div class="wrapper">
		<div class="sidebar">
			<?php include("../templates/sideBarStudent.php") ?>
		</div>
		<div class="main_content">
			<div class="header">Welcome <?php print_r($first_name . " " . $last_name); ?>!</div>
			<div class="info">
				<table>
					<caption class="tableCaption">Active Exams List</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Exam Name:</th>
							<th>Exam Course:</th>
							<th>Created at:</th>
							<th>Deadline:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($exams as $exam) { ?>
							<?php foreach($student_courses_array as $student_course) { ?>
								<?php if ($exam["course"] === $student_course) { ?>
									<?php $exam_id = $exam['id']; ?>
									<?php $sql = "SELECT * FROM exam_results WHERE student_number = '$student_number' AND exam_id = $exam_id"; ?>
									<?php $result = mysqli_query($conn, $sql); ?>
									<?php $exam_taken_check = mysqli_fetch_assoc($result); ?>
									<?php if ($exam_taken_check) {} else { ?>
										<?php if (time() < strtotime($exam["deadline"])) {?>
											<tr>
												<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
												<td><?php echo htmlspecialchars($exam["name"]); ?></td>
												<td><?php echo htmlspecialchars($exam["course"]); ?></td>
												<td><?php echo htmlspecialchars($exam["created_at"]); ?></td>
												<td><?php echo htmlspecialchars($exam["deadline"]); ?></td>
												<td class="active_exam_list_td">
													<form class="exam_list_form">
														<button type="button" name="exam_take" value="exam" class="active_exam">
															<a href="exam.php?id=<?php echo htmlspecialchars($exam["id"]); ?>" class="exam_link">
																<span>Take</span>
															</a>
														</button>
													</form>
												</td>
											</tr>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php mysqli_close($conn); ?>
					</tbody>
				</table>
		  </div>
		</div>
	</div>
</body>
</html>