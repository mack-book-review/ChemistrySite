<?php

include "QuizQuestion.php";
include "ThermoQuestion1.php";
include "ThermoQuestion2.php";
include "ThermoQuestion3.php";
include "ThermoQuestion11.php";

include "QuestionTemplate.php";

class Quizmaker {

	public static function Make_Sample_Quiz1() {
		return new Quizmaker([
			new ThermoQuestion1(new Alkane(4)),
			new ThermoQuestion2(new Alkane(2)),
			new ThermoQuestion3(new Alkane(3)),
			new ThermoQuestion2(new Alkane(4)),
			new ThermoQuestion3(new Alkane(5)),
			new ThermoQuestion2(new Alkane(6)),
			new ThermoQuestion11(),
		]);
	}
	//Array of QuizQuestions (i.e. ThermoQuestion1, ThermoQuestion2, ThermoQuestion3, etc.)
	private array $quiz_questions;

	function __construct($some_quiz_questions) {
		$this->quiz_questions = $some_quiz_questions;

		shuffle($this->quiz_questions);

	}

	public function get_quiz_html_form($action_page) {

		$html = "<form method='post' action='" . $action_page . "'>";

		foreach ($this->quiz_questions as $quiz_question) {
			$question_template = new QuestionTemplate($quiz_question);

			$html .= $question_template->get_question_html();

			$html .= "<hr>";
		}

		$html .= "<br>";
		$html .= "<br>";

		$html .= "<input type='submit'>";

		$html .= "</form>";

		return $html;
	}
}
