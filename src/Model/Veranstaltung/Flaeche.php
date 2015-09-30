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
 * Fläche einer Turnierveranstaltung.
 *
 * @package Tanzsport\ESV\API\Model\Veranstaltung
 * @property-read string $id ID
 * @property-read string $typ Flächentyp
 * @property-read float $laenge Flächenlänge
 * @property-read float $breite Flächenbreite
 *
 * @ExclusionPolicy("all")
 */
class Flaeche
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
	private $typ;

	/**
	 * @var float
	 * @Type("double")
	 * @Expose
	 */
	private $laenge;

	/**
	 * @var float
	 * @Type("double")
	 * @Expose
	 */
	private $breite;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'typ':
			case 'laenge':
			case 'breite':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'typ':
			case 'laenge':
			case 'breite':
				return isset($this->$key);
		}
	}

}
