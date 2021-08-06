<?php

//Should be able to generate randomized choices along with erroneous answers
abstract class QuizQuestion {

	abstract public function get_question_text();
	abstract public function get_correct_choice();
	abstract public function get_choices();

}