<?php

include "QuizQuestion.php";

/** Responsible for generate question of a specific type: asks user for the amount of hydrocarbon (in g) that must be combusted in order to raise the temperature of a given amount of water from a given starting temp to a given final temp**/

class ThermoQuestion1 extends QuizQuestion {

	private ThermoQuestionMaker1 $question_maker;
	private Hydrocarbon $hydrocarbon;
	private float $vol_water_ml;
	private float $start_temp;
	private float $end_temp;
	private string $correct_choice;
	private $choices;

	public function __construct($u_hydrocarbon) {
		//randomly set $start_temp and $end_temp
		//randomly set $vol water in ml
		$this->hydrocarbon = $u_hydrocarbon;
		$this->question_maker = new ThermoQuestionMaker1($u_hydrocarbon);
		$this->randomize_private_vars();
		$this->choices = [
			"A" => null,
			"B" => null,
			"C" => null,
			"D" => null,
		];
		$this->generate_choices();
	}

	private function randomize_private_vars() {
		$rand_start_temp = rand(10, 50);
		$rand_end_temp = rand($rand_start_temp, $rand_start_temp + 50);
		$this->start_temp = number_format((float) $rand_start_temp, 1);
		$this->end_temp = number_format((float) $rand_end_temp, 1);
		$this->vol_water_ml = rand(10, 5000);
	}

	public function get_question_text() {
		return "What mass of " . $this->hydrocarbon . " (in g) must be combusted in order to raise the temperature of " . $this->vol_water_ml . " ml water from " . $this->start_temp . " &deg;C to " . $this->end_temp . " &deg;C?";
	}

	public function get_correct_choice() {
		return $this->correct_choice;
	}

	public function get_choices() {
		$html = "<br>";
		foreach ($this->choices as $letter => $choice) {
			$html .= "($letter) $choice <br>";
		}
		return $html;
	}

	private function get_erroneous_answer1() {
		return round($this->question_maker->error1_amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp) * 1000, 1) . " g";
	}

	private function get_erroneous_answer2() {
		return round($this->question_maker->error2_amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp) * 1000, 1) . " g";

	}

	private function get_erroneous_answer3() {

		return round($this->question_maker->error3_amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp) * 1000, 1) . " g";

	}

	private function get_erroneous_answer4() {
		return round($this->question_maker->error4_amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp) * 1000, 1) . " g";
	}

	private function get_correct_answer() {
		$correct_answer = $this->question_maker->correct_amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp);

		return strval(round($correct_answer * 1000, 1)) . " g";
	}

	private function randomly_assign_erroneous_answers($erroneous_answers) {

		shuffle($erroneous_answers);

		$i = 0;

		foreach ($this->choices as $letter => $choice) {
			if ($choice == null) {

				$this->choices[$letter] = $erroneous_answers[$i];

				$i += 1;
			}
		}
	}

	private function generate_erroneous_answers() {

		$error1 = $this->get_erroneous_answer1();
		$error2 = $this->get_erroneous_answer2();
		$error3 = $this->get_erroneous_answer3();
		$error4 = $this->get_erroneous_answer4();

		return [$error1, $error2, $error3, $error4];

	}

	private function randomly_assign_correct_answer() {
		$rand_key = array_rand(array_keys($this->choices), 1);
		$this->correct_choice = array_keys($this->choices)[$rand_key];

		$this->choices[$this->correct_choice] = $this->get_correct_answer();
	}

	//generate erroneous and correct choices
	private function generate_choices() {

		$this->randomly_assign_correct_answer();

		$erroneous_answers = $this->generate_erroneous_answers();

		$this->randomly_assign_erroneous_answers($erroneous_answers);
	}

}