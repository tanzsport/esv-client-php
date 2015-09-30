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

namespace Tanzsport\ESV\API\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;
use Tanzsport\ESV\API\Konstanten;

/**
 * Person als Bestandteil eines Starters.
 *
 * @package Tanzsport\ESV\API\Model
 * @property-read string $id DTV-ID
 * @property-read string $titel Titel
 * @property-read string $vorname Vorname
 * @property-read string $nachname Nachname
 * @property-read boolean $maennlich Person männlich ja/nein
 * @property-read int $wdsfMin WDSF-MIN
 * @property-read string $nationalitaet Staatsangehörigkeit der Person
 *
 * @ExclusionPolicy("all")
 */
class Person
{

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $id;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $titel;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $vorname;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $nachname;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $geschlecht;

	/**
	 * @var int
	 * @Type("integer")
	 * @SerializedName("wdsfMin")
	 * @Expose
	 */
	private $wdsfMin;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $nationalitaet;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'wdsfMin':
			case 'nationalitaet':
				return $this->$key;
			case 'maennlich':
				return $this->isMaennlich();
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'wdsfMin':
			case 'nationalitaet':
				return isset($this->$key);
		}
	}

	private function isMaennlich()
	{
		return strtolower($this->geschlecht) == Konstanten::GESCHLECHT_M;
	}
}
