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
use JMS\Serializer\Annotation\SerializedName;
use Tanzsport\ESV\API\Model\Club;
use Tanzsport\ESV\API\Model\Funktionaer\Funktionaer;

/**
 * Vollständige Daten einer Turnierveranstaltung.
 *
 * @property-read int $id
 * @property-read \DateTime $datumVon Beginndatum der Veranstaltung
 * @property-read \DateTime $datumBis Enddatum der Veranstaltung
 * @property-read Turnierstaette $turnierstaette Turnierstätte
 * @property-read Club $veranstalter Veranstalter
 * @property-read Club $ausrichter Ausrichter
 * @property-read string|null $titel Titel
 * @property-read string|null $bemerkung Bemerkungen
 * @property-read array<Funktionaer> $wertungsrichter Wertungsrichter der Veranstaltung
 * @property-read array<Funktionaer> $funktionaer Turnierfunktionäre der Veranstaltung
 * @property-read array<Flaeche> $flaechen Turnierflächen
 * @property-read array<Turnier> $turniere Turniere
 */
#[ExclusionPolicy('all')]
class VeranstaltungMitTurnieren
{

	#[Type('integer')]
	#[Expose]
	private int $id;

	#[Type('DateTime')]
	#[SerializedName('datumVon')]
	#[Expose]
	private \DateTime $datumVon;

	#[Type('DateTime')]
	#[SerializedName('datumBis')]
	#[Expose]
	private \DateTime $datumBis;

	#[Type('Tanzsport\ESV\API\Model\Veranstaltung\Turnierstaette')]
	#[Expose]
	private Turnierstaette $turnierstaette;

	#[Type('Tanzsport\ESV\API\Model\Club')]
	#[Expose]
	private Club $veranstalter;

	#[Type('Tanzsport\ESV\API\Model\Club')]
	#[Expose]
	private Club $ausrichter;

	#[Type('string')]
	#[Expose]
	private ?string $titel = null;

	#[Type('string')]
	#[Expose]
	private ?string $bemerkung = null;

	/**
	 * @var array<Funktionaer>
	 */
	#[Type('array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>')]
	#[Expose]
	private array $wertungsrichter = [];

	/**
	 * @var array<Funktionaer>
	 */
	#[Type('array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>')]
	#[Expose]
	private array $funktionaere = [];

	/**
	 * @var array<Flaeche>
	 */
	#[Type('array<Tanzsport\ESV\API\Model\Veranstaltung\Flaeche>')]
	#[Expose]
	private array $flaechen = [];

	/**
	 * @var array<Turnier>
	 */
	#[Type('array<Tanzsport\ESV\API\Model\Veranstaltung\Turnier>')]
	#[Expose]
	private array $turniere = [];

	public function __get(string $key): mixed
	{
		switch ($key) {
			case 'id':
			case 'datumVon':
			case 'datumBis':
			case 'turnierstaette':
			case 'veranstalter':
			case 'ausrichter':
			case 'titel':
			case 'bemerkung':
			case 'wertungsrichter':
			case 'funktionaere':
			case 'flaechen':
			case 'turniere':
				return $this->$key;
			default:
				return null;
		}
	}

	public function __isset(string $key): bool
	{
		switch ($key) {
			case 'id':
			case 'datumVon':
			case 'datumBis':
			case 'turnierstaette':
			case 'veranstalter':
			case 'ausrichter':
			case 'titel':
			case 'bemerkung':
			case 'wertungsrichter':
			case 'funktionaere':
			case 'flaechen':
			case 'turniere':
				return isset($this->$key);
			default:
				return false;
		}
	}
}
