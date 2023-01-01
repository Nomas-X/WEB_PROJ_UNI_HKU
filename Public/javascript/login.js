/* Defining DOM Interaction points */

let login_type = document.getElementById("login_type");
let login_id_label = document.getElementById("login_id_label");
let login_id_input = document.getElementById("login_id");

/* Defining Functions */

const loginTypeValidate = () => {
	if (login_type.value === "Student") {
		login_id_label.innerHTML = "Student Number:";
		login_id_input.type = "text";
		login_id_input.placeholder ="";
	} else if (login_type.value === "Instructor") {
		login_id_label.innerHTML = "Email:";
		login_id_input.type = "email";
		login_id_input.placeholder ="example@example.come";
	}
}