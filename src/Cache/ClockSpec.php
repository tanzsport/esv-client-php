<?php

namespace Tanzsport\ESV\API\Cache;

class ClockSpec
{

	/**
	 * @var int
	 */
	private $hour;

	/**
	 * @var int
	 */
	private $minute;

	/**
	 * @var \DateTimeZone
	 */
	private $timeZone;

	public function __construct($hour, $minute, \DateTimeZone $timeZone = null)
	{
		if ($hour === null) {
			throw new \InvalidArgumentException('Stunde erforderlich!');
		}
		if ($minute === null) {
			throw new \InvalidArgumentException('Minute erforderlich!');
		}

		$hour = intval($hour);
		if ($hour < 0 || $hour > 23) {
			throw new \InvalidArgumentException('Stunde muss zwischen 0 und 23 liegen!');
		}
		$minute = intval($minute);
		if ($minute < 0 || $minute > 59) {
			throw new \InvalidArgumentException('Minute muss zwischen 0 und 50 liegen!');
		}

		$this->hour = $hour;
		$this->minute = $minute;
		$this->timeZone = $timeZone ?: new \DateTimeZone(date_default_timezone_get());
	}

	/**
	 * @param \DateTimeInterface|null $now
	 * @return \DateInterval
	 * @throws \Exception
	 */
	public function caculateIntervalToExpiry(\DateTimeInterface $now = null)
	{
		$now = $now ? $this->createImmutable($now) : $this->now();

		if ($this->hasPassed($now)) {
			$to = $now->add(new \DateInterval('P1D'))->setTime($this->hour, $this->minute, 0);
		} else {
			$to = $now->setTime($this->hour, $this->minute, 0);
		}

		return $now->diff($to);
	}

	/**
	 * @param \DateTimeInterface|null $now
	 * @return bool
	 */
	public function hasPassed(\DateTimeInterface $now = null)
	{
		$now = $now ? $this->createImmutable($now) : $this->now();

		$minutesDifference = $this->minute - intval($now->format('i'));
		if ($minutesDifference < 0) {
			$minutesPassed = true;
		} else if ($minutesDifference == 0) {
			$minutesPassed = intval($now->format('s')) > 0;
		} else {
			$minutesPassed = false;
		}

		$hoursDifference = $this->hour - intval($now->format('G'));
		if ($hoursDifference < 0) {
			return true;
		} else if ($hoursDifference == 0) {
			return $minutesPassed;
		} else {
			return false;
		}
	}

	private function createImmutable(\DateTimeInterface $input)
	{
		return \DateTimeImmutable::createFromMutable($input)->setTimezone($this->timeZone);
	}

	private function now()
	{
		return (new \DateTime('now'))->setTimezone($this->timeZone);
	}
}
