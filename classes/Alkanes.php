<?php

require "hydrocarbons.php";

class Alkane extends Hydrocarbon {

	private $length_longest_carbon_chain;
	private $alkyl_group_locations;
	private $isomers = array();

	/** Returns an array containing the first 10 n-isomer alkanes **/
	public static function GET_COMMON_ALKANES() {

		$common_alkanes = [];
		for ($i = 1; $i < 11; $i++) {
			$common_alkanes[$i] = new Alkane($i);
		}

		return $common_alkanes;
	}

	protected static $SEF_FOR_ALKANES = [
		1 => -74.81,
		2 => -84.68,
		3 => -103.8,
		4 => -125.6,
		5 => -147.1,
		6 => -167.2,
		7 => -187.8,
		8 => -208.7,
		9 => -228.3,
		10 => -249.7,
	];

	//Tested
	public function __construct($u_number_carbons, $phase = "g") {

		// if ($length_longest_carbon_chain < 3) {
		// 	return null;
		// }
		parent::__construct($u_number_carbons, $u_number_carbons * 2 + 2, $phase);

		if ($u_number_carbons < count(Alkane::$SEF_FOR_ALKANES)) {
			$this->standard_enthalpy_of_formation = Alkane::$SEF_FOR_ALKANES[$u_number_carbons];
		}

		// if ($length_longest_carbon_chain == null) {
		// 	$this->length_longest_carbon_chain = $u_number_carbons;

		// }

		// if ($u_number_carbons > 3) {
		// 	$number_isomers = ceil(($u_number_carbons - 3) / 2);

		// 	for ($i = 1; $i < 1 + $number_isomers; $i++) {

		// 		$alkyl_group_locations = [
		// 			$i => "methyl",
		// 		];

		// 		$this->isomers[] = new Alkane($u_number_carbons, $u_number_carbons - 1, $alkyl_group_locations);
		// 	}

		// }

		// if ($u_number_carbons > 4) {
		// 	$number_isomers = ceil(($u_number_carbons - 4) / 2);

		// 	for ($i = 1; $i < 1 + $number_isomers; $i++) {

		// 		$alkyl_group_locations = [
		// 			$i => "ethyl",
		// 		];

		// 		$this->isomers[] = new Alkane($u_number_carbons, $u_number_carbons - 1, $alkyl_group_locations);
		// 	}

		// }

	}

	// public function show_all_isomers() {
	// 	if ($this->isomers != null && !empty($this->isomers)) {
	// 		return implode(", ", $this->isomers);
	// 	}

	// }

	// public static function get_all_isomers($isomer) {
	// 	$all_isomers = [];

	// 	foreach ($isomer->isomers as $isomer) {
	// 		$all_isomers[] = $isomer;
	// 		foreach (Alkane::get_all_isomers($isomer) as $isomer) {
	// 			$all_isomers[] = $isomer;
	// 		}
	// 	}

	// 	return $all_isomers;
	// }

	/**Implementation of abstract methods from base class **/

	/** Returns standard enthalpy of formation in units of kJ/mol **/
	public function get_standard_enthalpy_of_formation() {
		return Alkane::$SEF_FOR_ALKANES[$this->number_carbons];
	}

	public function get_common_name() {

		return Alkane::$PREFIXES[intval($this->number_carbons)] . "ane";
		// if ($this->number_carbons == $this->length_longest_carbon_chain) {

		// return Alkane::$PREFIXES[intval($this->number_carbons)] . "ane";

		// } else {

		// 	$name = "";

		// 	foreach ($alkyl_group_locations as $location => $alkyl_group_name) {
		// 		$name .= $location . "-" . $alkyl_group_name;
		// 	}

		// 	$name .= Alkane::$PREFIXES[intval($this->length_longest_carbon_chain)] . "ane";

		// 	return $name;
		// }

	}

	public function get_alternative_formula() {

		if ($this->number_carbons == 1) {
			return "CH<sub>4</sub>";
		} else if ($this->number_carbons == 2) {
			return "CH<sub>3</sub>CH<sub>3</sub>";
		} else if ($this->number_carbons == 3) {

			$html = "CH<sub>3</sub>";
			for ($i = 0; $i < $this->number_carbons - 2; $i++) {
				$html .= "CH<sub>2</sub>";

			}
			$html .= "CH<sub>3</sub>";
			return $html;

		} else {
			$html = "CH<sub>3</sub>";
			for ($i = 0; $i < $this->number_carbons - 2; $i++) {
				$html .= "(CH)<sub>2</sub>";

			}
			$html .= "CH<sub>3</sub>";
			return $html;
		}
	}

}

?>