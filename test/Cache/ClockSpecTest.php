<?php

namespace Tanzsport\ESV\API\Cache;

class ClockSpecTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @test
	 */
	public function calculatesInterval_OtherClock_InSameTz()
	{
		$spec = new ClockSpec(8, 0);

		$from = new \DateTime('2000-01-01 14:01:00');
		$interval = $spec->caculateIntervalFrom($from);

		$this->assertEquals(0, $interval->invert);
		$this->assertEquals(0, $interval->y);
		$this->assertEquals(0, $interval->m);
		$this->assertEquals(0, $interval->d);
		$this->assertEquals(17, $interval->h);
		$this->assertEquals(59, $interval->i);
		$this->assertEquals(0, $interval->s);
	}

	/**
	 * @test
	 */
	public function calculatesInterval_SameClock_InSameTz()
	{
		$spec = new ClockSpec(8, 0);

		$from = new \DateTime('2000-01-01 08:00:00');
		$interval = $spec->caculateIntervalFrom($from);

		$this->assertEquals(0, $interval->invert);
		$this->assertEquals(0, $interval->y);
		$this->assertEquals(0, $interval->m);
		$this->assertEquals(1, $interval->d);
		$this->assertEquals(0, $interval->h);
		$this->assertEquals(0, $interval->i);
		$this->assertEquals(0, $interval->s);
	}
}
