<?php

//Get the html for displaying a QuizQuestion object in an HTML form

class QuestionTemplate {

	private QuizQuestion $quiz_question;

	function __construct($u_quiz_question) {
		$this->quiz_question = $u_quiz_question;
	}

	public function get_question_html() {

		$html = "<p><b>(" . $this->quiz_question->get_question_id() . ")</b>  ";

		$html .= $this->quiz_question->get_question_text();

		$html .= "<p>";

		$html .= "Choose answer:  ";

		$html .= '<select name="' . $this->quiz_question->get_question_id() . '" id=question"' . $this->quiz_question->get_question_id() . '">';

		foreach ($this->quiz_question->get_choices() as $letter => $choice_text) {

			$html .= '<option value="' . $letter . '">';
			$html .= $choice_text;
			$html .= "</option>";
			$html .= "<br>";

		}

		$html .= '</select>';

		$html .= '<input type="hidden" name="' . "answer" . $this->quiz_question->get_question_id() . '" value="' . $this->quiz_question->get_correct_choice() . '">';

		return $html;
	}
}