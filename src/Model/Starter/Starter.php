<?php

/*
 * Copyright (c) 2015 Deutscher Tanzsportverband e.V.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Tanzsport\ESV\API\Model\Starter;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Tanzsport\ESV\API\Model\Club;
use Tanzsport\ESV\API\Model\Person;

/**
 * Basis-Klasse für Starter.
 *
 * @package Tanzsport\ESV\API\Model\Starter
 * @property-read int $id ID des Starters
 * @property-read Club $club Verein des Starters
 * @property-read string $staat Staat, für den der Starter startet
 *
 * @ExclusionPolicy("all")
 */
class Starter
{

	/**
	 * @var int
	 * @Type("integer")
	 * @Expose
	 */
	private $id;

	/**
	 * @var Person[]
	 * @Type("array<Tanzsport\ESV\API\Model\Person>")
	 * @Expose
	 */
	private $personen;

	/**
	 * @var Club
	 * @Type("Tanzsport\ESV\API\Model\Club")
	 * @Expose
	 */
	private $club;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $staat;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'club':
			case 'staat':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'club':
			case 'staat':
				return isset($this->$key);
		}
	}

	protected function getPerson($i)
	{
		if (!isset($this->personen[$i])) {
			throw new \InvalidArgumentException("Person mit Index {$i} ist nicht vorhanden.");
		}
		return $this->personen[$i];
	}

	protected function personExists($i)
	{
		return isset($this->personen[$i]);
	}
}
