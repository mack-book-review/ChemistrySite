<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "templates/header.php";
include "templates/navbar.php";

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

		$quiz_html = Quizmaker::Get_Dynamic_Quiz_HTML_Form(Quizmaker::Get_Sample_Questions(), "index.php");

		echo Quizmaker::Get_Quiz_Container("Dynamically-Generated Quiz", $quiz_html);
	}

	if ($_GET['page'] == "db-quiz") {
		include "inc/functions.php";

		$questions = get_all_questions();

		$quiz_html = Quizmaker::Get_DB_Quiz_Form($questions, "index.php");

		echo Quizmaker::Get_Quiz_Container("Database-Driven Quiz", $quiz_html);

	}
}
?>

<?php
include "templates/footer_menu.php";
include "templates/footer.php";
?>