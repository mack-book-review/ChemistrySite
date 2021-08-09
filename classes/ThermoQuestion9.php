<?php

include "ErrorGenerator9.php";

//Problem 106
class ThermoQuestion9 extends QuizQuestion {

	static private float $HEAT_OF_FUSION_ICE = 6.01;
	static private float $MOLAR_MASS_WATER = 18.01;
	static private float $WATER_SPECIFIC_HEAT = 4.01;

	private float $gas_temp;
	private float $gas_vol;
	private float $water_vol;
	private float $gas_pressure_end;
	private float $gas_pressure_start;
	private float $water_start_temp;
	private float $water_end_temp_ideal;
	private float $water_end_temp_actual;

	private float $pressure;
	private Hydrocarbon $hydrocarbon;

	public function __construct($hydrocarbon) {
		$this->hydrocarbon = $hydrocarbon;
		$this->randomize_conditions();
		$this->set_water_end_temp_ideal();
		$this->set_water_end_temp_actual();
		$this->error_generator = new ErrorGenerator8();

		parent::__construct();

	}

	private function randomize_conditions() {
		$this->water_vol = rand(100, 200);
		$this->water_start_temp = rand(20, 30);
		$this->gas_vol = rand(100, 300);
		$this->gas_temp = rand(20, 40);
		$this->gas_pressure_start = rand(200, 400) / 100;
		$this->gas_pressure_end = rand(50, 200) / 100;

	}

	public function get_question_text() {
		$html = "Some of the " . $this->hydrocarbon->get_common_name() . " in a " . number_format($this->gas_vol, 1) . " L cylinder at " . number_format($this->gas_temp, 1) . "&deg;C is withdrawn and burned at a constant pressure in an excess of air.  As a result, the pressure in the cylinder falls from " . $this->gas_pressure_start . " atm to " . $this->gas_pressure_end . " atm.  The liberated heat is used to raise the temperature of " . number_format($this->water_vol, 1) . " L of water from " . number_format($this->water_start_temp, 1) . "&deg;C to " . number_format($this->water_end_temp_actual, 1) . "&deg;C.  Assume that the combustion products are CO<sub>2</sub>(g) and H<sub>2</sub>O(l) exclusively, and determine the efficiency of the water heater (That is, what percent of the heat of combustion was absorbed by the water).  ";

		return $html;
	}

	private function get_heat_released() {
		$gas_moles_start = GasCalculator::Get_Total_Moles_of_Gas($this->gas_vol, $this->gas_temp + 273, $this->gas_pressure_start);

		$gas_moles_end = ($this->gas_pressure_end / $this->gas_pressure_start) * $gas_moles_start;

		$gas_moles_burned = $gas_moles_start - $gas_moles_end;

		return $this->hydrocarbon->get_standard_enthalpy_of_combustion() * $gas_moles_burned / 1000;

	}

	private function set_water_end_temp_ideal() {
		$temp_change = (abs($this->get_heat_released()) / ThermoQuestion9::$WATER_SPECIFIC_HEAT) * ($this->water_vol * 1.01);
		$this->water_end_temp_ideal = $this->water_start_temp + $temp_change;

	}

	private function set_water_end_temp_actual() {
		$temp_change_ideal = $this->water_end_temp_ideal - $this->water_start_temp;

		$actual_temp_change = $temp_change_ideal * (rand(50, 90) / 100);

		$this->water_end_temp_actual = $this->water_start_temp + $actual_temp_change;
	}

	public function get_question_id() {
		$rand_num = rand(1000, 9999);
		return $rand_num;
	}

	protected function get_erroneous_answers() {
		return [
			number_format($this->get_correct_answer_numerical() * .5, 1) . "%",
			number_format($this->get_correct_answer_numerical() * 1.5, 1) . "%",
			number_format($this->get_correct_answer_numerical() * 0.3, 1) . "%",
			number_format($this->get_correct_answer_numerical() * 1.8, 1) . "%",
		];
	}

	public function get_correct_answer_numerical() {
		$delta_temp_ideal = $this->water_end_temp_ideal - $this->water_start_temp;

		$delta_temp_actual = $this->water_end_temp_actual - $this->water_start_temp;

		return $delta_temp_actual / $delta_temp_ideal;
	}
	public function get_correct_answer() {
		$correct_answer = $this->get_correct_answer_numerical();
		return number_format($correct_answer, 2) . " " . "%";
	}
}