<?php
namespace Tanzsport\ESV\API\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Landesverband eines Vereins.
 *
 * @package Tanzsport\ESV\API\Model
 * @property-read int $id ID des Landesverbandes
 * @property-read string $name Name des Landesverbandes
 *
 * @ExclusionPolicy("all")
 */
class LTV
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

	public function __get($key)
	{
		switch ($key) {
			case 'id':
			case 'name':
				return $this->$key;
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'id':
			case 'name':
				return isset($this->$key);
		}
	}
}
