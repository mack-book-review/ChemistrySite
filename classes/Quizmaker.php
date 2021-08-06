<?php

class Quizmaker {
	//Array of QuizQuestions (i.e. ThermoQuestion1, ThermoQuestion2, ThermoQuestion3, etc.)
	private $quiz_questions = [];

	function __construct($some_quiz_questions) {
		$this->quiz_questions = $some_quiz_questions;
	}

	public function get_quiz_html_form() {

	}
}
