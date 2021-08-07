
<?php

include "ErrorGenerator3.php";

class ThermoQuestion3 extends QuizQuestion {

	private Hydrocarbon $hydrocarbon;
	private ErrorGenerator3 $error_generator;

	public function __construct($u_hydrocarbon) {

		$this->hydrocarbon = $u_hydrocarbon;
		$this->error_generator = new ErrorGenerator3($u_hydrocarbon);
		$this->choices = [
			"A" => null,
			"B" => null,
			"C" => null,
			"D" => null,
		];

		$this->generate_choices();
	}

	public function get_question_text() {
		$html = "<p>What is the molar mass of " . $this->hydrocarbon . "?</p><br>";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			round($this->error_generator->get_err1_molar_mass(), 2) . " " . Hydrocarbon::$UNITS_MOLAR_MASS,
			round($this->error_generator->get_err2_molar_mass(), 2) . " " . Hydrocarbon::$UNITS_MOLAR_MASS,
			round($this->error_generator->get_err3_molar_mass(), 2) . " " . Hydrocarbon::$UNITS_MOLAR_MASS,
			round($this->error_generator->get_err4_molar_mass(), 2) . " " . Hydrocarbon::$UNITS_MOLAR_MASS];
	}

	public function get_correct_answer() {
		$correct_answer = $this->hydrocarbon->get_molar_mass();
		return strval(round($correct_answer, 2)) . " " . Hydrocarbon::$UNITS_MOLAR_MASS;
	}

}
