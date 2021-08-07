<?php

class ErrorGenerator3 {
	private Hydrocarbon $hydrocarbon;

	public function __construct($u_hydrocarbon) {
		$this->hydrocarbon = $u_hydrocarbon;
	}

	//Generate erroneous molar masses
	public function get_err1_molar_mass() {
		return HydroCarbon::$MOLAR_MASS_CARBON + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

	public function get_err2_molar_mass() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_CARBON + HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

	public function get_err3_molar_mass() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_HYDROGEN + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_CARBON;
	}

	public function get_err4_molar_mass() {
		return $this->hydrocarbon->get_number_carbons() * HydroCarbon::$MOLAR_MASS_OXYGEN + $this->hydrocarbon->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

}
