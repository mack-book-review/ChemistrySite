<?php 

class GasMixture{

	private $component_percents = array();
	private $partial_moles = array();

	function __construct($u_component_percents){
		if(GasMixture::Is_Valid_Mixture($u_component_percents)){
			$this->component_percents = $u_component_percents;
		}
	}

	public function get_total_heat_of_combustion(){
		$total_heat_released = 0;

		foreach($this->partial_moles as $component => $mole_amount){

			$heat_released = $component->get_standard_enthalpy_of_combustion()*$mole_amount;
			$total_heat_released += $heat_released;
		}

		return $total_heat_released;
	}

	//the percent of each component is by mole
	public function Get_Total_Moles($pressure,$volume,$temperature){
		return 1.0;
	}

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
}
?>