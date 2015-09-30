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

namespace Tanzsport\ESV\API\Model\Veranstaltung;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Turnierstätte einer Turnierveranstaltung.
 *
 * @package Tanzsport\ESV\API\Model\Veranstaltung
 * @property-read $name string Name der Turnierstätte
 * @property-read $anschrift string Anschrift der Turnierstätte (Straße + Nr)
 * @property-read $plz string PLZ
 * @property-read $ort string Ort
 *
 * @ExclusionPolicy("all")
 */
class Turnierstaette
{

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $name;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $anschrift;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $plz;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $ort;

	public function __get($key)
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return isset($this->$key);
		}
	}
}
