<?php include("../config/db_connect.php"); ?>
<?php include("../php/loginHandler.php"); ?>

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
			<h2>Xero Exams</h2>
		</div>
		<div class="main_content">
			<div class="header"	>Welcome to Xero Exams, login to continue!</div>  
			<div class="info center">
				<form action="login.php" method="POST">
					<div class="login_error"><?php echo $errors["login_wrong"]; ?></div>
					<div>
						<label class="login_labels">Student or Instructor:</label>
						<select name="login_type" id="login_type" class="login_inputs" onchange="loginTypeValidate()" required>
							<option disabled disabled selected></option>
							<option value="Student">Student</option>
							<option value="Instructor">Instructor</option>
						</select>
						<div class="login_error"><?php echo $errors["login_type"]; ?></div>
					</div>
					<div>
						<label class="login_labels" id="login_id_label">Student Number:</label><input type="text" class="login_inputs" id="login_id" name="login_id" value="<?php echo htmlspecialchars($login_id); ?>" required>
						<div class="login_error"><?php echo $errors["login_id"]; ?></div>
					</div>
					<div>
						<label class="login_labels">Password:</label><input type="password" class="login_inputs" name="login_password" value="<?php echo htmlspecialchars($login_password); ?>" required>
						<div class="login_error"><?php echo $errors["login_password"]; ?></div>
					</div>
					<button class="login_button" id="login_button" name="login_submit" type="submit">Login</button>
				</form>
		  </div>
		</div>
	</div>
	<script src="../javascript/login.js"></script>
</body>
</html>