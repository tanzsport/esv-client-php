<?php
namespace Tanzsport\ESV\API\Model\Funktionaer;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Funktionär.
 *
 * @package Tanzsport\ESV\API\Model\Funktionaer
 * @property-read string $id DTV-ID
 * @property-read int $wdsfMin WDSF-MIN (<code>NULL</code> falls nicht vorhanden)
 * @property-read int $lizenzNr alte Lizenz-Nr. des Funktionärs (<code>NULL</code> falls nicht vorhanden)
 * @property-read string $titel Titel
 * @property-read string $vorname Vorname
 * @property-read string $nachname Nachname
 * @property-read Club $club Verein des Funktion&auml;rs
 * @property-read string $staat Staat, für den der Funktionär aktiv ist
 * @property-read array $lizenzen IDs aller aktiven Lizenzen des Funktionärs
 *
 * @ExclusionPolicy("all")
 */
class Funktionaer
{
	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $id;

	/**
	 * @var int
	 * @Type("integer")
	 * @SerializedName("wdsfMin")
	 * @Expose
	 */
	private $wdsfMin;

	/**
	 * @var int
	 * @Type("integer")
	 * @SerializedName("lizenzNr")
	 * @Expose
	 */
	private $lizenzNr;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $titel;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $vorname;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $nachname;

	/**
	 * @var Club
	 * @Type("Tanzsport\ESV\API\Model\Club")
	 * @Expose
	 */
	private $club;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $staat;

	/**
	 * @var array
	 * @Type("array<string>")
	 * @Expose
	 */
	private $lizenzen;

	public function __get($key)
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
		}
	}

	public function __isset($key)
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
		}
	}
}
