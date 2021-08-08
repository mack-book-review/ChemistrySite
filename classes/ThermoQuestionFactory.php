<?php

class ThermoQuestionFactory {
	//To be implemented

	public static function generate_random_alkane_questions($number_questions) {

		$questions = array();
		for ($i = 0; $i < $number_questions; $i++) {
			$rand_num_carbons = rand(1, 10);
			$rand_alkane = new Alkane($rand_num_carbons);
			//Not finished
		}
	}

}