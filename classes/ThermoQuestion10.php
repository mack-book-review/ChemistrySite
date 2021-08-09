<?php

include "ErrorGenerator10.php";

class ThermoQuestion10 extends QuizQuestion {

	private Hydrocarbon $hydrocarbon;
	private float $water_start_temp;
	private float $water_end_temp;
	private float $water_vol;
	private ErrorGenerator10 $error_generator;

	public function __construct($u_hydrocarbon) {

		$this->hydrocarbon = $u_hydrocarbon;
		$this->randomize_temps();
		$this->error_generator = new ErrorGenerator10($u_hydrocarbon);
		parent::__construct();
	}

	public function randomize_temps() {
		$this->water_start_temp = rand(10, 50);
		$this->water_end_temp = $this->water_start_temp + rand(10, 30);
		$this->water_vol = rand(100, 900);
	}

	public function get_question_text() {
		$html = "What mass of " . $this->hydrocarbon->get_common_name() . " must be combusted in order to raise the temperature of " . number_format($this->water_vol, 1) . " mL of water from " . number_format($this->water_start_temp, 1) . "&deg;C to " . number_format($this->water_end_temp, 1) . "&deg;C?";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			number_format($this->get_correct_answer_numerical(), 1) . " kg ",
			number_format($this->get_correct_answer_numerical(), 1) . " kg",
			number_format($this->get_correct_answer_numerical(), 1) . " kg",
			number_format($this->get_correct_answer_numerical(), 1) . " kg",
		];
	}

	public function get_correct_answer_numerical() {
		$heat = $this->heat_required_for_water_delta_temp($this->water_end_temp - $this->water_start_temp, $this->water_vol);

		return $this->kilograms_required_for_heat($heat);

	}

	public function get_correct_answer() {
		$correct_answer = $this->get_correct_answer_numerical();
		return number_format($correct_answer, 2) . " kg";
	}

	/** Returns the correct amount of heat required to raise a given volume of water (in ml) from a starting temp to a final temp, where delta_temp = final_temp - starting_temp **/
	public function heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000) * HydroCarbon::$SPECIFIC_HEAT_CAPACITY_WATER;
	}

	/** This function generates the RIGHT answer in determining the correct mass required to produce the amount of heat passed in as an argument **/
	public function kilograms_required_for_heat($heat) {
		$moles = abs($heat / $this->hydrocarbon->get_standard_enthalpy_of_combustion());
		return $moles * $this->hydrocarbon->get_molar_mass();
	}

}