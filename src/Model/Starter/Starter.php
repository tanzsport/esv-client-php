<?php
namespace Tanzsport\ESV\API\Model\Starter;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Tanzsport\ESV\API\Model\Club;
use Tanzsport\ESV\API\Model\Person;

/**
 * Basis-Klasse für Starter.
 *
 * @package Tanzsport\ESV\API\Model\Starter
 * @property-read int $id ID des Starters
 * @property-read Club $club Verein des Starters
 * @property-read string $staat Staat, für den der Starter startet
 *
 * @ExclusionPolicy("all")
 */
class Starter
{

	/**
	 * @var int
	 * @Type("integer")
	 * @Expose
	 */
	private $id;

	/**
	 * @var Person[]
	 * @Type("array<Tanzsport\ESV\API\Model\Person>")
	 * @Expose
	 */
	private $personen;

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

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'club':
			case 'staat':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'club':
			case 'staat':
				return isset($this->$key);
		}
	}

	protected function getPerson($i)
	{
		if (!isset($this->personen[$i])) {
			throw new \InvalidArgumentException("Person mit Index {$i} ist nicht vorhanden.");
		}
		return $this->personen[$i];
	}

	protected function personExists($i)
	{
		return isset($this->personen[$i]);
	}
}
