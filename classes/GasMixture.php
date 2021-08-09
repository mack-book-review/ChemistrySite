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

	private float $temperature;
	private float $pressure;
	private float $volume;

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
			$percent1 => $rand_alkane1,
			$percent2 => $rand_alkane2,
			$percent3 => $rand_alkane3,

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

		foreach ($this->component_percents as $percent => $component) {

			$html .= strval(100 * $percent) . "% " . strval($component) . "\r\n";

		}

		return $html;
	}

	public function get_total_heat_of_combustion() {

		$total_moles = GasCalculator::Get_Total_Moles_of_Gas($this->volume, $this->temperature, $this->pressure);

		$total_heat_released = 0;

		foreach ($this->component_percents as $percent => $component) {

			$mole_amount = $total_moles * $percent;

			$heat_released = $component->get_standard_enthalpy_of_combustion() * $mole_amount;

			$total_heat_released += $heat_released;
		}

		return $total_heat_released;
	}

}
?>