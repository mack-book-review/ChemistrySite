<?php

class GasCalculator {

	//L-atm/mol-K
	public static float $Gas_Constant1 = .0821;

	public static function Get_Moles_Of_Gas($volume, $temperature, $pressure) {

	}

	public static function Get_Pressure_Of_Gas($volume, $temperature, $moles) {

	}

	//pressure must be givein in atm, temperature in K
	public static function Get_Volume_Of_Gas($pressure, $temperature, $moles) {

		if ($pressure == 0) {
			$pressure = 0.1;
		}

		return ($moles * GasCalculator::$Gas_Constant1 * $temperature) / $pressure;
	}

}