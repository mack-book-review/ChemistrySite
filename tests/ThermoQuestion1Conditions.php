<?php

class ThermoQuestion1Conditions implements Iterator {

	private $position = 0;

	private $array = array();

	private function populate_array() {
		$rand_start_temp = rand(10, 50);
		$rand_end_temp = rand($rand_start_temp, $rand_start_temp + 50);
		$vol_water_ml = rand(10, 5000);

		$this->array = [
			$rand_start_temp,
			$rand_end_temp,
			$vol_water_ml,
		];
	}

	public function __construct() {
		$this->position = 0;
		$this->populate_array();
	}

	public function rewind() {
		var_dump(__METHOD__);
		$this->position = 0;
	}

	public function current() {
		var_dump(__METHOD__);
		return $this->array[$this->position];
	}

	public function key() {
		var_dump(__METHOD__);
		return $this->position;
	}

	public function next() {
		var_dump(__METHOD__);
		++$this->position;
	}

	public function valid() {
		var_dump(__METHOD__);
		return isset($this->array[$this->position]);
	}
}