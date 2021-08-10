<?php

class GasMixture {

	static public function Is_Valid_Mixture($component_percents) {

		$total_percent = 0.0;
		foreach ($component_percents as $percent => $component) {

			//Check that each component is a HydroCarbon or a child of the HydroCarbon class
			if (get_class($component) != 'HydroCarbon' || get_parent_class($component) != 'HydroCarbon') {
				return false;
			}
			$total_percent += $percent;
		}

		//Make sure that all percents add up to 1.0
		return $total_percent == 1.0;
	}

	private $temperature;
	private $pressure;
	private $volume;

	//Not finished
	private function generate_random_component_percents() {

		$num1 = rand(50, 100);
		$num2 = rand(50, 100);
		$num3 = rand(50, 100);
		$total = $num1 + $num2 + $num3;

		$percent1 = $num1 / $total;
		$percent2 = $num2 / $total;
		$percent3 = $num3 / $total;

		$rand_alkane1 = new Alkane(rand(1, 2));
		$rand_alkane2 = new Alkane(rand(3, 5));
		$rand_alkane3 = new Alkane(rand(6, 8));

		return [
			[
				"alkane" => $rand_alkane1,
				"percent" => round($percent1, 2),

			],

			[
				"alkane" => $rand_alkane2,
				"percent" => round($percent2, 2),

			],

			[
				"alkane" => $rand_alkane3,
				"percent" => round($percent3, 2),

			],

		];
	}

	function __construct($pressure = null, $temperature = null, $volume = null, $u_component_percents = null) {
		if (isset($u_component_percents) && !empty($u_component_percents) && GasMixture::Is_Valid_Mixture($u_component_percents)) {
			$this->component_percents = $u_component_percents;
		} else {
			$this->component_percents = $this->generate_random_component_percents();
		}

		if ($pressure != null) {
			$this->pressure = $pressure;
		} else {
			$this->randomize_pressure();
		}

		if ($temperature != null) {
			$this->temperature = $temperature;

		} else {
			$this->randomize_temperature();

		}

		if ($volume != null) {
			$this->volume = $volume;
		} else {
			$this->randomize_volume();
		}
	}

	private function randomize_pressure() {
		$this->pressure = rand(1, 5);
	}

	private function randomize_volume() {
		$this->volume = rand(1, 100);
	}

	private function randomize_temperature() {
		$this->temperature = rand(25, 50);
	}

	public function get_volume_liters() {
		return $this->volume;
	}

	public function get_temperature_celsius() {
		return $this->temperature;
	}

	public function get_pressure_mmHg() {
		return $this->pressure;
	}

	function __toString() {

		$html = "";

		$arr = $this->component_percents;

		for ($i = 0; $i < count($arr) - 1; $i++) {

			$html .= strval(100 * $arr[$i]['percent']) . "% " . strval($arr[$i]['alkane']);

			$html .= ", ";

		}

		$last_index = count($arr) - 1;

		$html .= " and ";

		$html .= strval(100 * $arr[$last_index]['percent']) . "% " . strval($arr[$last_index]['alkane']);

		return $html;
	}

	public function get_total_heat_of_combustion() {

		$total_moles = GasCalculator::Get_Total_Moles_of_Gas($this->volume, $this->temperature, $this->pressure);

		$total_heat_released = 0;

		foreach ($this->component_percents as $arr) {

			$mole_amount = $total_moles * $arr['percent'];

			$heat_released = $arr['alkane']->get_standard_enthalpy_of_combustion() * $mole_amount;

			$total_heat_released += $heat_released;
		}

		return $total_heat_released;
	}

}
?>