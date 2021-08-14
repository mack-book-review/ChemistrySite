<?php

include "QuizQuestion.php";
include "Alkanes.php";
include "ThermoQuestionMaker.php";

/** Responsible for generate question of a specific type: asks user for the amount of hydrocarbon (in g) that must be combusted in order to raise the temperature of a given amount of water from a given starting temp to a given final temp**/

class ThermoQuestion1 extends QuizQuestion {

	public static $SPECIFIC_HEAT_CAPACITY_WATER_J_PER_MOL = 4.186;

	//Factory methods for creating objects with different configurations
	public static function MakeThermoQuestion1WithRandomAlkaneAndRandomConditions() {
		$alkane = new Alkane(rand(1, 10));
		$q = new ThermoQuestion1($alkane, 0, 0, 0);
		$q->randomize_private_vars();
		return $q;
	}

	public static function MakeThermoQuestion1WithRandomAlkaneAndSpecificConditions($vol_water_ml, $start_temp, $end_temp) {
		$rand = new Alkane(rand(1, 10));
		return new ThermoQuestion1($rand, $vol_water_ml, $start_temp, $end_temp);
	}

	public static function MakeThermoQuestion1WithSpecificAlkaneAndRandomConditions($number_carbons) {
		$alkane = new Alkane($number_carbons);
		$q = new ThermoQuestion1($alkane, 0, 0, 0);
		$q->randomize_private_vars();
		return $q;
	}

	public static function MakeThermoQuestion1WithSpecificAlkaneAndSpecificConditions($number_carbons, $vol_water_ml, $start_temp, $end_temp) {
		$alkane = new Alkane($number_carbons);
		$q = new ThermoQuestion1($alkane, $vol_water_ml, $start_temp, $end_temp);

		return $q;
	}

	//Private vars
	private $question_maker;
	private $hydrocarbon;
	private $vol_water_ml;
	private $start_temp;
	private $end_temp;

	//Private constructor
	private function __construct($u_hydrocarbon, $vol_water_ml, $start_temp, $end_temp) {

		$this->set_question_id();
		$this->hydrocarbon = $u_hydrocarbon;
		$this->vol_water_ml = $vol_water_ml;
		$this->start_temp = $start_temp;
		$this->end_temp = $end_temp;

		$this->set_answer_choice_explanation("First, determine the heat required to raise the temperature of " . number_format($this->vol_water_ml, 1) . " ml of water from " . number_format($this->start_temp, 1) . "&deg;C to " . number_format($this->end_temp, 1) . "&deg;C.  If the heat is in joules, divide this by 1000 to get the equivalent value in kilojoules. Next, determine the moles of substance required by dividing the aforementioned heat (in kJ) by the standard enthalpy of formation (in kJ/mol).  Finally, convert the number of moles to the mass of substance required by using the molar mass(" . number_format($this->hydrocarbon->get_molar_mass(), 1) . " g/mol) of the substance.");

		parent::__construct();

	}

	private function reset_answer_choices() {
		$this->choices = [
			"A" => null,
			"B" => null,
			"C" => null,
			"D" => null,
		];

		$this->generate_choices();
	}

	public function get_question_id() {
		return $this->question_id;
	}

	private function set_question_id() {
		$this->question_id = rand(1000, 9999);
	}

	private function randomize_private_vars() {
		$rand_start_temp = rand(10, 50);
		$rand_end_temp = rand($rand_start_temp, $rand_start_temp + 50);
		$this->start_temp = number_format((float) $rand_start_temp, 1);
		$this->end_temp = number_format((float) $rand_end_temp, 1);
		$this->vol_water_ml = rand(10, 5000);
	}

	public function get_question_text() {
		return "What mass of " . $this->hydrocarbon . " (in g) must be combusted in order to raise the temperature of " . number_format($this->vol_water_ml, 1) . " ml water from " . number_format($this->start_temp, 1) . " &deg;C to " . number_format($this->end_temp, 1) . " &deg;C?";
	}

	public function get_correct_answer_numerical() {

		$heat_needed_joules = $this->vol_water_ml * ($this->end_temp - $this->start_temp) * ThermoQuestion1::$SPECIFIC_HEAT_CAPACITY_WATER_J_PER_MOL;

		$moles_substance = abs(($heat_needed_joules / 1000)) / abs($this->hydrocarbon->get_standard_enthalpy_of_combustion());

		$grams_substance = $moles_substance * $this->hydrocarbon->get_molar_mass();

		return $grams_substance;
	}

	public function get_correct_answer() {

		$correct_answer = $this->get_correct_answer_numerical();

		return number_format($correct_answer, 1) . " g";
	}

	protected function get_erroneous_answers() {

		return [
			number_format(1.5 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(0.5 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(0.3 * $this->get_correct_answer_numerical(), 1) . " g",
			number_format(1.8 * $this->get_correct_answer_numerical(), 1) . " g"];

	}

}