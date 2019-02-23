<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2019 Deutscher Tanzsportverband e.V.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

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
