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

/**
 * Turnier in einer Turnierveranstaltung.
 *
 * @property-read int $id ID
 * @property-read \DateTime $datumVon Beginndatum Turnier
 * @property-read \DateTime $datumBis Enddatum Turnier
 * @property-read string $startzeitPlan geplante Startzeit
 * @property-read string|null $startzeitPlanKorrigiert korrigierte Plan-Startzeit
 * @property-read string|null $titel Turniertitel
 * @property-read Club|null $veranstalter Turnierveranstalter
 * @property-read Club|null $ausrichter Turnierausrichter
 * @property-read string|null $flaechenId ID der Fläche
 * @property-read string $wettbewerbsart Wettbewerbsart
 * @property-read string $turnierform Turnierform
 * @property-read string $startgruppe Startgruppe
 * @property-read string $startklasseLiga Startklasse oder -Liga
 * @property-read string $turnierart Turnierart
 * @property-read string[] $zulassung Zulassungsbereiche
 * @property-read boolean $wanderpokal Wanderpokal ja/nein
 * @property-read int $turnierrang Turnierrang
 * @property-read boolean $aufstiegsturnier Vergabe von Aufstiegspunkten und -plätzen ja/nein
 * @property-read string|null $ranglistenId ID der zugehörigen Rangliste
 * @property-read int|null $wdsfTurnierId Turnier-ID der WDSF sofern vorhanden
 * @property-read string|null $startgebuehr Startgebühr
 * @property-read string|null $bemerkungen Bemerkungen
 * @property-read string[] $wertungsrichter DTV-IDs der eingesetzten Wertungsrichter
 * @property-read string|null $turnierleiter DTV-ID des eingesetzten Turnierleiters
 * @property-read string|null $beisitzer DTV-ID des eingesetzten Beisitzers
 * @property-read string|null $chairman DTV-ID des eingesetzten Chairmans
 */
#[ExclusionPolicy('all')]
class Turnier
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

	#[Type('string')]
	#[SerializedName('startzeitPlan')]
	#[Expose]
	private string $startzeitPlan;

	#[Type('string')]
	#[SerializedName('startzeitPlanKorrigiert')]
	#[Expose]
	private ?string $startzeitPlanKorrigiert = null;

	#[Type('string')]
	#[Expose]
	private ?string $titel = null;

	#[Type('Tanzsport\ESV\API\Model\Club')]
	#[Expose]
	private ?Club $veranstalter;

	#[Type('Tanzsport\ESV\API\Model\Club')]
	#[Expose]
	private ?Club $ausrichter;

	#[Type('string')]
	#[SerializedName('flaechenId')]
	#[Expose]
	private ?string $flaechenId = null;

	#[Type('string')]
	#[Expose]
	private string $wettbewerbsart;

	#[Type('string')]
	#[Expose]
	private string $turnierform;

	#[Type('string')]
	#[Expose]
	private string $startgruppe;

	#[Type('string')]
	#[SerializedName('startklasseLiga')]
	#[Expose]
	private string $startklasseLiga;

	#[Type('string')]
	#[Expose]
	private string $turnierart;

	/**
	 * @var array<string>
	 */
	#[Type('array<string>')]
	#[Expose]
	private array $zulassung = [];

	#[Type('bool')]
	#[Expose]
	private bool $wanderpokal;

	#[Type('int')]
	#[Expose]
	private int $turnierrang;

	#[Type('bool')]
	#[Expose]
	private bool $aufstiegsturnier;

	#[Type('string')]
	#[SerializedName('ranglistenId')]
	#[Expose]
	private ?string $ranglistenId = null;

	#[Type('int')]
	#[SerializedName('wdsfTurnierId')]
	#[Expose]
	private ?int $wdsfTurnierId = null;

	#[Type('string')]
	#[Expose]
	private ?string $startgebuehr = null;

	#[Type('string')]
	#[Expose]
	private ?string $bemerkungen = null;

	/**
	 * @var array<string>
	 */
	#[Type('array<string>')]
	#[Expose]
	private array $wertungsrichter = [];

	#[Type('string')]
	#[Expose]
	private ?string $turnierleiter = null;

	#[Type('string')]
	#[Expose]
	private ?string $beisitzer = null;

	#[Type('string')]
	#[Expose]
	private ?string $chairman = null;

	public function __get(string $key): mixed
	{
		switch ($key) {
			case 'id':
			case 'datumVon':
			case 'datumBis':
			case 'startzeitPlan':
			case 'startzeitPlanKorrigiert':
			case 'titel':
			case 'veranstalter':
			case 'ausrichter':
			case 'flaechenId':
			case 'wettbewerbsart':
			case 'turnierform':
			case 'startgruppe':
			case 'startklasseLiga':
			case 'turnierart':
			case 'zulassung':
			case 'wanderpokal':
			case 'turnierrang':
			case 'aufstiegsturnier':
			case 'ranglistenId':
			case 'wdsfTurnierId':
			case 'startgebuehr':
			case 'bemerkungen':
			case 'wertungsrichter':
			case 'turnierleiter':
			case 'beisitzer':
			case 'chairman':
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
			case 'startzeitPlan':
			case 'startzeitPlanKorrigiert':
			case 'titel':
			case 'veranstalter':
			case 'ausrichter':
			case 'flaechenId':
			case 'wettbewerbsart':
			case 'turnierform':
			case 'startgruppe':
			case 'startklasseLiga':
			case 'turnierart':
			case 'zulassung':
			case 'wanderpokal':
			case 'turnierrang':
			case 'aufstiegsturnier':
			case 'ranglistenId':
			case 'wdsfTurnierId':
			case 'startgebuehr':
			case 'bemerkungen':
			case 'wertungsrichter':
			case 'turnierleiter':
			case 'beisitzer':
			case 'chairman':
				return isset($this->$key);
			default:
				return false;
		}
	}
}
