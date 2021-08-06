<?php

include "hydrocarbons.php";

class Alkyne extends HydroCarbon {

	public static function GET_COMMON_ALKYNES() {

		$common_alkynes = [];
		for ($i = 1; $i < 11; $i++) {
			$common_alkynes[$i] = new Alkyne($i);
		}

		return $common_alkynes;
	}

	protected static $SEF_FOR_ALKYNES = [
		1 => 0,
		2 => 0,
		3 => 0,
		4 => 0,
		5 => 0,
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
		parent::__construct($u_number_carbons, $u_number_carbons);
	}

	//Tested
	public function get_common_name() {
		return HydroCarbon::$PREFIXES[intval($this->number_carbons)] . "yne";
	}

}
