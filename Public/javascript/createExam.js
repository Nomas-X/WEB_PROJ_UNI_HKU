/* Defining DOM Interaction points */
let add_question_button = document.getElementById("add_question");
let questions_container = document.getElementById("questions_container");
let submit_button = document.getElementById("create_exam");
let question_type = document.getElementById("question_type");

/* Defining variables */

const number_of_answers = 4;
let question_counter = 0;

/* Defining Functions */

// Handles how the button looks like if the user does not select a question type.
const validateQuestionType = () => {
	if (question_type.value !== "0") {
		add_question_button.classList.add("add_question_active");
		add_question_button.classList.remove("add_question_inactive");
	} else {
		add_question_button.classList.remove("add_question_active");
		add_question_button.classList.add("add_question_inactive");
	}
}

// Function called by the remove button to delete a question and all its elements
const removeQuestion = (question) => {
	question.parentElement.remove();
}

// Function called on question creation to add the delete button
const addRemoveButton =  (question) => {
	let remove_question_button = document.createElement("a");
	remove_question_button.classList.add("delete_question_button");
	remove_question_button.innerHTML = "<i class=\"fas fa-solid fa-trash question_delete_icon\"></i> Delete Question";
	question.appendChild(remove_question_button);
	remove_question_button.addEventListener("click", () => {
		removeQuestion(remove_question_button);
	});
}

// Function called on question creation to add question field
const createQuestionFields = (question, type) => {
	let question_label = document.createElement("label");
	question.classList.add(type);
	question_label.innerHTML = `Quesetion of type (${type.replaceAll("_", " ").toUpperCase()})`;
	question.appendChild(question_label);
	question.insertBefore(question_label, question.children[0]);
	question_counter += 1;
	
	if (type === "single_choice" || type === "multiple_choices" || type === "order_answers") {
		for (let i = 0; i < number_of_answers; i += 1) {
			let answer_field = document.createElement("input");
			
			answer_field.classList.add("new_question_answers_inputs");
			answer_field.placeholder = `Option ${i + 1}`
			question.appendChild(answer_field);

		}

		for (let i = 0; i < number_of_answers; i += 1) {
			let correct_option_selector = document.createElement('input');
			let answer_label = document.createElement("label");
		
			answer_label.classList.add("answer_label");
			answer_label.innerHTML = `Option ${i + 1}`;
			question.appendChild(answer_label);
		
			if (type === "single_choice") {
				correct_option_selector.type = "radio";
				correct_option_selector.name = `Question_id_${question_counter + 1}`;
				correct_option_selector.classList.add("correct_answer_radio");
			} else if (type === "multiple_choices") {
				correct_option_selector.type = "checkbox";
				correct_option_selector.classList.add("correct_answer_checkbox");
			} else if (type === "order_answers") {
				correct_option_selector.type = "text";
				correct_option_selector.classList.add("correct_answer_order");
			}
			question.appendChild(correct_option_selector);
		}

	} else if (type === "fill_blank") {
		let answer_field = document.createElement("input");
				
		answer_field.classList.add("new_question_answers_inputs");
		answer_field.placeholder = "Correct Answer";
		question.appendChild(answer_field);
	}
}

// Function to handle the creation of the question and answers fields and elements.
const createNewQuestion = (type) => {
	if (type !== "0") {
		let new_question = document.createElement("div");
	
		new_question.innerHTML = "<input type=\"text\" class=\"new_question_inputs\" placeholder=\"Enter the question\"></input>";
		questions_container.appendChild(new_question);
		questions_container.insertBefore(new_question, submit_button.parentElement);
	
		if (type === "single_choice") {
			createQuestionFields(new_question, type);
			addRemoveButton(new_question);
	
			let correct_options = document.createElement("p");
	
			correct_options.innerHTML = "Select the correct answer:";
			correct_options.classList = "correct_option_p";
			new_question.appendChild(correct_options);
			new_question.insertBefore(correct_options, new_question.children[number_of_answers + 2]);


		} else if (type === "multiple_choices") {
			createQuestionFields(new_question, type);
	
			let correct_options = document.createElement("p");
	
			correct_options.innerHTML = "Select the correct answers:";
			correct_options.classList = "correct_option_p";
			new_question.appendChild(correct_options);

			addRemoveButton(new_question);

		} else if (type === "order_answers") {
			createQuestionFields(new_question, type);
	
			let correct_order = document.createElement("p");
	
			correct_order.innerHTML = "Enter the correct order:";
			correct_order.classList = "correct_order_p";
			new_question.appendChild(correct_order);

			addRemoveButton(new_question);

		} else if (type === "fill_blank") {
			createQuestionFields(new_question, type);
			

			addRemoveButton(new_question);

		} else if (type === "essay") {
			createQuestionFields(new_question, type);
			addRemoveButton(new_question);
		}
	
		let question_seperator = document.createElement("hr");
		question_seperator.classList.add("questions_seperator");
		new_question.appendChild(question_seperator);
	}
}

/* Other */

add_question_button.addEventListener("click", () => {
	createNewQuestion(question_type.value);
});

