<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>


	<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "data.php";
include "functions.php";

?>


<?php

if (!isset($_GET['topic'])) {
	echo '<h1>Choose a topic from the list below:</h1>';
}
?>

<form method="get" action="form1.php">
	<select name="topic" id="topic">
		<option value="matter-properties-measurement">Matter: Its Properties and Measurement</option>
		<option value="atoms-atomic-theory">Atoms and the Atomic Theory</option>
		<option value="chemical-compounds">Chemical Compounds</option>
		<option value="chemical-reactions">Chemical Reactions</option>
		<option value="intro-reactions-aqueous-solutions">
			Introduction to Reactions in Aqueous Solutions
		</option>
		<option value="gases">Gases</option>
		<option value="thermochemistry">Thermochemistry</option>
	</select>

	<br>
	<br>
	<input type="submit">
</form>


<?php

if (!isset($_GET['topic']) && !isset($_POST['topic'])) {
	exit;
} else {

}

?>


<?php

if (isset($_POST["user_answer1"])) {

	display_results();
} else {

	echo "<h1>Take the Quiz</h1>";

	$topic = $_GET['topic'];

	if ($topic == "thermochemistry") {
		echo "Making thermochem quiz...";

		include "classes/Quizmaker.php";

		$quizmaker = Quizmaker::Make_Sample_Quiz1();
		echo $quizmaker->get_quiz_html_form("form1.php");
	} else {

		$topic_questions = get_questions_for_topic($topic, $all_questions);

		if (!empty($topic_questions)) {

			echo '<form method="post" action="form1.php">';

			foreach ($topic_questions as $question) {
				display_question($question);
			}

			echo '<input type="hidden" name="topic" value="' . $topic . '">';
			echo '<input type="submit">';

			echo '</form>';

		} else {
			echo "<h2>No questions for that topic</h2>";
		}

	}

}

?>








</body>
</html>