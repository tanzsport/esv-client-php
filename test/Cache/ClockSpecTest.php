<?php

namespace Tanzsport\ESV\API\Cache;

class ClockSpecTest extends \PHPUnit_Framework_TestCase
{

	private function assertInterval(\DateInterval $interval, $hours, $minutes)
	{
		$this->assertEquals(0, $interval->invert);
		$this->assertEquals(0, $interval->y);
		$this->assertEquals(0, $interval->m);
		$this->assertEquals(0, $interval->d);
		$this->assertEquals($hours, $interval->h);
		$this->assertEquals($minutes, $interval->i);
		$this->assertEquals(0, $interval->s);
	}

	/**
	 * @test
	 */
	public function calculatesInterval_SameTimezone()
	{
		$spec = new ClockSpec(8, 0);

		$now = new \DateTime('2000-01-01 07:01:00');
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 0, 59);

		$now = new \DateTime('2000-01-01 08:00:00');
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 0, 0);

		$now = new \DateTime('2000-01-01 08:01:00');
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 23, 59);
	}

	/**
	 * @test
	 */
	public function calculatesInterval_DifferentTimezone()
	{
		// 8 EET = 7 CET
		$spec = new ClockSpec(8, 0, new \DateTimeZone('Europe/Athens'));

		$tz = new \DateTimeZone('Europe/Berlin');

		$now = new \DateTime('2000-01-01 06:01:00', $tz);
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 0, 59);

		$now = new \DateTime('2000-01-01 07:00:00', $tz);
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 0, 0);

		$now = new \DateTime('2000-01-01 07:01:00', $tz);
		$interval = $spec->caculateIntervalToExpiry($now);
		$this->assertInterval($interval, 23, 59);
	}

	/**
	 * @test
	 */
	public function hasPassed_SameTimezone()
	{
		$tz = new \DateTimeZone('Europe/Berlin');
		$spec = new ClockSpec(8, 0, $tz);

		$now = new \DateTime('2000-01-01 07:00:00', $tz);
		$this->assertFalse($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 08:00:00', $tz);
		$this->assertFalse($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 08:00:01', $tz);
		$this->assertTrue($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 08:01:00', $tz);
		$this->assertTrue($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 09:00:00', $tz);
		$this->assertTrue($spec->hasPassed($now));
	}

	/**
	 * @test
	 */
	public function hasPassed_DifferentTimezone()
	{
		// 8 EET = 7 CET
		$spec = new ClockSpec(8, 0, new \DateTimeZone('Europe/Athens'));

		$now = new \DateTime('2000-01-01 06:00:00', new \DateTimeZone('Europe/Berlin'));
		$this->assertFalse($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 07:00:00', new \DateTimeZone('Europe/Berlin'));
		$this->assertFalse($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 07:01:00', new \DateTimeZone('Europe/Berlin'));
		$this->assertTrue($spec->hasPassed($now));

		$now = new \DateTime('2000-01-01 08:00:00', new \DateTimeZone('Europe/Berlin'));
		$this->assertTrue($spec->hasPassed($now));
	}
}
