<?php 

includ "GasCalculator.php";

class GasMixture{

	

	public function static Is_Valid_Mixture($component_percentages){

		$total_percent = 0.0;
		foreach($component_percents as $component => $percent){

			//Check that each component is a HydroCarbon or a child of the HydroCarbon class
			if(get_class($component) != 'HydroCarbon' || get_parent_class($component) != 'HydroCarbon'){
				return false;
			}
			$total_percent += $percent;
		}

		//Make sure that all percents add up to 1.0
		return $total_percent == 1.0;
	}

	private $component_percents_by_mole = array();
	private float $temperature;
	private float $pressure;
	private float $volume;

	//Not finished
	private function generate_random_component_percents(){
		$component_percents = [];

		$percent1 = rand();
		$temp = 1 - $percent1;

		$percent2 = rand()*$temp;
		$percent3 = 1-$percent2;
	}

	function __construct($u_component_percents,$pressure,$temperature,$volume){
		if(GasMixture::Is_Valid_Mixture($u_component_percents)){
			$this->component_percents = $this->generate_random_component_percents();
		}
	}

	public function get_volume_liters(){
		return $this->volume;
	}

	public function get_temperature_celsius(){
		return $this->temperature;
	}

	public function get_pressure_mmHg(){
		return $this->pressure;
	}

	//not finished
	function __toString(){

		$html = "";
		$str_parts = [];
		foreach($this->component_percents as $component => $percent){

			$str_parts[] = 100*$percent . "% " . $component;
		
		}

		$length = count($str_parts);


		return $html;
	}

	public function get_total_heat_of_combustion(){

		$total_moles = GasCalculator::Get_Total_Moles_of_Gas($this->volume,$this->temperature,$this->pressure);

		$total_heat_released = 0;

		foreach($this->component_percents as $component => $percent){

			$mole_amount = $total_moles*$percent;

			$heat_released = $component->get_standard_enthalpy_of_combustion()*$mole_amount;

			$total_heat_released += $heat_released;
		}

		return $total_heat_released;
	}

	

	
}
?>