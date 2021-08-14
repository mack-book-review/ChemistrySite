<?php

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../classes/Alkanes.php";

final class AlkaneTest extends TestCase {

	public function testStringConversion(): void{

		$this->assertSame(strval(new Alkane(3)), "C<sub>3</sub>H<sub>8</sub>(g)");

	}

	public function testGetCommonAlkanes(): array{
		$arr = Alkane::GET_COMMON_ALKANES();

		$this->assertSame(count($arr), 10);

		return $arr;
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */

	public function testMolarMasses(array $alkanes): void{

		//Methane
		$mm1 = $alkanes[1]->get_molar_mass();
		$this->assertTrue($mm1 > 16.0 && $mm1 < 17.00);

		//Ethane
		$mm2 = $alkanes[2]->get_molar_mass();
		$this->assertTrue($mm2 > 30.0 && $mm2 < 31.00);

		//Propane
		$mm3 = $alkanes[3]->get_molar_mass();
		$this->assertTrue($mm3 > 44.0 && $mm3 < 45.00);

		//Butane
		$mm4 = $alkanes[4]->get_molar_mass();
		$this->assertTrue($mm4 > 58.0 && $mm4 < 59.00);
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */
	public function testNumberCarbons(array $arr) {

		$methane = $arr[1];
		$this->assertSame(1, $methane->get_number_carbons());

		$ethane = $arr[2];
		$this->assertSame(2, $ethane->get_number_carbons());
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */
	public function testNumberHydrogens(array $arr) {

		//Methane
		$methane = $arr[1];
		$this->assertSame(4, $methane->get_number_hydrogens());

		//Ethane
		$ethane = $arr[2];
		$this->assertSame(6, $ethane->get_number_hydrogens());
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */

	public function testEnthalpyCombustion(array $arr): void{

		//Methane
		$enth_comb1 = $arr[1]->get_standard_enthalpy_of_combustion();
		$this->assertTrue($enth_comb1 > -895.0 && $enth_comb1 < -885.0);

		//Ethane
		$enth_comb2 = $arr[2]->get_standard_enthalpy_of_combustion();
		$this->assertTrue($enth_comb2 > -1565.0 && $enth_comb2 < -1555.0);
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */

	public function testCommonNames(array $arr): void{

		$this->assertSame($arr[1]->get_common_name(), "methane");
		$this->assertSame($arr[2]->get_common_name(), "ethane");
		$this->assertSame($arr[3]->get_common_name(), "propane");
		$this->assertSame($arr[4]->get_common_name(), "butane");
		$this->assertSame($arr[5]->get_common_name(), "pentane");
		$this->assertSame($arr[6]->get_common_name(), "hexane");
		$this->assertSame($arr[7]->get_common_name(), "heptane");
		$this->assertSame($arr[8]->get_common_name(), "octane");
		$this->assertSame($arr[9]->get_common_name(), "nonane");
		$this->assertSame($arr[10]->get_common_name(), "decane");
	}

	/**
	 *	@depends testGetCommonAlkanes
	 */

	public function testGetStandardEnthalpyFormation(array $arr): void{

		/** Test Standard Enthalpy of Formation for Methane **/
		$methane = $arr[1];
		$methane_sef = $methane->get_standard_enthalpy_of_formation();

		$this->assertTrue($methane_sef < -74.0 && $methane_sef > -75.0);

		/** Test Standard Enthalpy of Formation for Ethane **/
		$ethane = $arr[2];
		$ethane_sef = $ethane->get_standard_enthalpy_of_formation();

		$this->assertTrue($ethane_sef < -83.0 && $ethane_sef > -85.0);

		/** Test Standard Enthalpy of Formation for Propane **/
		$propane = $arr[3];
		$propane_sef = $propane->get_standard_enthalpy_of_formation();

		$this->assertTrue($propane_sef < -103 && $propane_sef > -105);

		/** Test Standard Enthalpy of Formation for Butane **/
		$butane = $arr[4];
		$butane_sef = $butane->get_standard_enthalpy_of_formation();

		$this->assertTrue($butane_sef < -124.0 && $butane_sef > -126.0);

		/** Test Standard Enthalpy of Formation for Pentane **/
		$pentane = $arr[5];
		$pentane_sef = $pentane->get_standard_enthalpy_of_formation();

		$this->assertTrue($pentane_sef < -146.0 && $pentane_sef > -148.0);

		/** Test Standard Enthalpy of Formation for Hexane **/

	}
}