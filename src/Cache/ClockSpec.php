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

	public function __construct($hour, $minute)
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
	}

	/**
	 * @param \DateTimeInterface|null $from
	 * @return \DateInterval
	 * @throws \Exception
	 */
	public function caculateIntervalFrom(\DateTimeInterface $from = null)
	{
		$from = $from ? \DateTimeImmutable::createFromMutable($from) : new \DateTimeImmutable();
		$to = $from->add(new \DateInterval('P1D'))->setTime($this->hour, $this->minute);

		return $from->diff($to);
	}
}
