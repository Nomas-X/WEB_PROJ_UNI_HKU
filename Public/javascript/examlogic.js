"use strict";
// Declerations
let Section_1_A1 = document.querySelector('#Section_1_A1');
let Section_1_A2 = document.querySelector('#Section_1_A2');
let Section_1_A3 = document.querySelector('#Section_1_A3');
let Section_2_A1 = document.getElementsByName('Section_2_A1');
let Section_2_A2 = document.getElementsByName('Section_2_A2');
let Section_2_A3 = document.getElementsByName('Section_2_A3');
let Section_3_A1 = document.getElementsByName('Section_3_A1');
let Section_3_A2 = document.getElementsByName('Section_3_A2');
let Section_3_A3 = document.getElementsByName('Section_3_A3');
let Section_4_A1 = document.querySelectorAll('.Section_4_A1');
let Section_4_A2 = document.querySelectorAll('.Section_4_A2');
let Section_4_A3 = document.querySelectorAll('.Section_4_A3');
let Score_Result = document.querySelector('.Score_Result');
let Submit_Button = document.querySelector('.submit');
let Reset_Button = document.querySelector('.reset');
let Score = 0;
// Functions
const Validate_Section_1 = (Section_1_AX, Correct_Answer) => {
    if (Section_1_AX.value.toUpperCase() === Correct_Answer.toUpperCase()) {
        Score++;
        Section_1_AX.classList.add('Section_123_Border_True');
        Section_1_AX.nextElementSibling.classList.add('Section_1_True');
        Section_1_AX.nextElementSibling.innerHTML = '&#10003 Your answer is correct!';
        return Score;
    }
    else {
        Section_1_AX.classList.add('Section_123_Border_False');
        Section_1_AX.nextElementSibling.classList.add('Section_1_False');
        Section_1_AX.nextElementSibling.innerHTML = `X The correct answer is ${Correct_Answer}`;
    }
};
const Validate_Section_2 = (Section_2_AX) => {
    for (let i = 0; i < Section_2_AX.length; i++) {
        if (Section_2_AX[i].checked && Section_2_AX[i].value === 'True') {
            Score++;
            Section_2_AX[i].parentElement.classList.add('Section_123_Border_True');
            Section_2_AX[i].parentElement.nextElementSibling.innerHTML += " Your answer is correct!";
        }
        else if (Section_2_AX[i].checked && Section_2_AX[i].value === 'False') {
            Section_2_AX[i].parentElement.classList.add('Section_123_Border_False');
            Section_2_AX[i].parentElement.nextElementSibling.innerHTML += " Your answer is incorrect!";
        }
    }
    for (let j = 0; j < Section_2_AX.length; j++) {
        Section_2_AX[j].parentElement.nextElementSibling.classList.remove('Hidden');
    }
    return Score;
};
const Validate_Section_3 = (Section_3_AX, Number_of_Correct_Choices) => {
    let Validator = Number_of_Correct_Choices;
    for (let i = 0; i < Section_3_AX.length; i++) {
        if (Section_3_AX[i].checked && Section_3_AX[i].value === 'True') {
            Validator++;
            Section_3_AX[i].parentElement.classList.add('Section_123_Border_True');
            Section_3_AX[i].parentElement.nextElementSibling.innerHTML += " This answer is correct!";
        }
        else if (Section_3_AX[i].checked && Section_3_AX[i].value === 'False') {
            Validator -= 2;
            Section_3_AX[i].parentElement.classList.add('Section_123_Border_False');
            Section_3_AX[i].parentElement.nextElementSibling.innerHTML += " This answer is incorrect!";
        }
        else if (Section_3_AX[i].checked === false && Section_3_AX[i].value === 'True') {
            Validator -= 2;
            Section_3_AX[i].parentElement.nextElementSibling.innerHTML += " You missed this answer!";
        }
    }
    if (Validator > Number_of_Correct_Choices) {
        Score++;
    }
    for (let j = 0; j < Section_3_AX.length; j++) {
        Section_3_AX[j].parentElement.nextElementSibling.classList.remove('Hidden');
    }
    return Score;
};
const Validate_Section_4 = (Section_4_AX) => {
    if (Section_4_AX[0].classList.contains('Sticky_Button') && Section_4_AX[0].classList.contains('True_Answer')) {
        Score++;
        Section_4_AX[0].classList.add('Section_4_True');
        Section_4_AX[1].classList.add('Section_4_False');
    }
    else if (Section_4_AX[1].classList.contains('Sticky_Button') && Section_4_AX[1].classList.contains('True_Answer')) {
        Score++;
        Section_4_AX[1].classList.add('Section_4_True');
        Section_4_AX[0].classList.add('Section_4_False');
    }
    else if (Section_4_AX[0].classList.contains('Sticky_Button') && Section_4_AX[0].classList.contains('False_Answer')) {
        Section_4_AX[0].classList.add('Section_4_False');
        Section_4_AX[1].classList.add('Section_4_True');
    }
    else if (Section_4_AX[1].classList.contains('Sticky_Button') && Section_4_AX[1].classList.contains('False_Answer')) {
        Section_4_AX[1].classList.add('Section_4_False');
        Section_4_AX[0].classList.add('Section_4_True');
    }
    else if (Section_4_AX[0].classList.contains('True_Answer')) {
        Section_4_AX[0].classList.add('Section_4_True');
        Section_4_AX[1].classList.add('Section_4_False');
    }
    else {
        Section_4_AX[1].classList.add('Section_4_True');
        Section_4_AX[0].classList.add('Section_4_False');
    }
    return Score;
};
const Sticky_Buttons = (Section_4_AX) => {
    Section_4_AX[0].addEventListener('click', (e) => {
        if (Section_4_AX[1].classList.contains('Sticky_Button')) {
            Section_4_AX[1].classList.remove('Sticky_Button');
            Section_4_AX[0].classList.add('Sticky_Button');
            Section_4_AX[0].value = '> Yes <';
            Section_4_AX[1].value = 'No';
        }
        else if (Section_4_AX[0].classList.contains('Sticky_Button')) {
            Section_4_AX[0].classList.remove('Sticky_Button');
            Section_4_AX[0].value = 'Yes';
        }
        else {
            Section_4_AX[0].classList.add('Sticky_Button');
            Section_4_AX[0].value = '> Yes <';
        }
    });
    Section_4_AX[1].addEventListener('click', (e) => {
        if (Section_4_AX[0].classList.contains('Sticky_Button')) {
            Section_4_AX[0].classList.remove('Sticky_Button');
            Section_4_AX[1].classList.add('Sticky_Button');
            Section_4_AX[1].value = '> No <';
            Section_4_AX[0].value = 'Yes';
        }
        else if (Section_4_AX[1].classList.contains('Sticky_Button')) {
            Section_4_AX[1].classList.remove('Sticky_Button');
            Section_4_AX[1].value = 'No';
        }
        else {
            Section_4_AX[1].classList.add('Sticky_Button');
            Section_4_AX[1].value = '> No <';
        }
    });
};
const Disable_Inputs = (Section_X_AX) => {
    for (let i = 0; i < Section_X_AX.length; i++) {
        Section_X_AX[i].disabled = true;
    }
};
// Sticky Buttons
Sticky_Buttons(Section_4_A1);
Sticky_Buttons(Section_4_A2);
Sticky_Buttons(Section_4_A3);
// Submission & Reset
Submit_Button.addEventListener('click', (e) => {
    e.preventDefault();
    // Validation of Section 1 answers
    Validate_Section_1(Section_1_A1, "1939");
    Validate_Section_1(Section_1_A2, "Adolf Hitler");
    Validate_Section_1(Section_1_A3, "KMS-Bismarck");
    // Validation o	f Section 2 answers
    Validate_Section_2(Section_2_A1);
    Validate_Section_2(Section_2_A2);
    Validate_Section_2(Section_2_A3);
    // Validation of Section 3 answers
    Validate_Section_3(Section_3_A1, 3);
    Validate_Section_3(Section_3_A2, 2);
    Validate_Section_3(Section_3_A3, 1);
    // Validation of Section 4 answers
    Validate_Section_4(Section_4_A1);
    Validate_Section_4(Section_4_A2);
    Validate_Section_4(Section_4_A3);
    // Disabling inputs
    Section_1_A1.disabled = true;
    Section_1_A2.disabled = true;
    Section_1_A3.disabled = true;
    Disable_Inputs(Section_2_A1);
    Disable_Inputs(Section_2_A2);
    Disable_Inputs(Section_2_A3);
    Disable_Inputs(Section_3_A1);
    Disable_Inputs(Section_3_A2);
    Disable_Inputs(Section_3_A1);
    Disable_Inputs(Section_3_A3);
    Disable_Inputs(Section_4_A1);
    Disable_Inputs(Section_4_A2);
    Disable_Inputs(Section_4_A3);
    Submit_Button.disabled = true;
    Submit_Button.classList.add('Submit_Button_Disabled');
    Submit_Button.classList.add('Sticky_Button');
    // Outputting results
    let Percentage_Result = Score * 100 / 12;
    Percentage_Result.toFixed(1);
    Score_Result.innerHTML += Score + "/12" + ' or ' + parseFloat(Percentage_Result).toFixed(1) + "%";
});
Reset_Button.addEventListener('click', (e) => {
    window.location.reload();
});
