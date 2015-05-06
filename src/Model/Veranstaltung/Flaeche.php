<?php
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
