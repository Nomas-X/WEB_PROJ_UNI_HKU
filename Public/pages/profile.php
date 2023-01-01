<?php include("../php/cookieChecker.php"); ?>
<?php include("../config/db_connect.php"); ?>
<?php include("../php/changePassword.php"); ?>

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
			<?php
				if ($user_type === "Instructor") {
					include("../templates/sideBarInstructor.php");
				} elseif($user_type === "Student") {
					include("../templates/sideBarStudent.php");
				}
			?>
		</div>
		<div class="main_content">
			<div class="header">Welcome <?php print_r($first_name . " " . $last_name); ?>!</div>  
			<div class="info">
				<div>
					<p>Username:</p>
					<p><?php print_r($first_name . " " . $last_name); ?></p>
				</div>
				<div>
					<?php if ($user_type === "Instructor") { ?>
						<p>Current Email:</p>
						<p><?php print_r($email); ?></p>
					<?php } elseif ($user_type === "Student") { ?>
						<div>
						<p>Student Number:</p>
						<p><?php print_r($student_number); ?></p>
						</div>
						<div>
						<p>Department:</p>
						<p><?php print_r($department); ?></p>
						</div>
					<?php } ?>
				</div>
				<form action="profile.php" method="POST">
					<div>
						<label>Change Password:</label>
						<input type="password" class="prof_inputs" name="current_password" placeholder="Current password">
						<input type="password" class="prof_inputs" name="new_password" placeholder="New password">
						<input type="password" class="prof_inputs" name="new_password_confirm" placeholder="Confirm new password">
						<div class="password_change_error"><?php echo $errors["current_password"]; ?></div>
						<div class="password_change_error"><?php echo $errors["new_password"]; ?></div>
						<div class="password_change_error"><?php echo $errors["new_password_confirm"]; ?></div>
						<div class="password_update"><?php echo $password_update; ?></div>
						
						<button type="submit" class="change_password_button" name="change_password" id="change_password">Change Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>