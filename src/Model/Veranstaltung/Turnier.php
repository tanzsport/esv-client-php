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
 * Turnier in einer Turnierveranstaltung.
 *
 * @package Tanzsport\ESV\API\Model\Veranstaltung
 * @property-read int $id ID
 * @property-read \DateTime $datumVon Beginndatum Turnier
 * @property-read \DateTime $datumBis Enddatum Turnier
 * @property-read string $startzeitPlan geplante Startzeit
 * @property-read string $startzeitPlanKorrigiert korrigierte Plan-Startzeit
 * @property-read string $titel Turniertitel
 * @property-read Club $veranstalter Turnierveranstalter
 * @property-read Club $ausrichter Turnierausrichter
 * @property-read string $flaechenId ID der Fläche
 * @property-read string $wettbewerbsart Wettbewerbsart
 * @property-read string $turnierform Turnierform
 * @property-read string $startgruppe Startgruppe
 * @property-read string $startklasseLiga Startklasse oder -Liga
 * @property-read string $turnierart Turnierart
 * @property-read string[] $zulassung Zulassungsbereiche
 * @property-read boolean $wanderpokal Wanderpokal ja/nein
 * @property-read int $turnierrang Turnierrang
 * @property-read boolean $aufstiegsturnier Vergabe von Aufstiegspunkten und -plätzen ja/nein
 * @property-read string $ranglistenId ID der zugehörigen Rangliste
 * @property-read int $wdsfTurnierId Turnier-ID der WDSF sofern vorhanden
 * @property-read string $startgebuehr Startgebühr
 * @property-read string $bemerkungen Bemerkungen
 * @property-read string[] $wertungsrichter DTV-IDs der eingesetzten Wertungsrichter
 * @property-read string $turnierleiter DTV-ID des eingesetzten Turnierleiters
 * @property-read string $beisitzer DTV-ID des eingesetzten Beisitzers
 * @property-read string $chairman DTV-ID des eingesetzten Chairmans
 *
 * @ExclusionPolicy("all")
 */
class Turnier
{
	/**
	 * @var int
	 * @Type("integer")
	 * @Expose
	 */
	private $id;

	/**
	 * @var \DateTime
	 * @Type("DateTime")
	 * @SerializedName("datumVon")
	 * @Expose
	 */
	private $datumVon;

	/**
	 * @var \DateTime
	 * @Type("DateTime")
	 * @SerializedName("datumBis")
	 * @Expose
	 */
	private $datumBis;

	/**
	 * @var string
	 * @Type("string")
	 * @SerializedName("startzeitPlan")
	 * @Expose
	 */
	private $startzeitPlan;

	/**
	 * @var string
	 * @Type("string")
	 * @SerializedName("startzeitPlanKorrigiert")
	 * @Expose
	 */
	private $startzeitPlanKorrigiert;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $titel;

	/**
	 * @var Club
	 * @Type("Tanzsport\ESV\API\Model\Club")
	 * @Expose
	 */
	private $veranstalter;

	/**
	 * @var Club
	 * @Type("Tanzsport\ESV\API\Model\Club")
	 * @Expose
	 */
	private $ausrichter;

	/**
	 * @var string
	 * @type("string")
	 * @SerializedName("flaechenId")
	 * @Expose
	 */
	private $flaechenId;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $wettbewerbsart;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $turnierform;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $startgruppe;

	/**
	 * @var string
	 * @type("string")
	 * @SerializedName("startklasseLiga")
	 * @Expose
	 */
	private $startklasseLiga;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $turnierart;

	/**
	 * @var string[]
	 * @type("array<string>")
	 * @Expose
	 */
	private $zulassung;

	/**
	 * @var bool
	 * @type("boolean")
	 * @Expose
	 */
	private $wanderpokal;

	/**
	 * @var int
	 * @type("integer")
	 * @Expose
	 */
	private $turnierrang;

	/**
	 * @var bool
	 * @type("boolean")
	 * @Expose
	 */
	private $aufstiegsturnier;

	/**
	 * @var string
	 * @type("string")
	 * @SerializedName("ranglistenId")
	 * @Expose
	 */
	private $ranglistenId;

	/**
	 * @var int
	 * @type("integer")
	 * @SerializedName("wdsfTurnierId")
	 * @Expose
	 */
	private $wdsfTurnierId;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $startgebuehr;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $bemerkungen;


	/**
	 * @var string[]
	 * @type("array<string>")
	 * @Expose
	 */
	private $wertungsrichter;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $turnierleiter;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $beisitzer;

	/**
	 * @var string
	 * @type("string")
	 * @Expose
	 */
	private $chairman;

	public function __get($key)
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
		}
	}

	public function __isset($key)
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
		}
	}
}
