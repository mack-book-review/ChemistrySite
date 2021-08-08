<?php

class ThermoQuestionFactory {
	//To be implemented

	public static function generate_random_questions($number_questions) {

		$questions = array();
		for ($i = 0; $i < $number_questions; $i++) {
			$rand_num = rand(1, 12);

			switch ($rand_num) {
			case 1:
				$question = new ThermoQuestion1(new Alkane(1));
				$questions[] = $question;
				break;
			case 2:
				break;
			case 3:
				break;
			case 4:
				break;
			case 5:
				break;
			case 6:
				break;
			case 7:
				break;
			case 8:
				break;
			case 9:
				break;
			case 10:
				break;
			case 11:
				break;
			case 12:
				break;
			}
		}

		return $questions;
	}

}