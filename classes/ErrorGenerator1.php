<?php

class ErrorGenerator1 {

	private Hydrocarbon $hydrocarbon;
	private ThermoQuestionMaker1 $thermoquestionmaker1;

	public function __construct($u_hydrocarbon, $u_thermoquestionmaker1) {

		$this->hydrocarbon = $u_hydrocarbon;

		$this->thermoquestionmaker1 = $u_thermoquestionmaker1;
	}

	//Returns the correct mass of the hydrocarbon (in kg) required to heat a given volume of water (in ml) from the starting temperature to the final temperature
	public function correct_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {

				return $this->thermoquestionmaker1->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
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

		return $this->thermoquestionmaker1->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {
				return $this->generate_error2_heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},

			function ($heat) {

				return $this->generate_error1_kilograms_required_for_heat($heat);
			}
		);

	}

	public function error3_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->thermoquestionmaker1->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,
			function ($delta_temp, $volume_ml) {
				return $this->thermoquestionmaker1->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},

			function ($heat) {

				return $this->thermoquestionmaker1->generate_error1_kilograms_required_for_heat($heat);
			});

	}

	public function error4_amount_required_to_heat_water($volume_ml, $start_temperature, $final_temperature) {

		return $this->thermoquestionmaker1->amount_required_to_heat_water_question_maker($volume_ml, $start_temperature, $final_temperature,

			function ($delta_temp, $volume_ml) {
				return $this->thermoquestionmaker1->heat_required_for_water_delta_temp($delta_temp, $volume_ml);
			},
			function ($heat) {

				return $this->thermoquestionmaker1->generate_error2_kilograms_required_for_heat($heat);
			}
		);

	}

	/** Returns the ERRONEOUS amount of heat required to raise a given volume of water (in ml) from a starting temp to a final temp, where delta_temp = final_temp - starting_temp **/

	private function generate_error1_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000) / 2 * HydroCarbon::$SPECIFIC_HEAT_CAPACITY_WATER;
	}

	private function generate_error2_heat_required_for_water_delta_temp($delta_temp, $volume_ml) {
		return $delta_temp * ($volume_ml / 1000);
	}

}