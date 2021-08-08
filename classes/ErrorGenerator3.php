<?php

class ErrorGenerator3 implements ErrorGeneratorInterface {
	private Hydrocarbon $hydrocarbon;

	public function __construct($u_hydrocarbon) {
		$this->hydrocarbon = $u_hydrocarbon;
	}

	//Generate erroneous molar masses
	public function get_err1() {
		return HydroCarbon::$MOLAR_MASS_CARBON + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

	public function get_err2() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_CARBON + HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

	public function get_err3() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_HYDROGEN + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_CARBON;
	}

	public function get_err4() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_OXYGEN + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

}
