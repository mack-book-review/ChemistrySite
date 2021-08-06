<?php

/** This helper class helps to generate questions that ask students to determine the amount (in kg) of a hydrocarbon that will be required to heat a given volume of water (in ml) from a random starting temperature to a random ending temperature **/
class ThermoQuestionMaker1 {

	private Hydrocarbon $hydrocarbon;

	public function __construct($u_hydrocarbon) {
		$this->hydrocarbon = $u_hydrocarbon;
	}

	//Returns the correct mass of the hydrocarbon (in kg) required to heat a given volume of water (in ml) from the starting temperature to the final temperature
	public function correct_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {

				return $this->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			}, function ($heat) {

				return $this->kilograms_required_for_heat($heat);
			});

	}

	/** Error-producing functions: the helper functions below are used to generate erroneous answer choices that are used to test students' ability to avoid common calculation mistakes **/
	public function error1_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,
			function ($delta_temp, $volume_ml) {

				return $this->generate_error1_heat_required_for_water_delta_temp($delta_temp, $volume_ml);

			}, function ($heat) {
				return $this->kilograms_required_for_heat($heat);
			});

	}

	public function error2_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {
				return $this->generate_error2_heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},

			function ($heat) {

				return $this->generate_error1_kilograms_required_for_heat($heat);
			}
		);

	}

	public function error3_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,
			function ($delta_temp, $volume_ml) {
				return $this->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},

			function ($heat) {

				return $this->generate_error1_kilograms_required_for_heat($heat);
			});

	}

	public function error4_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {
				return $this->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},
			function ($heat) {

				return $this->generate_error2_kilograms_required_for_heat($heat);
			}
		);

	}

	/**A helper function that produces other functions that can calculate the mass of the hydrocarbon required to heat a given amount of water.  The functions passed in as arguments can be error-producing functions that will yield a function that gives the wrong answer**/
	private function amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature, $fn1, $fn2) {

		$delta_temp = $final_temperature - $start_temperature;

		$heat = $fn1($delta_temp, $volume_ml);

		return $fn2($heat);
	}

	/** Returns the correct amount of heat required to raise a given volume of water (in ml) from a starting temp to a final temp, where delta_temp = final_temp - starting_temp **/
	private function heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000) * HydroCarbon::$SPECIFIC_HEAT_CAPACITY_WATER;
	}

	/** Returns the ERRONEOUS amount of heat required to raise a given volume of water (in ml) from a starting temp to a final temp, where delta_temp = final_temp - starting_temp **/

	private function generate_error1_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000) / 2 * HydroCarbon::$SPECIFIC_HEAT_CAPACITY_WATER;
	}

	private function generate_error2_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000);
	}

	/** This function generates the RIGHT answer in determining the correct mass required to produce the amount of heat passed in as an argument **/
	public function kilograms_required_for_heat($heat) {
		$moles = abs($heat / $this->hydrocarbon->get_standard_enthalpy_of_combustion());
		return $moles * $this->hydrocarbon->get_molar_mass();
	}

	/** These functions generate WRONG answers in determining the mass of a substance required to produce the amount of heat provided as input.  These function simulate common errors made by students so that they can be used to create erroneous answer choices **/
	private function generate_error1_kilograms_required_for_heat($heat) {

		$moles = abs($heat / $this->hydrocarbon->get_standard_enthalpy_of_combustion());
		return $moles * $this->hydrocarbon->get_err1_molar_mass();

	}

	private function generate_error2_kilograms_required_for_heat($heat) {

		$moles = abs($heat / $this->hydrocarbon->get_err1_standard_enthalpy_of_combustion());
		return $moles * $this->hydrocarbon->get_molar_mass();

	}

}

?>