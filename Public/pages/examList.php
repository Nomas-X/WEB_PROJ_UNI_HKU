<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/deleteExam.php"); ?>
<?php 
	$counter = 1;

	$sql = "SELECT name, id, course, created_at, deadline, created_by FROM exams ORDER BY deadline DESC";

	$result = mysqli_query($conn, $sql);
	
	$exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

	mysqli_free_result($result);

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
	<title>Exam List</title>
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
					<caption class="tableCaption">Exams List</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Exam Name:</th>
							<th>Exam Course:</th>
							<th>Created by:</th>
							<th>Status:</th>
							<th>Created at:</th>
							<th>Deadline:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($exams as $exam) { ?>
							<?php $exam_status = strtotime($exam["deadline"]) > time() ? "In Progress" : "Ended"; ?>
								<tr>
									<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
									<td><?php echo htmlspecialchars($exam["name"]); ?></td>
									<td><?php echo htmlspecialchars($exam["course"]); ?></td>
									<td><?php echo htmlspecialchars($exam["created_by"]); ?></td>
									<td><?php echo htmlspecialchars($exam_status); ?></td>
									<td><?php echo htmlspecialchars($exam["created_at"]); ?></td>
									<td><?php echo htmlspecialchars($exam["deadline"]); ?></td>
									<td class="exam_list_td">
										<form action="examList.php" method="POST" class="exam_list_form">
											<input type="hidden" name="exam_to_delete" value="<?php echo $exam["id"]; ?>">
											<button type="submit" name="exam_delete" value="Delete" class="delete_exam">
												<span>Delete</span>
											</button>
										</form>
										<form class="exam_list_form">
											<button type="button" name="exam_preview" value="preview" class="preview_exam">
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
</body>
</html>