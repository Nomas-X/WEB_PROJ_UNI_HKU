<?php include("../php/cookieChecker.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php 
	// Define counter
	$counter = 1;

	// Write query for all students
	$sql = "SELECT name, id, course, created_at, deadline FROM exams ORDER BY created_at";

	// Make query and get result
	$result = mysqli_query($conn, $sql);
	
	// Fetch the resulting rows as an array
	$exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Free result from memory
	mysqli_free_result($result);

	// Close the connection
	mysqli_close($conn);

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
	<title>Document</title>
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
									<tr>
										<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
										<td><?php echo htmlspecialchars($exam["name"]); ?></td>
										<td><?php echo htmlspecialchars($exam["course"]); ?></td>
										<td><?php echo htmlspecialchars($exam["created_at"]); ?></td>
										<td><?php echo htmlspecialchars($exam["deadline"]); ?></td>
										<td class="active_exam_list_td">
											<form class="exam_list_form">
												<button type="button" name="exam_preview" value="preview" class="active_exam">
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
					</tbody>
				</table>
		  </div>
		</div>
	</div>
	<script src="../javascript/students.js"></script>
</body>
</html>