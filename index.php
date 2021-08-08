<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "templates/header.php";
include "navbar.php";
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
}
?>







<?php
include "templates/footer_menu.php";
include "templates/footer.php";
?>