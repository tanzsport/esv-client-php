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

namespace Tanzsport\ESV\API\Model\Veranstaltung;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Turnierstätte einer Turnierveranstaltung.
 *
 * @property-read string $name Name der Turnierstätte
 * @property-read string $anschrift Anschrift der Turnierstätte (Straße + Nr)
 * @property-read string $plz PLZ
 * @property-read string $ort Ort
 */
#[ExclusionPolicy('all')]
class Turnierstaette
{

	#[Type('string')]
	#[Expose]
	private string $name;

	#[Type('string')]
	#[Expose]
	private string $anschrift;

	#[Type('string')]
	#[Expose]
	private string $plz;

	#[Type('string')]
	#[Expose]
	private string $ort;

	public function __get(string $key): mixed
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return $this->$key;
			default:
				return null;
		}
	}

	public function __isset(string $key): bool
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return isset($this->$key);
			default:
				return false;
		}
	}
}
