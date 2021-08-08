
<?php

class Solution {

	private float $molarity;
	private float $volume_ml;
	private string $formula;

	public function __construct($volume_ml, $molarity, $formula) {
		$this->volume_ml = round($volume_ml, 2);
		$this->molarity = round($molarity, 2);
		$this->formula = $formula;

	}

	public function __toString() {
		return number_format($this->volume_ml, 1) . " mL of " . number_format($this->molarity, 1) . "M " . $this->formula . "(aq)";
	}

	public function get_volume_ml() {
		return $this->volume_ml;
	}

	public function get_moles_of_solute() {
		return ($this->volume_ml / 1000) * $this->molarity;
	}

}

class ThermoQuestion5 extends QuizQuestion {

	private static float $SPECIFIC_HEAT_CAPACITY_WATER = 4.18;

	private Solution $solution1;
	private Solution $solution2;
	private float $start_temp = 0.00;
	private float $final_temp = 0.00;
	private float $heat_of_neutralization;

	private array $rxn_stoichiometry = [
		"mol_solute1" => 1,
		"mol_solute2" => 1,
		"mol_solute3" => 1,
	];

	public function __construct($u_solution1, $u_solution2, $heat_of_neutralization, $u_rxn_stoichiometry = null) {

		$this->solution1 = $u_solution1;
		$this->solution2 = $u_solution2;
		$this->heat_of_neutralization = $heat_of_neutralization;

		if (!empty($u_rxn_stoichiometry)) {
			$this->rxn_stoichiometry = $u_rxn_stoichiometry;
		}

		$this->randomize_start_temp();
		$this->calculate_final_temp();

		parent::__construct();

	}

	private function randomize_start_temp() {
		$this->start_temp = rand(10, 20);
	}

	public function get_question_text() {
		$html = "Two solutions, " . $this->solution1 . " and " . $this->solution2 . ", both initially at " . number_format($this->start_temp, 1) . "&deg;C, are added to a Styrofoam-cup calorimeter and allowed to react.  The temperature rises to " . number_format($this->final_temp, 1) . "&deg;C.  Determine the heat of the neutralization of reaction, expressed per mole of H<sub>2</sub>O formed.";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	//Default form: not yet finished
	protected function get_erroneous_answers() {
		return [
			number_format($this->get_correct_answer_numerical() * 0.5, 1) . " kJ/mol",
			number_format(-$this->get_correct_answer_numerical(), 1) . " kJ/mol",
			number_format($this->get_correct_answer_numerical() * 1.5, 1) . " kJ/mol",
			number_format($this->get_correct_answer_numerical() * 2, 1) . " kJ/mol",
		];
	}

	private function get_combined_volume() {
		return $this->solution1->get_volume_ml() + $this->solution2->get_volume_ml();
	}

	private function get_moles_limiting_reactant() {
		$mol1 = $this->solution1->get_moles_of_solute();
		$mol2 = $this->solution1->get_moles_of_solute();

		if ($this->rxn_stoichiometry['mol_solute1'] == $this->rxn_stoichiometry['mol_solute2']) {
			return $mol1;
		} else {

			$ratio1 = $this->rxn_stoichiometry["mol_solute3"] / $this->rxn_stoichiometry["mol_solute1"];

			$ratio2 = $this->rxn_stoichiometry["mol_solute3"] / $this->rxn_stoichiometry["mol_solute2"];

			$theoretical_prod_mol1 = $ratio1 * $mol1;

			$theoretical_prod_mol2 = $ratio2 * $mol2;

			if ($theoretical_prod_mol1 < $theoretical_prod_mol2) {

				return $theoretical_prod_mol1;
			} else {
				return $theoretical_prod_mol2;
			}

		}

	}

	public function calculate_final_temp() {

		$moles_limiting_reactant = $this->get_moles_limiting_reactant();

		$temp = $this->heat_of_neutralization * $moles_limiting_reactant;

		$heat_of_calorimeter = -$temp;

		$temperature_change = $heat_of_calorimeter / ($this->get_combined_volume() * (ThermoQuestion5::$SPECIFIC_HEAT_CAPACITY_WATER / 1000));
		$this->final_temp = $this->start_temp + $temperature_change;

	}

	public function get_correct_answer_numerical() {

		return $this->heat_of_neutralization;
	}

	public function get_correct_answer() {

		return strval(round($this->heat_of_neutralization, 2)) . " kJ";
	}

}
