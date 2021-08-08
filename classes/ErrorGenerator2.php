<?php

class ErrorGenerator2 implements ErrorGeneratorInterface {

	private Hydrocarbon $hydrocarbon;

	public function __construct($u_hydrocarbon) {
		$this->hydrocarbon = $u_hydrocarbon;
	}

	//Generate erroenous standard enthalpies of combustion
	public function get_err1() {

		return (HydroCarbon::$SEF_CARBON_DIOXIDE + (0.5 * $this->hydrocarbon->get_number_hydrogens()) * HydroCarbon::$SEF_WATER) - $this->hydrocarbon->standard_enthalpy_of_formation;
	}

	public function get_err2() {

		return (($this->hydrocarbon->get_number_carbons() * HydroCarbon::$SEF_CARBON_DIOXIDE + ($this->hydrocarbon->get_number_hydrogens()) * HydroCarbon::$SEF_WATER) - $this->hydrocarbon->standard_enthalpy_of_formation);
	}

	public function get_err3() {

		return (($this->hydrocarbon->get_number_carbons() * HydroCarbon::$SEF_WATER + (0.5 * $this->hydrocarbon->get_number_hydrogens()) * HydroCarbon::$SEF_CARBON_DIOXIDE) - $this->hydrocarbon->get_standard_enthalpy_of_formation());

	}

	public function get_err4() {

		return ($this->hydrocarbon->get_standard_enthalpy_of_formation() - ($this->hydrocarbon->get_number_carbons() * HydroCarbon::$SEF_CARBON_DIOXIDE + (0.5 * $this->hydrocarbon->get_number_hydrogens()) * HydroCarbon::$SEF_WATER));

	}
}