<?php

include "ThermoQuestionMaker.php";

/** Responsible for generate question of a specific type: asks user for the amount of hydrocarbon (in g) that must be combusted in order to raise the temperature of a given amount of water from a given starting temp to a given final temp**/

class ThermoQuestion1 extends QuizQuestion {
	private static int $Question_Counter = 1;

	private static function Increment_Question_Counter() {
		ThermoQuestion1::$Question_Counter += 1;
	}

	private ThermoQuestionMaker1 $question_maker;
	private Hydrocarbon $hydrocarbon;
	private float $vol_water_ml;
	private float $start_temp;
	private float $end_temp;

	public function __construct($u_hydrocarbon) {
		//randomly set $start_temp and $end_temp
		//randomly set $vol water in ml
		$this->question_id = ThermoQuestion1::$Question_Counter;
		ThermoQuestion1::Increment_Question_Counter();
		$this->hydrocarbon = $u_hydrocarbon;
		$this->randomize_private_vars();
		$this->question_maker = new ThermoQuestionMaker1($u_hydrocarbon, $this->vol_water_ml, $this->start_temp, $this->end_temp);

		parent::__construct();
	}

	public function get_question_id() {
		return $this->question_id;
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

	public function get_correct_answer() {

		return strval(round($this->question_maker->correct_amount_required_to_heat_water() * 1000, 1)) . " g";
	}

	protected function get_erroneous_answers() {

		return [
			round($this->question_maker->error1_amount_required_to_heat_water() * 1000, 1) . " g",
			round($this->question_maker->error2_amount_required_to_heat_water() * 1000, 1) . " g",
			round($this->question_maker->error3_amount_required_to_heat_water() * 100, 1) . " g",
			round($this->question_maker->error1_amount_required_to_heat_water() * 1000, 1) . " g"];

	}

}