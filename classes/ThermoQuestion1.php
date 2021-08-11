<?php

include "ThermoQuestionMaker.php";

/** Responsible for generate question of a specific type: asks user for the amount of hydrocarbon (in g) that must be combusted in order to raise the temperature of a given amount of water from a given starting temp to a given final temp**/

class ThermoQuestion1 extends QuizQuestion {

	private $question_maker;
	private $hydrocarbon;
	private $vol_water_ml;
	private $start_temp;
	private $end_temp;

	public function __construct($u_hydrocarbon) {
		//randomly set $start_temp and $end_temp
		//randomly set $vol water in ml
		$this->set_question_id();
		$this->hydrocarbon = $u_hydrocarbon;
		$this->randomize_private_vars();

		parent::__construct();

		$this->set_answer_choice_explanation("For ThermoQuestion #1, You have to do some complex calculation in order to get this.");
	}

	public function get_question_id() {
		return $this->question_id;
	}

	private function set_question_id() {
		$this->question_id = rand(1000, 9999);
	}

	private function randomize_private_vars() {
		$rand_start_temp = rand(10, 50);
		$rand_end_temp = rand($rand_start_temp, $rand_start_temp + 50);
		$this->start_temp = number_format((float) $rand_start_temp, 1);
		$this->end_temp = number_format((float) $rand_end_temp, 1);
		$this->vol_water_ml = rand(10, 5000);
	}

	public function get_question_text() {
		return "What mass of " . $this->hydrocarbon . " (in g) must be combusted in order to raise the temperature of " . number_format($this->vol_water_ml, 1) . " ml water from " . number_format($this->start_temp, 1) . " &deg;C to " . number_format($this->end_temp, 1) . " &deg;C?";
	}

	public function get_correct_answer_numerical() {

		$heat_needed_joules = $this->vol_water_ml * ($this->end_temp - $this->start_temp) * 4.18;

		$moles_substance = abs(($heat_needed_joules / 1000) / $this->hydrocarbon->get_standard_enthalpy_of_combustion());

		$grams_substance = $moles_substance * $this->hydrocarbon->get_molar_mass();

		return $grams_substance;
	}

	public function get_correct_answer() {

		$correct_answer = $this->get_correct_answer_numerical();

		return number_format($correct_answer, 1) . " g";
	}

	protected function get_erroneous_answers() {

		return [
			number_format(1.5 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(0.5 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(0.3 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(1.8 * $this->get_correct_answer_numerical(), 1) . " g"];

	}

}