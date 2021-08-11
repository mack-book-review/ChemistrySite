<?php

include "../templates/header.php";

if (isset($_POST['submit'])) {

	echo "<div class='container mt-2 mb-4'>";
	echo "<h1>Quiz Results</h1>";
	echo "</div>";

	$i = 1;
	$number_correct = 0;

	while (!empty($_POST['question' . $i])) {

		$user_answer = $_POST['question' . $i];
		$correct_answer = $_POST['answer' . $i];
		$answer_choice_explanation = $_POST['answer_choice_explanation' . $i];

		if ($user_answer == $correct_answer) {
			$number_correct++;

			echo "<div class='container mt-2 mb-2'>";
			echo "<div class='alert alert-success' role='alert'>";
			echo "<h4 class='alert-heading'>Question " . $i . "</h4>";
			echo "<p>Correct Answer: " . $correct_answer . " </p>";
			echo "<p>User Answer: " . $user_answer . " </p>";
			echo "<hr>";

			echo "<p class='mb-0'>Answer Choice Explanation</p>";
			echo "</div>";
			echo "</div>";

		} else {
			echo "<div class='container'>";

			echo "<div class='alert alert-danger' role='alert'>";
			echo "<h4 class='alert-heading'>Question " . $i . "</h4>";
			echo "<p>Correct Answer: " . $correct_answer . " </p>";
			echo "<p>User Answer: " . $user_answer . " </p>";
			echo "<hr>";

			echo "<p class='mb-0'>" . $answer_choice_explanation . "</p>";
			echo "</div>";
			echo "</div>";

		}

		$i++;

		echo "<hr>";
	}

	echo "<div class='container mt-2 mb-2'>";

	echo "<div class='alert alert-warning' role='alert'>";
	echo "<h4 class='alert-heading'>Final Score</h4>";
	echo "<hr>";

	echo "<p>You answered: " . number_format(100 * ($number_correct / ($i - 1)), 2) . "% Correct </p>";

	echo "</div>";
	echo "</div>";

} else {
	echo "<h1>You must answer all questions.</h1>";
	header("Location: ../index.php");
}