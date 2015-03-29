<?php
namespace Tanzsport\ESV\API\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\SerializedName;
use Tanzsport\ESV\API\Konstanten;

/**
 * Person als Bestandteil eines Starters.
 *
 * @package Tanzsport\ESV\API\Model
 * @property-read string $id DTV-ID
 * @property-read string $titel Titel
 * @property-read string $vorname Vorname
 * @property-read string $nachname Nachname
 * @property-read boolean $maennlich Person männlich ja/nein
 * @property-read int $wdsfMin WDSF-MIN
 * @property-read string $nationalitaet Staatsangehörigkeit der Person
 *
 * @ExclusionPolicy("all")
 */
class Person
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
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $geschlecht;

	/**
	 * @var int
	 * @Type("integer")
	 * @SerializedName("wdsfMin")
	 * @Expose
	 */
	private $wdsfMin;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $nationalitaet;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'wdsfMin':
			case 'nationalitaet':
				return $this->$key;
			case 'maennlich':
				return $this->isMaennlich();
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'titel':
			case 'vorname':
			case 'nachname':
			case 'wdsfMin':
			case 'nationalitaet':
				return isset($this->$key);
		}
	}

	private function isMaennlich()
	{
		return strtolower($this->geschlecht) == Konstanten::GESCHLECHT_M;
	}
}
