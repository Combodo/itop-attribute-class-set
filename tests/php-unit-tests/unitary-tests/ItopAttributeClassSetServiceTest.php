<?php
/**
 * @copyright   Copyright (C) 2010-2024 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */
namespace Combodo\iTop\ItopAttributeClassSet\Test;

use Combodo\iTop\Test\UnitTest\ItopDataTestCase;

class ItopAttributeClassSetServiceTest extends ItopDataTestCase
{
	public function setUp(): void
	{
		parent::setUp();
		$this->RequireOnceItopFile('/env-production/itop-attribute-class-set/vendor/autoload.php');
	}

	public function testDummy()
	{
		$this->assertEquals(1, 1);
	}
}