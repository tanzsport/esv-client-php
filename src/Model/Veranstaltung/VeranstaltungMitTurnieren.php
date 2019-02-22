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
 * @package Tanzsport\ESV\API\Model\Veranstaltung
 *
 * @ExclusionPolicy("all")
 */
class VeranstaltungMitTurnieren extends Veranstaltung
{

	/**
	 * @var Turnierstaette
	 * @type("Tanzsport\ESV\API\Model\Veranstaltung\Turnierstaette")
	 * @Expose
	 */
	private $turnierstaette;

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

	private $bemerkungen;

	/**
	 * @var Funktionaer[]
	 * @Type("array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>")
	 * @Expose
	 */
	private $wertungsrichter;

	/**
	 * @var Funktionaer[]
	 * @Type("array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>")
	 * @Expose
	 */
	private $funktionaere;

	/**
	 * @var Flaeche[]
	 * @Type("array<Tanzsport\ESV\API\Model\Veranstaltung\Flaeche>")
	 * @Expose
	 */
	private $flaechen;

	/**
	 * @var Turnier[]
	 * @Type("array<Tanzsport\ESV\API\Model\Veranstaltung\Turnier>")
	 * @Expose
	 */
	private $turniere;

	public function __get($key)
	{
		switch ($key) {
			case 'turnierstaette':
			case 'veranstalter':
			case 'ausrichter':
			case 'bemerkungen':
			case 'wertungsrichter':
			case 'funktionaere':
			case 'flaechen':
			case 'turniere':
				return $this->$key;
			case 'ort':
				return $this->getOrt();
			default:
				return parent::__get($key);
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'turnierstaette':
			case 'veranstalter':
			case 'ausrichter':
			case 'bemerkungen':
			case 'wertungsrichter':
			case 'funktionaere':
			case 'flaechen':
			case 'turniere':
				return isset($this->$key);
			case 'ort':
				return $this->getOrt() != null;
			default:
				return parent::__isset($key);
		}
	}

	private function getOrt()
	{
		if (isset($this->turnierstaette)) {
			return $this->turnierstaette->ort;
		}
	}
}
