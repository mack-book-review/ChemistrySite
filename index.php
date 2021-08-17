<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "templates/header.php";
include "templates/navbar.php";
include "classes/Quizmaker.php";
?>

<?php

if (isset($_GET['page'])) {
	if ($_GET['page'] == "thermochemistry-intro") {

		echo "<h1 style='margin-left:0.5em;margin-top:0.5em;'>Some Thermochemistry Basics</h1>";

		include "templates/HydrocarbonIntro.php";
	}

	if ($_GET['page'] == "dynamic-quiz") {

		$quiz_html = Quizmaker::Get_Dynamic_Quiz_HTML_Form(Quizmaker::Get_Sample_Questions(), "inc/process_answers.php");

		echo Quizmaker::Get_Quiz_Container("Dynamically-Generated Quiz", $quiz_html);

		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

	}

	if ($_GET['page'] == "db-quiz") {
		include "inc/functions.php";

		$questions = get_all_questions();

		$quiz_html = Quizmaker::Get_DB_Quiz_Form($questions, "inc/process_answers.php");

		echo Quizmaker::Get_Quiz_Container("Database-Driven Quiz", $quiz_html);

		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";

	}
}
?>


<?php
include "templates/footer_menu.php";
include "templates/footer.php";
?>





