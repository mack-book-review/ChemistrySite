<?php

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../classes/ThermoQuestion1.php";

final class ThermoQuestion1Test extends TestCase {

	public function testCorrectAnswerNumerical(): void{

		$q1 = ThermoQuestion1::MakeThermoQuestion1WithSpecificAlkaneAndSpecificConditions(2, 20.00, 25.1, 34.2);

		$a = $q1->get_correct_answer_numerical();

		$this->assertTrue($a > 0.0146 && $a < 0.0147);

	}

}