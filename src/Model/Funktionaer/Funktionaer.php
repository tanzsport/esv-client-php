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

namespace Tanzsport\ESV\API\Model\Funktionaer;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;
use Tanzsport\ESV\API\Model\Club;

/**
 * Funktionär.
 *
 * @property-read string $id DTV-ID
 * @property-read int|null $wdsfMin WDSF-MIN (<code>NULL</code> falls nicht vorhanden)
 * @property-read int|null $lizenzNr alte Lizenz-Nr. des Funktionärs (<code>NULL</code> falls nicht vorhanden)
 * @property-read string|null $titel Titel
 * @property-read string $vorname Vorname
 * @property-read string $nachname Nachname
 * @property-read Club $club Verein des Funktion&auml;rs
 * @property-read string $staat Staat, für den der Funktionär aktiv ist
 * @property-read array $lizenzen IDs aller aktiven Lizenzen des Funktionärs
 */
#[ExclusionPolicy('all')]
class Funktionaer
{
	#[Type('string')]
	#[Expose]
	private string $id;

	#[Type('integer')]
	#[SerializedName('wdsfMin')]
	#[Expose]
	private ?int $wdsfMin = null;

	#[Type('integer')]
	#[SerializedName('lizenzNr')]
	#[Expose]
	private ?int $lizenzNr = null;

	#[Type('string')]
	#[Expose]
	private ?string $titel = null;

	#[Type('string')]
	#[Expose]
	private string $vorname;

	#[Type('string')]
	#[Expose]
	private string $nachname;

	#[Type('Tanzsport\ESV\API\Model\Club')]
	#[Expose]
	private Club $club;

	#[Type('string')]
	#[Expose]
	private string $staat;

	/**
	 * @var array<string>
	 */
	#[Type('array<string>')]
	#[Expose]
	private array $lizenzen = [];

	public function __get(string $key): mixed
	{
		switch ($key) {
			case 'id':
			case 'wdsfMin':
			case 'lizenzNr':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'club':
			case 'staat':
				return $this->$key;
			case 'lizenzen':
				return $this->$key != null ? $this->$key : array();
			default:
				return null;
		}
	}

	public function __isset(string $key): bool
	{
		switch ($key) {
			case 'id':
			case 'wdsfMin':
			case 'lizenzNr':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'club':
			case 'staat':
			case 'lizenzen':
				return isset($this->$key);
			default:
				return false;
		}
	}
}
