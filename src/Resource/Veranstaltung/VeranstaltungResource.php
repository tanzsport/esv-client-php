<?php
namespace Tanzsport\ESV\API\Resource\Veranstaltung;

use Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung;
use Tanzsport\ESV\API\Model\Veranstaltung\VeranstaltungMitTurnieren;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zur Abfrage von Veranstaltungen.
 *
 * @package Tanzsport\ESV\API\Resource\Veranstaltung
 */
class VeranstaltungResource extends AbstractResource
{

	const URL_LIST = 'api/v1/veranstaltungen';
	const URL_ID = 'api/v1/turniere/%1$s';

	/**
	 * Gibt alle Veranstaltungen zurück, auf die der aktuelle Benutzer Zugriff hat
	 *
	 * @return Veranstaltung[]
	 */
	public function getVeranstaltungen()
	{
		$response = $this->doGet(self::URL_LIST);
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'array<Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung>');
		} else {
			return array();
		}
	}

	/**
	 * Sucht eine Veranstaltung anhand ihrer ID.
	 *
	 * @param $id ID der Veranstaltung
	 * @return VeranstaltungMitTurnieren|null
	 */
	public function getVeranstaltungById($id)
	{
		if (!$id) {
			throw new \InvalidArgumentException('ID erforderlich.');
		}
		if (!is_numeric($id)) {
			throw new \InvalidArgumentException('ID muss numerisch sein.');
		}

		$response = $this->doGet(sprintf(self::URL_ID, $id));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'Tanzsport\ESV\API\Model\Veranstaltung\VeranstaltungMitTurnieren');
		}
	}
}