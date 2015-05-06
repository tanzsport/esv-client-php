<?php
namespace Tanzsport\ESV\API\Model\Veranstaltung;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Turnierveranstaltung in der Veranstaltungsliste.
 *
 * @package Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung
 * @property-read int $id ID
 * @property-read DateTime $datumVon Beginndatum der Veranstaltung
 * @property-read DateTime $datumBis Enddatum der Veranstaltung
 * @property-read string $ort Ort
 * @property-read string $titel Titel
 *
 * @ExclusionPolicy("all")
 */
class Veranstaltung
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
	 * @Expose
	 */
	private $ort;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $titel;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'datumVon':
			case 'datumBis':
			case 'ort':
			case 'titel':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'datumVon':
			case 'datumBis':
			case 'ort':
			case 'titel':
				return isset($this->$key);
		}
	}
}