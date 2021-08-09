<?php

include "ErrorGenerator8.php";

class ThermoQuestion8 extends QuizQuestion {

	static private float $HEAT_OF_FUSION_ICE = 6.01;
	static private float $MOLAR_MASS_WATER = 18.01;

	private float $temperature;
	private float $volume;
	private float $pressure;
	private Hydrocarbon $hydrocarbon;

	public function __construct($hydrocarbon) {
		$this->hydrocarbon = $hydrocarbon;
		$this->randomize_conditions();
		$this->error_generator = new ErrorGenerator8();

		parent::__construct();

	}

	private function randomize_conditions() {
		$this->temperature = rand(20, 40);
		$this->pressure = rand(600, 900);
		$this->volume = rand(100, 900) / 1000;
	}

	public function get_question_text() {
		$html = "A calorimeter that measure an exothermic heat of reaction by the quantity of ice that can be melted is called an ice calorimeter.  Now consider that " . number_format($this->volume, 1) . " L of " . $this->hydrocarbon->get_common_name() . " gas, " . $this->hydrocarbon . ", at " . number_format($this->temperature, 1) . "&deg;C and " . number_format($this->pressure, 1) . " mmHg is burned at constant pressure in the air.  The heat liberated and captured is used to burn a certain quantity of ice at 0&deg;C (&deg;H<sub>fusion</sub> = 6.01 kJ/mol).  Calculate the amount of ice melted, assuming that combustion is complete and that no side products, such as CO(g) are produced in the combustion reaction.";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			number_format($this->get_correct_answer_numerical() * .5, 1) . " g",
			number_format($this->get_correct_answer_numerical() * 1.5, 1) . " g",
			number_format($this->get_correct_answer_numerical() * 0.3, 1) . " g",
			number_format($this->get_correct_answer_numerical() * 1.8, 1) . " g",
		];
	}

	public function get_correct_answer_numerical() {
		$moles_gas = GasCalculator::Get_Total_Moles_of_Gas($this->volume, $this->temperature + 273, $this->pressure / 760);

		$heat_liberated = $moles_gas * $this->hydrocarbon->get_standard_enthalpy_of_combustion();

		$moles_ice_melted = abs($heat_liberated) / ThermoQuestion8::$HEAT_OF_FUSION_ICE;

		$grams_ice_melted = $moles_ice_melted * ThermoQuestion8::$MOLAR_MASS_WATER;

		return $grams_ice_melted;
	}
	public function get_correct_answer() {
		$correct_answer = $this->get_correct_answer_numerical();
		return number_format($correct_answer, 2) . " " . "g";
	}

}