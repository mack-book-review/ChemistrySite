<?php

include "ErrorGenerator2.php";
include "ChemRxnRenderer.php";

class ThermoQuestion2 extends QuizQuestion {

	private $hydrocarbon;
	private $error_generator;

	public function __construct($u_hydrocarbon) {

		$this->hydrocarbon = $u_hydrocarbon;
		$this->error_generator = new ErrorGenerator2($u_hydrocarbon);

		parent::__construct();

		$this->set_answer_choice_explanation("For ThermoQuestion #2, You have to do some complex calculation in order to get this.");

	}

	public function get_question_text() {
		$html = "What is the standard enthalpy of combustion for " . $this->hydrocarbon . "?  The equation for the combustion reaction is shown below:<br> <br>";

		$html .= ChemRxnRenderer::Get_HTML_for_Combustion_Reaction($this->hydrocarbon);

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			round($this->error_generator->get_err1(), 2) . Hydrocarbon::$UNITS_ENTHALPY_COMBUSTION,
			round($this->error_generator->get_err2(), 2) . Hydrocarbon::$UNITS_ENTHALPY_COMBUSTION,
			round($this->error_generator->get_err3(), 2) . Hydrocarbon::$UNITS_ENTHALPY_COMBUSTION,
			round($this->error_generator->get_err4(), 2) . Hydrocarbon::$UNITS_ENTHALPY_COMBUSTION];
	}

	public function get_correct_answer() {
		$correct_answer = $this->hydrocarbon->get_standard_enthalpy_of_combustion();
		return strval(round($correct_answer, 2)) . Hydrocarbon::$UNITS_ENTHALPY_COMBUSTION;
	}

}
