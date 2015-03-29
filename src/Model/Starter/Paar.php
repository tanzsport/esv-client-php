<?php
namespace Tanzsport\ESV\API\Model\Starter;

use Tanzsport\ESV\API\Model\Person;

/**
 * Starter vom Typ Paar.
 *
 * @package Tanzsport\ESV\API\Model\Starter
 * @property-read Person $partner Partner
 * @property-read Person $partnerin Partnerin
 */
class Paar extends Starter
{

	public function __get($key)
	{
		switch ($key) {
			case 'partner':
				return $this->getPerson(0);
			case 'partnerin':
				return $this->getPerson(1);
			default:
				return parent::__get($key);
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'partner':
				return $this->personExists(0);
			case 'partnerin':
				return $this->personExists(1);
			default:
				return parent::__isset($key);
		}
	}
}
