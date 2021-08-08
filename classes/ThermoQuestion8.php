<?php

//Ice Calorimetry Problem
class ThermoQuestion8 {

	private float $temperature;
	private float $volume;
	private float $pressure;

	private ErrorGenerator8 $error_generator;

	public function __construct($gas_mixture) {

		$this->error_generator = new ErrorGenerator7($gas_mixture);

		$this->choices = [
			"A" => null,
			"B" => null,
			"C" => null,
			"D" => null,
		];

		$this->generate_choices();
	}

	public function get_question_text() {
		$html = "<p>A particular gas mixtures consists, in mole percents, of " . $this->gas_mixture . ".  A " . $this->gas_mixture->get_volume_liters() . " L sample of this gas, measured at " . $this->gas_mixture->get_temperature_celsius() . "&deg;C and " . $this->gas_mixture->get_pressure_mmHg() . " mmHg, is burned at constant pressure in an excess of oxygen gas. How much heat, in kilojoules, is evolved in a combustion reaction?</p><br>";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [];
	}

	public function get_correct_answer() {
		$correct_answer = $this->gas_mixture->get_total_heat_of_combustion();
		return strval(round($correct_answer, 2)) . " " . "kJ";
	}

}