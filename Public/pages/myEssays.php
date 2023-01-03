<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/studentsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php 
	// Define counter
	$counter = 1;

	// Write query for all results
	$sql = "SELECT * FROM exam_essays WHERE student_number = '$student_number' AND status = 'GRADED'";

	// Make query and get result
	$result = mysqli_query($conn, $sql);
	
	// Fetch the resulting rows as an array
	$essay_results = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
					<p>NOTE: If you do not see the result of an essay you submitted then an instructor has not graded it yet.</p>
				</div>
				<table>
					<caption class="tableCaption">Essay</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>Exam Name:</th>
							<th>Exam Course:</th>
							<th>Essay Question:</th>
							<th>Grade:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($essay_results as $essay_result) { ?>
							<?php $exam_id = $essay_result["exam_id"]; ?>
							<?php $sql = "SELECT name, course FROM exams WHERE id = $exam_id"; ?>
							<?php $result = mysqli_query($conn, $sql); ?>
							<?php $exam_info = mysqli_fetch_assoc($result); ?>
							<?php $question_id = $essay_result["question_id"]; ?>
							<?php $sql = "SELECT question FROM exam_questions WHERE question_id = $question_id"; ?>
							<?php $result = mysqli_query($conn, $sql); ?>
							<?php $question = mysqli_fetch_assoc($result); ?>
							<tr>
								<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
								<td><?php echo htmlspecialchars($exam_info["name"]); ?></td>
								<td><?php echo htmlspecialchars($exam_info["course"]); ?></td>
								<td><?php echo substr(htmlspecialchars($question["question"]), 0, 100); ?></td>
								<td><?php echo htmlspecialchars($essay_result["final_grade"]) . " / " . htmlspecialchars($essay_result["essay_max_grade"]); ?></td>
								<td>
									<form>
										<button type="button" name="essay_check" value="check" class="check_essay">
											<a href="myEssay.php?id=<?php echo htmlspecialchars($essay_result["essay_id"]); ?>" class="preview_link">
												<span>Check</span>
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