<?php
namespace Tanzsport\ESV\API\Resource\Funktionaer;

use Tanzsport\ESV\API\Model\Funktionaer\Funktionaer;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zur Abfrage von Funktionären.
 *
 * @package Tanzsport\ESV\API\Resource\Funktionaer
 */
class FunktionaerResource extends AbstractResource
{

	const URL_ID = 'api/v1/funktionaer/%1$s';
	const URL_LIST = 'api/v1/funktionaere';

	/**
	 * Sucht einen Funktionär anhand seiner DTV-ID; gibt null zurück, falls kein entsprechender Funktionär gefunden wird.
	 *
	 * @param $id DTV-ID des Funktionärs
	 * @return Funktionaer|null
	 */
	public function findeFunktionaerNachDtvId($id)
	{
		if (!$id) {
			throw new \InvalidArgumentException('DTV-ID erforderlich!');
		}

		$response = $this->doGet(sprintf(self::URL_ID, $id));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer');
		}
	}

	/**
	 * Lädt die Gesamtliste aller Funktionäre (aus Datenschutzgründen ohne Titel und Vor- sowie Nachnamen).
	 *
	 * @return Funktionaer[]
	 */
	public function findeAlleFunktionaere()
	{
		$response = $this->doGet(sprintf(self::URL_LIST));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>');
		}
	}
}