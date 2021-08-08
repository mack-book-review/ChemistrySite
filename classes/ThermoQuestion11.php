<?php

include "ErrorGenerator11.php";
include "GasCalculator.php";

class ThermoQuestion11 extends QuizQuestion {

	//pressure is given in atm
	private float $pressure_initial;
	private float $pressure_final;

	//tempreature is given in celsius and therefore must be converted to Kevlin for some forms of the ideal gas equation
	private float $temperature;
	private float $number_moles;

	public function get_temperature() {
		return $this->temperature;
	}

	public function get_pressure_initial() {
		return $this->pressure_initial;
	}

	public function get_pressure_final() {
		return $this->pressure_final;
	}

	public function get_number_moles() {
		return $this->number_moles;
	}

	public function __construct() {

		$this->randomize_conditions();
		$this->error_generator = new ErrorGenerator11($this->pressure_initial, $this->pressure_final, $this->number_moles, $this->temperature);

		parent::__construct("../img/figure_7-8.png");
	}

	public function get_question_text() {

		$html = "Suppose the gas in the picture below is " . number_format($this->number_moles, 1) . " mol of He at " . (number_format($this->temperature + 273, 1)) . " K, the two weights correspond to an external pressure of " . number_format($this->pressure_initial, 1) . " atm in Figure (a), and the single weight in Figure (b) corresponds to an external pressure of " . number_format($this->pressure_final, 1) . " atm.  How much work, in joules, is associated with the gas expansion at constant temperature?";

		$html .= "<img src='" . $this->img_path . "' id='question" . $this->get_question_id() . "' style='display:block;width:30em;height:auto;margin-bottom:2em;'>";

		$html .= "<br>";

		return $html;
	}

	private function randomize_conditions() {
		$this->pressure_final = rand(1, 2);
		$this->pressure_initial = rand(2, 4);
		$this->temperature = rand(15, 35);
		$this->number_moles = rand(0, 1) + 0.1;
	}

	private function get_vol_initial() {
		return GasCalculator::Get_Volume_Of_Gas($this->pressure_initial, $this->temperature + 273, $this->number_moles);
	}

	private function get_vol_final() {
		return GasCalculator::Get_Volume_Of_Gas($this->pressure_final, $this->temperature + 273, $this->number_moles);
	}

	private function get_change_in_vol() {
		return $this->get_vol_final() - $this->get_vol_initial();
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			number_format(-$this->error_generator->get_err1(), 2) . " J",
			number_format(-$this->error_generator->get_err2(), 2) . " J",
			number_format(-$this->error_generator->get_err3(), 2) . " J",
			number_format(-$this->error_generator->get_err4(), 2) . " J",

		];
	}

	public function get_correct_answer_numerical() {
		return $this->pressure_final * $this->get_change_in_vol();
	}

	public function get_correct_answer() {
		$correct_answer = -$this->pressure_final * $this->get_change_in_vol();
		return strval(number_format($correct_answer, 2)) . " " . " J";
	}
}