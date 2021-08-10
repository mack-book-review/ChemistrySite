<?php

include "GasMixture.php";
include "ErrorGenerator7.php";

class Thermoquestion7 extends QuizQuestion {

	private $gas_mixture;

	public function __construct($gas_mixture = null) {

		if ($gas_mixture == null) {
			$this->gas_mixture = new GasMixture();
		} else {
			$this->gas_mixture = $gas_mixture;
		}

		$this->error_generator = new ErrorGenerator7();

		parent::__construct();
	}

	public function get_question_text() {

		$html = "A particular gas mixtures consists, in mole percents, of " . $this->gas_mixture . ".  A " . number_format($this->gas_mixture->get_volume_liters(), 1) . " L sample of this gas, measured at " . number_format($this->gas_mixture->get_temperature_celsius(), 1) . "&deg;C and " . number_format($this->gas_mixture->get_pressure_mmHg(), 1) . " mmHg, is burned at constant pressure in an excess of oxygen gas. How much heat, in kilojoules, is evolved in a combustion reaction?";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			number_format(0.5 * $this->get_correct_answer_numerical(), 1) . " kJ",
			number_format(1.5 * $this->get_correct_answer_numerical(), 1) . " kJ",
			number_format(0.8 * $this->get_correct_answer_numerical(), 1) . " kJ",
			number_format(1.2 * $this->get_correct_answer_numerical(), 1) . " kJ",

		];
	}

	public function get_correct_answer_numerical() {
		return $this->gas_mixture->get_total_heat_of_combustion();
	}

	public function get_correct_answer() {
		$correct_answer = $this->get_correct_answer_numerical();

		return strval(round($correct_answer, 2)) . " " . "kJ";
	}
}