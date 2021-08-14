<?php

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../classes/ThermoQuestion1.php";

final class ThermoQuestion1Test extends TestCase {

	public function functionTestAnswerChoices(): void{

		$q1 = ThermoQuestion1::MakeThermoQuestion1WithRandomAlkaneAndRandomConditions();

		$choices = $q1->get_choices();

		$this->assertTrue($choice['A'] != null);
		$this->assertTrue($choice['B'] != null);
		$this->assertTrue($choice['C'] != null);
		$this->assertTrue($choice['D'] != null);

	}

	public function conditionsProvider(): array{

		return [
			'ethane and temperature increase' => [2, 20.00, 25.1, 34.2, 0.0146, 0.0147],
		];

	}

	/**
	 * 		@dataProvider conditionsProvider
	 * */
	public function testCorrectAnswerNumerical($number_carbons, $vol_water_ml, $start_temp, $end_temp, $expected_min, $expected_max): void{

		$q1 = ThermoQuestion1::MakeThermoQuestion1WithSpecificAlkaneAndSpecificConditions($number_carbons, $vol_water_ml, $start_temp, $end_temp);

		$a = $q1->get_correct_answer_numerical();

		$this->assertTrue($a > $expected_min && $a < $expected_max);

	}

}