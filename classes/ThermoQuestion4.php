
<?php

class ThermoQuestion4 extends QuizQuestion {

	//Specific Heat Capacity of Water in kJ/kg-degree Celsius
	private static float $WATER_SPECIFIC_HEAT = 4.18;

	private static float $ICE_SPECIFIC_HEAT = 2.01;

	//Molar Mass of Water (g/mol)
	private static float $MOLAR_MASS_WATER = 18.02;

	//Molar Enthalpy of Freezing (kJ/mol)
	private static float $WATER_ENTHALPY_FREEZING = -6.01;

	//Molar Enthalpy of Melting (kJ/mol)
	private static float $WATER_ENTHALPY_MELTING = 6.01;

	//Molar Enthalpy of Vaporization (kJ/mol)
	private static float $WATER_ENTHALPY_VAPORIZING = 44.0;

	//Molar Enthalpy of Condensation (kJ/mol)
	private static float $WATER_ENTHALPY_CONDENSING = -44.0;

	private ErrorGeneratorInterface $error_generator;
	private float $mass_water;
	private float $start_temp;
	private float $final_temp;
	private int $transition_type;
	private $transition_type_options = [
		1 => ["liquid", "vapor"],
		2 => ["vapor", "liquid"],
		3 => ["ice", "liquid"],
		4 => ["liquid", "ice"],
	];

	public function __construct() {

		$this->randomize_mass();
		$this->randomize_transition_type();
		$this->randomize_temps();

		parent::__construct();
	}

	private function randomize_transition_type() {
		$rand_transition_option = rand(1, count(array_keys($this->transition_type_options)));
		$this->transition_type = $rand_transition_option;
	}

	private function randomize_mass() {
		$rand_mass = rand(10, 1000);
		$this->mass_water = $rand_mass;
	}

	private function randomize_temps() {

		switch ($this->transition_type) {
		case 1:
			$this->start_temp = rand(1, 100);
			$this->final_temp = rand(101, 150);
			break;

		case 2:
			$this->start_temp = rand(100, 150);
			$this->final_temp = rand(1, 100);
			break;
		case 3:
			$this->start_temp = rand(-50, 0);
			$this->final_temp = rand(1, 50);
			break;
		case 4:
			$this->start_temp = rand(0, 99);
			$this->final_temp = rand(-50, 0);
			break;

		}
	}

	private function get_enthalpy_for_transition_type() {
		switch ($this->transition_type) {
		case 1:
			return ThermoQuestion4::$WATER_ENTHALPY_VAPORIZING;
		case 2:
			return ThermoQuestion4::$WATER_ENTHALPY_CONDENSING;
		case 3:
			return ThermoQuestion4::$WATER_ENTHALPY_MELTING;
		case 4:
			return ThermoQuestion4::$WATER_ENTHALPY_FREEZING;
		}
	}

	public function get_question_text() {

		$first_phase = $this->transition_type_options[$this->transition_type][0];
		$second_phase = $this->transition_type_options[$this->transition_type][1];

		$html = "Calculate &Delta;H for the process in which " . number_format($this->mass_water, 1) . " g of water is converted from " . $first_phase . " at " . number_format($this->start_temp, 1) . "&deg;C to " . $second_phase . " at " . number_format($this->final_temp, 1) . "&deg;C. ";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		//Not yet implemented
		return [
			number_format($this->get_correct_answer_numerical() / 2, 2) . " kJ",
			number_format($this->get_correct_answer_numerical() * 2, 2) . " kJ",
			number_format($this->get_correct_answer_numerical() * (-1), 2) . " kJ",
			number_format($this->get_correct_answer_numerical() * 1.5, 2) . " kJ",
		];

	}

	public function get_correct_answer_numerical() {

		$heat1 = 0;
		$heat2 = 0;

		switch ($this->transition_type) {
		case 1:
			$heat1 = (100.0 - $this->start_temp) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);

			$heat2 = ($this->final_temp - 100.0) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);

			break;
		case 2:
			$heat1 = (100.0 - $this->start_temp) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);

			$heat2 = ($this->final_temp - 100.0) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);
			break;
		case 3:
			$heat1 = (0.00 - $this->start_temp) * ThermoQuestion4::$ICE_SPECIFIC_HEAT * ($this->mass_water);
			$heat2 = ($this->final_temp - 0.00) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);
			break;
		case 4:
			$heat1 = (0.00 - $this->start_temp) * ThermoQuestion4::$WATER_SPECIFIC_HEAT * ($this->mass_water);
			$heat2 = ($this->final_temp - 0.00) * ThermoQuestion4::$ICE_SPECIFIC_HEAT * ($this->mass_water);
			break;
		}

		$heat3 = $this->get_enthalpy_for_transition_type() * ($this->mass_water) / (ThermoQuestion4::$MOLAR_MASS_WATER);

		$correct_answer = $heat1 / 1000 + $heat2 / 1000 + $heat3;

		return $correct_answer;
	}

	public function get_correct_answer() {

		$correct_answer_numerical = $this->get_correct_answer_numerical();
		return number_format((round($correct_answer_numerical, 2)), 2) . " kJ";
	}

}
