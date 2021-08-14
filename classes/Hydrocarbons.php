<?php

abstract class Hydrocarbon {

	//Define abstract methods
	abstract public function get_standard_enthalpy_of_formation();
	abstract public function get_common_name();
	abstract public function get_alternative_formula();

	//Define static constants
	public static $SEF_CARBON_DIOXIDE = -393.5;
	public static $SEF_WATER = -285.8;
	public static $SPECIFIC_HEAT_CAPACITY_WATER = .004186;
	public static $MOLAR_MASS_CARBON = 12.01;
	public static $MOLAR_MASS_HYDROGEN = 1.00784;
	public static $MOLAR_MASS_OXYGEN = 15.999;
	public static $UNITS_ENTHALPY_COMBUSTION = "kJ/mol";
	public static $UNITS_MOLAR_MASS = "kg/mol";

	protected static $PREFIXES = [

		1 => "meth",
		2 => "eth",
		3 => "prop",
		4 => "but",
		5 => "pent",
		6 => "hex",
		7 => "hept",
		8 => "oct",
		9 => "non",
		10 => "dec",
		11 => "undec",
		12 => "dodec",
		13 => "tridec",
		14 => "tetradec",
		15 => "pentadec",
	];

	//Define protected variables common to all child classes
	protected $number_carbons;
	protected $number_hydrogens;

	//Define constructors
	public function __construct($u_number_carbons, $u_number_hydrogens) {
		$this->number_carbons = $u_number_carbons;
		$this->number_hydrogens = $u_number_hydrogens;

	}

	//Define methods common to all hydrocarbons
	public function get_number_carbons() {
		return $this->number_carbons;
	}

	public function get_number_hydrogens() {
		return $this->number_hydrogens;
	}

	public function get_molar_mass() {
		return $this->number_carbons * HydroCarbon::$MOLAR_MASS_CARBON + $this->get_number_hydrogens() * HydroCarbon::$MOLAR_MASS_HYDROGEN;
	}

	public function get_standard_enthalpy_of_combustion() {

		return (($this->number_carbons * HydroCarbon::$SEF_CARBON_DIOXIDE + (0.5 * $this->get_number_hydrogens()) * HydroCarbon::$SEF_WATER) - $this->get_standard_enthalpy_of_formation());
	}

	//Define toString() function
	public function __toString() {
		return "C<sub>" . $this->get_number_carbons() . "</sub>H<sub>" . $this->get_number_hydrogens() . "</sub>(g)";
	}

}

?>