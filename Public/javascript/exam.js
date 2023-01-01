/* Defining variables */
let number_of_answers = 4;

/* Defining functions */

// Function called on change of checkbox status to set values of checkboxes to the user's answer so the answer can be read by PHP.
const setCheckboxAnswer = (checkboxes_name) => {
	let answer = "";
	let checkboxes = document.getElementsByName(checkboxes_name);

	for (let i = 0; i < number_of_answers; i++) {
		if (checkboxes[i].checked) {
			answer += `${i + 1}` + ",";
		}
	}

	checkboxes.forEach((checkbox) => {
		checkbox.value = answer;
	});
}