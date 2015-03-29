<?php
namespace Tanzsport\ESV\API\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Verein eines Starters.
 *
 * @package Tanzsport\ESV\API\Model
 * @property-read int $id ID des Vereins
 * @property-read string $name Name des Vereins
 * @property-read LTV $ltv Landesverband des Vereins
 *
 * @ExclusionPolicy("all")
 */
class Club
{

	/**
	 * @var int
	 * @Type("integer")
	 * @Expose
	 */
	private $id;

	/**
	 * @var string
	 * @Type("string")
	 * @Expose
	 */
	private $name;

	/**
	 * @var LTV
	 * @Type("Tanzsport\ESV\API\Model\LTV")
	 * @Expose
	 */
	private $ltv;

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'name':
			case 'ltv':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'name':
			case 'ltv':
				return isset($this->$key);
		}
	}
}
