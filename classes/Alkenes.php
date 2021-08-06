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

	//Tested
	public function __construct($u_number_carbons) {
		if ($u_number_carbons < count(Alkene::$SEF_FOR_ALKENES)) {
			$this->standard_enthalpy_of_formation = Alkene::$SEF_FOR_ALKENES[$u_number_carbons];
		}
		parent::__construct($u_number_carbons, $u_number_carbons * 2);
	}

	public function get_standard_enthalpy_of_formation() {
		return 0.00;
	}
	public function get_alternative_formula() {

		return "";
	}

	//Tested
	public function get_common_name() {
		return HydroCarbon::$PREFIXES[intval($this->number_carbons)] . "ene";
	}
}