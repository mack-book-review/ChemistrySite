<?php

include "QuizQuestion.php";
include "ThermoQuestion1.php";
include "ThermoQuestion2.php";
include "ThermoQuestion3.php";
include "ThermoQuestion4.php";
include "ThermoQuestion5.php";
include "ThermoQuestion7.php";
include "ThermoQuestion8.php";
include "ThermoQuestion9.php";
include "ThermoQuestion10.php";
include "ThermoQuestion11.php";
include "ThermoQuestion12.php";

include "QuestionTemplate.php";

class Quizmaker {

	public static function Get_Sample_Questions() {
		return [
			new ThermoQuestion1(new Alkane(4)),
			new ThermoQuestion2(new Alkane(2)),
			new ThermoQuestion3(new Alkane(3)),
			new ThermoQuestion11(),
			new ThermoQuestion4(),
			new ThermoQuestion7(),
			new ThermoQuestion8(new Alkane(4)),
			new ThermoQuestion8(new Alkane(6)),
			new ThermoQuestion9(new Alkane(5)),
			new ThermoQuestion9(new Alkane(4)),
			new ThermoQuestion10(new Alkane(4)),
			new ThermoQuestion5(
				new Solution(25.00, 0.100, "HCl"),
				new Solution(30.000, 0.5, "NaOH"), -103.4),

		];
	}

	//Array of QuizQuestions (i.e. ThermoQuestion1, ThermoQuestion2, ThermoQuestion3, etc.)
	private array $quiz_questions;

	function __construct($some_quiz_questions = null) {

		$this->quiz_questions = $some_quiz_questions;

		shuffle($this->quiz_questions);

	}

	public function get_quiz_html_form($action_page) {
		return Quizmaker::Get_Dynamic_Quiz_HTML_Form($this->quiz_questions, $action_page);
	}

	public static function Get_DB_Quiz_Form($questions, $action_page) {

		$html = "<form method='post' action='" . $action_page . "'>";

		foreach ($questions as $question) {
			$html .= Quizmaker::Get_DB_Quiz_Question_HTML($question);
		}

		$html .= "<br>";
		$html .= "<br>";

		$html .= "<button type='submit' class='btn btn-primary' name='submit' value='submit'>Submit</button>";

		$html .= "</form>";

		return $html;
	}

	public static function Get_DB_Quiz_Question_HTML($question) {
		$id = $question['question_number'];
		$topic = $question['topic'];
		$text = $question['question_text'];
		$answer = $question['correct_answer'];

		$html = "<p><b>(" . $id . ")</b> " . $text . "<p>";

		$html .= "<select name='question" . $id . "' id='question" . $topic . $id . "'>";

		$choice_A = $question['choice_A'];
		$choice_B = $question['choice_B'];
		$choice_C = $question['choice_C'];
		$choice_D = $question['choice_D'];

		$html .= "<option value='A'>";
		$html .= $choice_A;
		$html .= "</option>";

		$html .= "<option value='B'>";
		$html .= $choice_B;
		$html .= "</option>";

		$html .= "<option value='C'>";
		$html .= $choice_C;
		$html .= "</option>";

		$html .= "<option value='D'>";
		$html .= $choice_D;
		$html .= "</option>";

		if (isset($question['choice_E'])) {
			$choice_E = $question['choice_E'];
			$html .= "<option value='E'>";
			$html .= $choice_E;
			$html .= "</option>";
		}

		$html .= "</select>";

		$html .= "<input type='hidden' name='answer" . $id . "' value=" . $answer . ">";

		return $html;
	}

	public static function Get_Dynamic_Quiz_HTML_Form($quiz_questions, $action_page) {

		$html = "<form method='post' action='" . $action_page . "'>";

		$i = 1;

		foreach ($quiz_questions as $quiz_question) {
			$question_template = new QuestionTemplate($quiz_question);

			$html .= $question_template->get_question_html($i);

			$html .= "<hr>";

			$i++;
		}

		$html .= "<button type='submit' class='btn btn-primary' name='submit' value='submit'>Submit</button>";

		$html .= "</form>";

		return $html;
	}

	public static function Get_Quiz_Container($title, $quiz_html) {

		$html = "<div class='container mt-2 mb-2 ml-2'>";

		$html .= "<h1>" . $title . "</h1>";

		$html .= "</div>";

		$html .= "<div class='container mt-2'>";

		$html .= $quiz_html;

		$html .= "</div>";

		return $html;

	}
}
