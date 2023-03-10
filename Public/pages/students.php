<?php include("../php/cookieChecker.php"); ?>
<?php include("../php/instructorsOnly.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/addStudent.php"); ?>
<?php include("../php/removeStudent.php"); ?>
<?php 
	$counter = 1;

	$sql = "SELECT first_name, last_name, student_number, courses FROM students ORDER BY first_name";

	$result = mysqli_query($conn, $sql);
	
	$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

	mysqli_free_result($result);

	$sql = "SELECT * FROM courses";

	$result = mysqli_query($conn, $sql);
	
	$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
	<title>Students List</title>
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
					<caption class="tableCaption">Students List</caption>
					<thead>
						<tr>
							<th>No.</th>
							<th>First Name:</th>
							<th>Last Name:</th>
							<th>Student Number:</th>
							<th>Courses:</th>
							<th>||</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($students as $student) { ?>
								<tr>
									<td><?php echo htmlspecialchars($counter) . "."; $counter++; ?></td>
									<td><?php echo htmlspecialchars($student["first_name"]); ?></td>
									<td><?php echo htmlspecialchars($student["last_name"]); ?></td>
									<td><?php echo htmlspecialchars($student["student_number"]); ?></td>
									<td><?php echo htmlspecialchars(str_replace(",", " | ", $student["courses"])); ?></td>
									<td class="delete_std_td">
										<form action="students.php" method="POST">
											<input type="hidden" name="std_to_delete" value="<?php echo $student["student_number"]; ?>">
											<button type="submit" name="std_delete" value="Delete" class="delete_student"><span>Delete</span></button>
										</form>
									</td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
				<br>
				<hr>
				<p>Add a student:</p>
				<form action="students.php" method="POST">
					<input type="text" placeholder="First Name" class="add_student_inputs" name="std_f_name" value="<?php echo htmlspecialchars($std_f_name); ?>" required>
					<input type="text" placeholder="Last Name" class="add_student_inputs" name="std_l_name" value="<?php echo htmlspecialchars($std_l_name); ?>" required>
					<input type="text" placeholder="Student Number" class="add_student_inputs" name="std_number" value="<?php echo htmlspecialchars($std_number); ?>" required>
					<input type="password" placeholder="Password" class="add_student_inputs" name="std_password"value="<?php echo htmlspecialchars($std_password); ?>" required>
					<p class="add_student_courses_p">Courses:</p>
					<?php $course_counter = 1; ?>
					<?php foreach ($courses as $course) { ?>
						<div>
							<input type="checkbox" name="std_course_<?php echo $course_counter++ ?>" value="<?php echo htmlspecialchars($course["code"]); ?>">
							<label><?php echo htmlspecialchars($course["code"] . " | " . $course["name"]); ?></label>
						</div>
					<?php } ?>
					<button class="add_student_button" type="submit" name="add_std_submit">Add</button>
				</form>
				<div class="errors_container">
					<div class="std_add_error"><?php echo $errors["std_f_name"]; ?></div>
					<div class="std_add_error"><?php echo $errors["std_l_name"]; ?></div>
					<div class="std_add_error"><?php echo $errors["std_number"]; ?></div>
					<div class="std_add_error"><?php echo $errors["std_password"]; ?></div>
					<div class="std_add_error"><?php echo $errors["std_courses"]; ?></div>
				</div>
		  </div>
		</div>
	</div>
	<script src="../javascript/students.js"></script>
</body>
</html>