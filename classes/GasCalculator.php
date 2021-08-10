<?php

class GasCalculator {

	//L-atm/mol-K
	public static $Gas_Constant1 = .0821;
	//
	public static $Gas_Constant2 = 8.314;

	public static function Get_Moles_Of_Gas($volume, $temperature, $pressure) {
		return ($pressure * $volume) / ($temperature * GasCalculator::$Gas_Constant1);

	}

	public static function Get_Total_Moles_of_Gas($volume, $temperature, $pressure) {
		return ($pressure * $volume) / ($temperature * GasCalculator::$Gas_Constant1);
	}

	public static function Get_Pressure_Of_Gas($volume, $temperature, $moles) {

	}

	//pressure must be givein in atm, temperature in K
	public static function Get_Volume_Of_Gas($pressure, $temperature, $moles) {

		return ($moles * GasCalculator::$Gas_Constant1 * $temperature) / $pressure;
	}

	//pressure must be givein in atm, temperature in K
	public static function Get_Volume_Of_Gas2($pressure, $temperature, $moles) {

		return ($moles * GasCalculator::$Gas_Constant2 * $temperature) / $pressure;
	}

}