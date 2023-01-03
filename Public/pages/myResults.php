<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/studentsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php 
	// Define counter
	$counter = 1;

	// Write query for all results
	$sql = "SELECT exam_id, status, grade FROM exam_results WHERE student_number = '$student_number' ORDER BY submitted_at";

	// Make query and get result
	$result = mysqli_query($conn, $sql);
	
	// Fetch the resulting rows as an array
	$exam_results = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Free result from memory
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
				<div>
					<p>NOTE: PENDING status means that some or all essays of the exam are yet to be graded by an instructor.</p>
				</div>
				<table>
					<caption class="tableCaption">Exam Results</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Exam Name:</th>
							<th>Exam Course:</th>
							<th>Grading Status:</th>
							<th>Grade:</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($exam_results as $exam_result) { ?>
							<?php $exam_id = $exam_result["exam_id"]; ?>
							<?php $sql = "SELECT name, course FROM exams WHERE id = $exam_id"; ?>
							<?php $result = mysqli_query($conn, $sql); ?>
							<?php $exam_info = mysqli_fetch_assoc($result); ?>
							<tr>
								<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
								<td><?php echo htmlspecialchars($exam_info["name"]); ?></td>
								<td><?php echo htmlspecialchars($exam_info["course"]); ?></td>
								<td><?php echo htmlspecialchars($exam_result["status"]); ?></td>
								<td><?php echo htmlspecialchars($exam_result["grade"]) . " / 100"; ?></td>
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