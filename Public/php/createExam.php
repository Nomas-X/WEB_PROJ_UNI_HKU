<?php
	$std_f_name = $std_l_name = $std_number = $std_password = $std_department = "";
	$errors = ["std_f_name" => "", "std_l_name" => "", "std_number" => "", "std_password" => "", "std_department" => ""];

	if (isset($_POST["create_exam"])) {
		print_r($_POST);
	}
?>