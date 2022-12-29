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
			<div class="header">Welcome!! [Insert Name]!</div>  
			<div class="info">
				<div><p>Username:</p><p>someUserName</p></div>
				<div><p>Current Email:</p><p>some.email@email.com</p></div>
				<form action="#">
					<div>
						<label>Change Password: </label><input type="password" class="prof_inputs"><button class="change_button" id="change_password">Change Password</button>
					</div>
				</form>
		  </div>
		</div>
	</div>
</body>
</html>