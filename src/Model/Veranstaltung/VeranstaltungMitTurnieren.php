<?php
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
