<?php

class ErrorGenerator10 implements ErrorGeneratorInterface {

	public HydroCarbon $hydrocarbon;

	public function __construct($hydrocarbon) {
		$this->hydrocarbon = $hydrocarbon;
	}

	public function get_err1() {
		return 1.0;
	}

	public function get_err2() {
		return 1.0;

	}

	public function get_err3() {
		return 1.0;

	}

	public function get_err4() {
		return 1.0;

	}

	/** Returns the ERRONEOUS amount of heat required to raise a given volume of water (in ml) from a starting temp to a final temp, where delta_temp = final_temp - starting_temp **/

	private function generate_error1_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000) / 2 * HydroCarbon::$SPECIFIC_HEAT_CAPACITY_WATER;
	}

	private function generate_error2_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000);
	}

	/** These functions generate WRONG answers in determining the mass of a substance required to produce the amount of heat provided as input.  These function simulate common errors made by students so that they can be used to create erroneous answer choices **/
	private function generate_error1_kilograms_required_for_heat($heat) {

		$moles = abs($heat / $this->hydrocarbon->get_standard_enthalpy_of_combustion());
		return $moles * $this->error_generator3->get_err1();

	}

	private function generate_error2_kilograms_required_for_heat($heat) {

		$moles = abs($heat / $this->hydrocarbon->get_err1_standard_enthalpy_of_combustion());
		return $moles * $this->hydrocarbon->get_molar_mass();

	}

}