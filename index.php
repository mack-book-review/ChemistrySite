<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "templates/header.php";
include "templates/navbar.php";
?>






<?php

include "classes/Hydrocarbons.php";
include "classes/Alkanes.php";
include "classes/Alkenes.php";

include "classes/ChemRxnRenderer.php";
include "classes/Quizmaker.php";
?>

<?php

if (isset($_GET['page'])) {
	if ($_GET['page'] == "thermochemistry-intro") {

		echo "<div class='container mt-2 mb-2 ml-2'>";

		echo "<h1>Primer on Thermochemistry</h1>";

		echo "</div>";

		include "templates/HydrocarbonIntro.php";
	}

	if ($_GET['page'] == "dynamic-quiz") {

		echo "<div class='container mt-2 mb-2 ml-2'>";

		echo "<h1>Dynamically-Generated Quiz</h1>";

		echo "</div>";

		echo "<div class='container mt-2'>";

		$sample_quiz1 = Quizmaker::Make_Sample_Quiz1();

		echo $sample_quiz1->get_quiz_html_form("index.php");

		echo "</div>";
	}

	if ($_GET['page'] == "db-quiz") {

		echo "<div class='container mt-2 mb-2 ml-2'>";

		echo "<h1>Database-Driven Quiz</h1>";

		echo "</div>";

		echo "<div class='container mt-2'>";

		include "inc/functions.php";
		$questions = get_all_questions();

		foreach ($questions as $question) {
			$id = $question['question_number'];
			$topic = $question['topic'];
			$text = $question['question_text'];
			$answer = $question['correct_answer'];
			echo "<p><b>(" . $id . ")</b> " . $text . "<p>";

			echo "<select name='question" . $topic . $id . "' id='question" . $topic . $id . "'>";

			$choice_A = $question['choice_A'];
			$choice_B = $question['choice_B'];
			$choice_C = $question['choice_C'];
			$choice_D = $question['choice_D'];

			echo "<option value='A'>";
			echo $choice_A;
			echo "</option>";

			echo "<option value='B'>";
			echo $choice_B;
			echo "</option>";

			echo "<option value='C'>";
			echo $choice_C;
			echo "</option>";

			echo "<option value='D'>";
			echo $choice_D;
			echo "</option>";

			if (isset($question['choice_E'])) {
				$choice_E = $question['choice_E'];
				echo "<option value='E'>";
				echo $choice_E;
				echo "</option>";
			}

			echo "</select>";

		}

		echo "<input type='hidden' name='answer_" . $topic . $id . "' value=" . $answer . ">";
		echo "</div>";
	}
}
?>







<?php
include "templates/footer_menu.php";
include "templates/footer.php";
?>