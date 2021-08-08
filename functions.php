<?php

function get_questions_for_topic() {

}

function display_results() {
	$count = 1;
	$number_correct = 0;
	while (!empty($_POST["user_answer" . $count])) {

		$user_answer = $_POST["user_answer" . $count];

		echo "Question " . $count . ":  ";

		if ($user_answer == $_POST["correct_answer" . $count]) {
			echo "Correct";
			$number_correct += 1;
		} else {
			echo "Wrong Answer";
		}

		echo "<br>";

		$count += 1;
	}

	if ($count > 0) {
		echo "Percentage Correct: " . 100 * $number_correct / ($count - 1) . "%";
	}

}
function display_question($question) {

	echo "<p>";
	echo "<b>(" . $question["question_number"] . ")</b>     ";

	echo $question["question_text"];
	echo "</p>";

	echo "<br>";

	if (isset($question["img"])) {
		echo "<img src='" . $question["img"] . "'>";
		echo "<br>";
	}

	echo "<label for='user_answer'>Choose the correct answer:     </label>";

	echo "<select name='user_answer" . $question["question_number"] . "'" . " id='user_answer'>";

	echo "<option value='A'>" . $question["answer_choices"]['A'] . "</option>";
	echo "<option value='B'>" . $question["answer_choices"]['B'] . "</option>";
	echo "<option value='C'>" . $question["answer_choices"]['C'] . "</option>";
	echo "<option value='D'>" . $question["answer_choices"]['D'] . "</option>";

	if (isset($question["answer_choices"]['E'])) {
		echo "<option value='E'>" . $question["answer_choices"]['E'] . "</option>";
	}

	echo "</select>";

	echo "<br>";
	echo "<br>";

	echo "<input type='hidden' name='correct_answer" . $question["question_number"] . "' value='" . $question["correct_answer"] . "'>";

}

?>