<?php

class ErrorGenerator11 {

	private float $temperature;
	private float $number_moles;
	private float $pressure_final;
	private float $pressure_initial;

	public function __construct($pressure_initial, $pressure_final, $number_moles, $temperature) {
		$this->temperature = $temperature;
		$this->pressure_initial = $pressure_initial;
		$this->pressure_final = $pressure_final;
		$this->number_moles = $number_moles;
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

	public function get_erroneous_change_in_vol1() {
		return GasCalculator::Get_Volume_Of_Gas($this->pressure_final, $this->temperature, $this->number_moles) - GasCalculator::Get_Volume_Of_Gas($this->pressure_initial, $this->temperature, $this->number_moles);
	}

	public function get_erroneous_change_in_vol2() {
		return GasCalculator::Get_Volume_Of_Gas2($this->pressure_final, 273 + $this->temperature, $this->number_moles) - GasCalculator::Get_Volume_Of_Gas2($this->pressure_initial, 273 + $this->temperature, $this->number_moles);
	}

	private function get_correct_change_in_vol() {
		return $this->get_vol_final() - $this->get_vol_initial();
	}

	//Error #1:  Uses the intial pressure instead of the final pressure in calculating pressure-volume work
	public function get_err1() {
		return $this->pressure_initial * $this->get_correct_change_in_vol();

	}

	//Error #2:  Student fails to convert temperature in degrees C to degrees K
	public function get_err2() {
		return $this->pressure_final * $this->get_erroneous_change_in_vol1();

	}

	//Error #3:  Student uses the wrong constant in the ideal gas equation
	public function get_err3() {
		return $this->pressure_final * $this->get_erroneous_change_in_vol2();

	}

	//Error #4:  Miscellaneous calculation error
	public function get_err4() {
		return ($this->pressure_final * $this->get_change_in_vol()) * 1.5;

	}

}