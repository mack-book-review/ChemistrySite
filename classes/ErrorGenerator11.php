<?php

class ErrorGenerator11 {

	private float $temperature;
	private float $number_moles;
	private float $pressure_final;
	private float $pressure_initial;

	public function __construct($pressure_initial, $pressure_final, $number_moles, $temperature) {
		$this->temperature = $temperature;
		$this->pressure_initial = $pressure_initial;
		$this->pressure_final = $pressure_final;
		$this->number_moles = $number_moles;
	}

	public function get_err1() {

	}

	public function get_err2() {

	}

	public function get_err3() {

	}

	public function get_err4() {

	}

}