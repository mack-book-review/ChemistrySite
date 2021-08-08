<?php

class SubstanceSPH {

	public static array $COMMON_SUBSTANCES = [
		new SubstanceSPH("Lead","Pb(s)",.130,"solid"),
		new SubstanceSPH("Copper","Cu(s)",.385,"solid"),
		new SubstanceSPH("Sulfur","S<sub>8</sub>(s)",..708,"solid"),
		new SubstanceSPH("Iron","Fe(s)",.449,"solid"),

	];

	public static function GET_RANDOM_SUBSTANCE_SPH(){
		$key= array_rand(SubstanceSPH::$COMMON_SUBSTANCES,1);
		return SubstanceSPH::COMMON_SUBSTANCES[$key];
	}

	private string $common_name;
	private string $formula;
	private float $sp_heat;
	private string $phase;

	public function get_specific_heat(){
		return $this->sp_heat;
	}

	public function __construct($u_common_name,$u_formula,$u_sp_heat,$u_phase){
		$this->common_name = $u_common_name;
		$this->formula = $u_formula;
		$this->sp_heat = $u_sp_heat;
		$this->u_phase = $u_phase;

	}

	public function __toString(){
		return $this->common_name;
	}

}

class ThermoQuestion6 extends QuizQuestion {

	private static float $SPECIFIC_HEAT_CAPACITY_WATER = 4.18;

	private float $mass_substance;
	private SubstanceSPH $substance;
	private float $substance_temp;
	private float $water_temp;
	private float $final_temp;

	public function __construct($u_substance_sph = null) {
		if($u_substance_sph == null){
			$this->substance = SubstanceSPH::GET_RANDOM_SUBSTANCE_SPH();
		} else {
			$this->substance = $u_substance_sph;
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
		$html = "<p>When " . $this->mass_substance . " kg of ". $this->substance ."(specific heat = J g<sup>-1</sup> &deg;C<sup>-1</sup>) at " . $this->substance_temp . "&deg;C is added to a quantity of water at ". $this->water_temp."&deg;C, the final temperature of the ". $this->substance."-water mixture is " . $this->final_temp ."&deg;C.  What is the mass of the water present?</p><br>";

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
			$this->get_correct_answer(),
			$this->get_correct_answer()*.5,
			$this->get_correct_answer()*1.5,
			$this->get_correct_answer()*2.0,

		];
	}

	
	public function get_correct_answer() {

		$heat_released_by_substance = $this->get_specific_heat()*$this->mass_substance*($this->water_temp-$this->substance_temp);

		$mass_water = ($heat_released_by_substance/ThermoQuestion6::$SPECIFIC_HEAT_CAPACITY_WATER)/($this->final_temp-$this->water_temp);
		
		return strval(round($mass_water, 2)) . " g";
	}

}
