<?php

class ChemRxnRenderer {

	public static function Get_HTML_Molar_Mass_Table($hydrocarbons) {
		$html = "<table>";

		$html .= "<tr><th>Formula</th><th>Common Name</th><th>Molar Mass (kg/mol)</th></tr>";
		foreach ($hydrocarbons as $hydrocarbon) {
			$hydrocarbon = $hydrocarbon;
			$html .= "<tr>";

			$html .= "<td>" . strval($hydrocarbon) . "</td>";

			$html .= "<td>" . $hydrocarbon->get_common_name() . "</td>";

			$html .= "<td>" . $hydrocarbon->get_alternative_formula() . "</td>";

			$html .= "<td>" . $hydrocarbon->get_molar_mass() . "</td>";

			$html .= "</tr>";

		}

		$html .= "</table>";

		return $html;
	}

	public static function Get_HTML_for_Standard_Enthalpy_Formation_Table($hydrocarbon) {
		return "<table></table>";
	}

	//Outputs the html required to display the combustion reaction for a given $hydrocarbon
	public static function Get_HTML_for_Combustion_Reaction($hydrocarbon) {

		$number_oxygens_str = strval($hydrocarbon->get_number_carbons() * 2 + $hydrocarbon->get_number_hydrogens() / 2) . "/2";

		$html = strval($hydrocarbon) . " + " . $number_oxygens_str . "O<sub>2</sub>(g)";

		$html .= " -> ";

		$html .= $hydrocarbon->get_number_carbons() . "CO<sub>2</sub>(g) + " . $hydrocarbon->get_number_hydrogens() / 2 . "H<sub>2</sub>O(l)";

		return $html;

	}
}
?>