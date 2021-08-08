
<?php

class Solution {

	private float $molarity;
	private float $volume_ml;
	private string $formula;
	private float $initial_temp;
	private float $final_temp;

	public function __construct($volume_ml, $molarity, $formula) {
		$this->volume_ml = round($volume_ml, 2);
		$this->molarity = round($molarity, 2);
		$this->formula = $formula;
	}

	public function get_volume_ml(){
		return $this->volume_ml;
	}

	public function get_moles_of_solute() {
		return ($this->volume_ml / 1000) * $this->molarity;
	}

	public function __toString() {
		return $this->volume_ml . " mL of " . $this->molarity . "M " . $formula . "(aq)";
	}
}

class ThermoQuestion5 extends QuizQuestion {

	private static float $SPECIFIC_HEAT_CAPACITY_WATER = 4.18;

	private Solution $solution1;
	private Solution $solution2;
	private array $rxn_stoichiometry = [
		"mol_solute1" => 1,
		"mol_solute2" => 1,
		"mol_solute3" => 1
	];

	private ErrorGenerator5 $error_generator;


	public function __construct($u_solution1,$u_solution2, $u_rxn_stoichiometry = null) {

		$this->solution1 = $u_solution1;
		$this->solution2 = $u_solution2;

		if(!empty($u_rxn_stoichiometry)){
			$this->rxn_stoichiometry = $u_rxn_stoichiometry;
		}

		$this->choices = [
			"A" => null,
			"B" => null,
			"C" => null,
			"D" => null,
		];

		$this->generate_choices();
	}

	public function get_question_text() {
		$html = "<p>Two solutions, ". $this->solution1 . " and " . $this->solution2 .", both initially at " . $this->initial_temp "&deg;C, are added to a Styrofoam-cup calorimeter and allowed to react.  The temperature rises to ". $this->final_temp."&deg;C.  Determine the heat of the neutralization of reaction, expressed per mole of H<sub>2</sub>O formed. </p><br>";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	//Default form: not yet finished
	protected function get_erroneous_answers() {
		return [
			$this->get_correct_answer()*.5,
			-$this->get_correct_answer(),
			$this->get_correct_answer()*1.5,
			$this->get_correct_answer()*2
		];
	}

	private function get_combined_volume(){
		return $this->solution1->get_volume_ml() + $this->solution2->get_volume_ml();
	}

	private function get_temperature_change(){
		return $this->final_temp - $this->start_temp;
	}

	private function get_moles_limiting_reactant(){
		$mol1 = $this->solution1->get_moles_of_solute();
		$mol2 = $this->solution1->get_moles_of_solute();

		if($this->rxn_stoichiometry['mol_solute1'] == $this->rxn_stoichiometry['mol_solute2']){
			return $mol1;
		} else {

			$ratio1 =  $this->rxn_stoichiometry["mol_solute3"]/$this->rxn_stoichiometry["mol_solute1"];

			$ratio2 = $this->rxn_stoichiometry["mol_solute3"]/$this->rxn_stoichiometry["mol_solute2"];

			$theoretical_prod_mol1 = $ratio1*$mol1;

			$theoretical_prod_mol2 = $ratio2*$mol2;

			if($theoretical_prod_mol1 < $theoretical_prod_mol2){

				return $theoretical_prod_mol1;
			} else {
				return $theoretical_prod_mol2;
			}

		}
		
	}

	public function get_correct_answer() {
		$heat_of_calorimeter = $this->get_combined_volume()*$this->get_temperature_change()*ThermoQuestion5::$WATER_SPECIFIC_HEAT*1000;

		$temp = -$heat_of_calorimeter;

		$moles_limiting_reactant = $this->get_moles_limiting_reactant();

		$heat_of_neutralization = $temp/$moles_limiting_reactant;
		return strval(round($heat_of_neutralization, 2)) . " kJ";
	}

}
