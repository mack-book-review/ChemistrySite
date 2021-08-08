
<?php

class Precipitate implements ErrorGeneratorInterface {

	public static function GET_RANDOM_PRECIPITATE() {
		$PRECIPITATE_DATA = array(
			new Precipitate("barium sulfate", "BaSO<sub>4</sub>(s)", -1473.0, 1, 1, -537.6, -909.3),
			new Precipitate("silver iodide", "AgI(s)", -61.84, 1, 1, 105.6, -55.19),
			new Precipitate("silver carbonate", "Ag<sub>2</sub>CO<sub>3</sub>", -39.9, 2, 3, 105.6, -677.1),
		);

		$rand_key = array_rand($PRECIPITATE_DATA);
		return $PRECIPITATE_DATA[$rand_key];

	}

	private float $cation_enth_formation;
	private float $anion_enth_formation;
	private int $number_cation;
	private int $number_anion;
	private string $name;
	private string $formula;
	private float $standard_enthalpy_formation;

	public function __construct(
		$name,
		$formula,
		$standard_enthalpy_formation,
		$number_cation,
		$number_anion,
		$cation_enth_formation,
		$anion_enth_formation) {

		$this->$name = $name;
		$this->$formula = $formula;
		$this->$standard_enthalpy_formation = $standard_enthalpy_formation;

		$this->$cation_enth_formation = $cation_enth_formation;
		$this->$anion_enth_formation = $anion_enth_formation;

		$this->$number_cation = $number_cation;
		$this->$number_anion = $number_anion;

	}

	public function get_name() {
		return $this->name;
	}

	public function get_formula() {
		return $this->formula;
	}

	public function get_standard_enthalpy_of_formation() {
		return $this->standard_enthalpy_formation;
	}

	public function get_cation_standard_enthalpy_of_formation() {
		return $this->cation_enth_formation;
	}

	public function get_anion_standard_enthalpy_of_formation() {
		return $this->anion_enth_formation;
	}

	public function get_enthalpy_of_precipitation() {
		return $this->standard_enthalpy_formation - ($this->number_cation * $this->cation_enth_formation + $this->number_anion * $this->anion_enth_formation);
	}

	public function get_err1() {
		return $this->standard_enthalpy_formation - ($this->cation_enth_formation + $this->anion_enth_formation);
	}

	public function get_err2() {
		return $this->standard_enthalpy_formation - ($this->number_cation * $this->cation_enth_formation + $this->anion_enth_formation);
	}

	public function get_err3() {
		return $this->standard_enthalpy_formation - ($this->cation_enth_formation + $this->number_anion * $this->anion_enth_formation);
	}

	public function get_err4() {
		return $this->number_cation * $this->standard_enthalpy_formation - ($this->number_cation * $this->cation_enth_formation + $this->number_anion * $this->anion_enth_formation);
	}

	public function __toString() {
		return $this->formula;
	}
}

class ThermoQuestion12 extends QuizQuestion {

	private Precipitate $precipitate;

	public function __construct() {
		$this->randomize_precipitate_info();
		$this->error_generator = $this->precipitate;
		parent::__construct("../img/table_7-3.png");
	}

	private function randomize_precipitate_info() {

		$this->precipitate = Precipitate::GET_RANDOM_PRECIPITATE();

	}

	public function get_question_text() {
		$html = "Given that &delta;H<sub>f<sub>&deg; [" . $this->precipitate->formula . "] = " . $this->precipitate->standard_enthalpy_formation . " kJ/mol, what is the standard enthalpy change for the precipitation of " . $this->precipitate->name . "? Use the table below to help you determine the correct answer:";

		$html .= "<img src='" . $this->img_path . "' id='question" . $this->get_question_id() . "' style='display:block;width:30em;height:auto;margin-bottom:2em;'>";

		$html .= "<br>";

		return $html;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			round($this->error_generator->get_err1(), 2) . " kJ/mol",
			round($this->error_generator->get_err2(), 2) . " kJ/mol",
			round($this->error_generator->get_err3(), 2) . " kJ/mol",
			round($this->error_generator->get_err4(), 2) . " kJ/mol"];
	}

	public function get_correct_answer() {
		$correct_answer = $this->precipitate->get_enthalpy_of_precipitation();
		return strval(round($correct_answer, 2)) . " kJ/mol";
	}

}
