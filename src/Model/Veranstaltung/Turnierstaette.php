<?php
namespace Tanzsport\ESV\API\Model\Veranstaltung;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Turnierstätte einer Turnierveranstaltung.
 *
 * @package Tanzsport\ESV\API\Model\Veranstaltung
 * @property-read $name string Name der Turnierstätte
 * @property-read $anschrift string Anschrift der Turnierstätte (Straße + Nr)
 * @property-read $plz string PLZ
 * @property-read $ort string Ort
 *
 * @ExclusionPolicy("all")
 */
class Turnierstaette
{

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $name;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $anschrift;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $plz;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $ort;

	public function __get($key)
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'name':
			case 'anschrift':
			case 'plz':
			case 'ort':
				return isset($this->$key);
		}
	}
}
