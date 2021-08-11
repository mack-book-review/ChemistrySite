<?php

class Alkene extends HydroCarbon {

	public static function GET_COMMON_ALKENES() {

		$common_alkenes = [];
		for ($i = 1; $i < 11; $i++) {
			$common_alkenes[$i] = new Alkene($i);
		}

		return $common_alkenes;
	}

	protected static $SEF_FOR_ALKENES = [
		1 => 0,
		2 => 0,
		3 => 0,
		4 => [
			"1-butene" => 0,
			"2-butene" => 0,
		],
		5 => [
			"1-pentene" => 0,
			"2-pentene:" => 0,
		],
		6 => 0,
		7 => 0,
		8 => 0,
		9 => 0,
		10 => 0,
	];

	private $location_double_bond;
	//Tested
	public function __construct($u_number_carbons, $location_double_bond = 1) {
		if ($u_number_carbons < count(Alkene::$SEF_FOR_ALKENES)) {
			$this->standard_enthalpy_of_formation = Alkene::$SEF_FOR_ALKENES[$u_number_carbons];
		}

		if ($u_number_carbons >= 4) {
			$this->location_double_bond = $location_double_bond;
		} else {
			$this->location_double_bond = 1;
		}

		parent::__construct($u_number_carbons, $u_number_carbons * 2);
	}

	public function get_standard_enthalpy_of_formation() {
		return 0.00;
	}
	public function get_alternative_formula() {

		return "";
	}

	public function get_heat_of_hydrogenation() {
		return 0.00;
	}

	//Tested
	public function get_common_name() {
		if ($this->number_carbons >= 4) {
			return HydroCarbon::$PREFIXES[intval($this->number_carbons)] . "ene";
		} else {
			return $this->location_double_bond . "-" . HydroCarbon::$PREFIXES[intval($this->number_carbons)] . "ene";
		}
	}
}