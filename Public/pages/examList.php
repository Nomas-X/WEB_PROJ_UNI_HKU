<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/deleteExam.php"); ?>
<?php 
	// Define counter
	$counter = 1;

	// Write query for all students
	$sql = "SELECT name, id, department, created_at FROM exams ORDER BY created_at";

	// Make query and get result
	$result = mysqli_query($conn, $sql);
	
	// Fetch the resulting rows as an array
	$exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
				<table>
					<caption class="tableCaption">Exams List</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Exam Name:</th>
							<th>Exam Department:</th>
							<th>Exam ID:</th>
							<th>Created at:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($exams as $exam) { ?>
								<tr>
									<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
									<td><?php echo htmlspecialchars($exam["name"]); ?></td>
									<td><?php echo htmlspecialchars($exam["department"]); ?></td>
									<td><?php echo htmlspecialchars($exam["id"]); ?></td>
									<td><?php echo htmlspecialchars($exam["created_at"]); ?></td>
									<td class="exam_list_td">
										<form action="examList.php" method="POST" class="exam_list_form">
											<input type="hidden" name="exam_to_delete" value="<?php echo $exam["id"]; ?>">
											<button type="submit" name="exam_delete" value="Delete" class="delete_exam">
												<span>Delete</span>
											</button>
										</form>
										<form action="examList.php" method="GET" class="exam_list_form">
											<button type="button" name="exam_preview" value="preview" class="preview_exam" href="profile.php">
												<a href="preview.php?id=<?php echo htmlspecialchars($exam["id"]); ?>" class="preview_link">
													<span>Preview</span>
												</a>
											</button>
										</form>
									</td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
		  </div>
		</div>
	</div>
	<script src="../javascript/students.js"></script>
</body>
</html>