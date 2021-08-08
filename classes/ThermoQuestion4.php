
<?php


class ThermoQuestion4 extends QuizQuestion {

	//Specific Heat Capacity of Water in kJ/kg-degree Celsius
	private static float $WATER_SPECIFIC_HEAT = 4.18;

	//Molar Mass of Water
	private static float $MOLAR_MASS_WATER = .01802;

	//Molar Enthalpy of Freezing
	private static float $WATER_ENTHALPY_FREEZING = -6.01;

	//Molar Enthalpy of Melting
	private static float $WATER_ENTHALPY_MELTING = 6.01;

	//Molar Enthalpy of Vaporization
	private static float $WATER_ENTHALPY_VAPORIZING = 44.0;

	//Molar Enthalpy of Condensation
	private static float $WATER_ENTHALPY_CONDENSING = -44.0;


	private ErrorGenerator4 $error_generator;
	private float $mass_water;
	private float $start_temp;
	private float $final_temp;
	private int transition_type;
	private transition_type_options = [
		1 => ["liquid","vapor"],
		2 => ["vapor","liquid"],
		3 => ["ice","liquid"],
		4 => ["liquid","ice"]
	];

	public function __construct() {

		$this->randomize_mass();
		$this->randomize_transition_type();
		$this->randomize_temps();
		
		parent::__construct();
	}

	private function randomize_transition_type(){
		$rand_transition_option = rand(0,count(array_keys($this->transition_type_options)));
		$this->transition_type = $rand_transition_option;
	}

	private function randomize_mass(){
		$rand_mass = rand(10,1000);
		$this->mass_water = $rand_mass;
	}

	private function randomize_temps(){

		switch ($this->transition_type) {
			case 1:
				$this->start_temp = rand(1,25);
				$this->end_temp = rand(26,100);
				break;

			case 2:
				$this->start_temp = rand(26,100);
				$this->end_temp = rand(1,25);
				break;
			case 3:
				$this->start_temp = rand(-50,0);
				$this->end_temp = rand(1,50);
				break;
			case 4:
				$this->start_temp = rand(1,50);
				$this->end_temp =  rand(-50,0);
				break;
			
		}
	}


	private function get_enthalpy_for_transition_type(){
		switch($this->transition_type){
			case 1:
				return ThermoQuestion4::$WATER_ENTHALPY_VAPORIZING;
			case 2:
				return ThermoQuestion4::WATER_ENTHALPY_CONDENSING;
			case 3:
				return ThermoQuestion4::WATER_ENTHALPY_MELTING;
			case 4:
			return ThermoQuestion4::WATER_ENTHALPY_FREEZING;
		}
	}

	public function get_question_text() {

		$first_phase = $this->transition_type_options[$this->transition_type][0];
		$second_phase = $this->transition_type_options[$this->transition_type][1];

		$html = "<p>Calculate &delta;H for the process in which " . $this->mass_water . " is converted from " .  $first_phase ." at ".$this->start_temp ."&deg;C to " . $second_phase ." at ".$this->end_temp."&deg;C </p><br>";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		//Not yet implemented
		return [
			$this->get_correct_answer()/2,
			$this->get_correct_answer()*2,
			$this->get_correct_answer()*(-1),
			$this->get_correct_answer()*1.5
		];
			
	}

	public function get_correct_answer() {

		$heat1 = 0;

		switch($this->transition_type){
			case 1:
				$heat1  = (25.0 - $this->start_temp)*ThermoQuestion4::$WATER_SPECIFIC_HEAT*($this->mass_water/1000);
				break;
			case 2:
			$heat1  = ($this->final_temp - 25.0)*ThermoQuestion4::$WATER_SPECIFIC_HEAT*($this->mass_water/1000);
				break;
			case 3:
				$heat1  = ($this->final_temp - 0.0)*ThermoQuestion4::$WATER_SPECIFIC_HEAT*($this->mass_water/1000);
				break;
			case 4:
				$heat1  = (0.0 - $this->start_temp)*ThermoQuestion4::$WATER_SPECIFIC_HEAT*($this->mass_water/1000);
				break;
		}

		$heat2 = $this->get_enthalpy_for_transition_type()*($this->mass_water/1000)/(ThermoQuestion4::$MOLAR_MASS_WATER);

		

		$correct_answer = $heat1 + $heat2;

		return strval(round($correct_answer, 2)) . " kJ";
	}

}
