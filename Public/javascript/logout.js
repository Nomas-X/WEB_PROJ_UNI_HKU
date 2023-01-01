/* Defining DOM Interaction points */

let logout_button = document.getElementById("logout");

/* Defining Functions */

// Function called when the user clicks on the logout <a> tag in the side bar to remove all cookies and log them out.
const logout = () => {
	document.cookie = "first_name = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "last_name = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "logged_in = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "user_type = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "student_number = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "email = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
	document.cookie = "courses = ; expires = Thu, 01 Jan 1970 00:00:00 GMT;"
}

/* Other */

logout_button.addEventListener("click", () => {
	logout()
});