<?php
namespace Tanzsport\ESV\API\Resource\Starter;

use Tanzsport\ESV\API\Konstanten;
use Tanzsport\ESV\API\Model\Starter\Starter;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zu Abfrage von Startern.
 *
 * @package Tanzsport\ESV\API\Resource\Starter
 */
class StarterResource extends AbstractResource
{

	const URL_ID = 'api/v1/starter/%1$s';
	const URL_DTV_OR_WDSF = 'api/v1/starter/%1$s/%2$s';

	/**
	 * Sucht einen Starter anhand seiner ID; gibt null zurück, falls kein entsprechender Starter gefunden wird.
	 *
	 * @param int $id
	 * @param string $type Objekttyp für Deserialisierung, standardmäßig Tanzsport\ESV\API\Model\Starter
	 * @throws \InvalidArgumentException bei fehlenden Parametern oder nicht-numerischen IDs
	 * @return Starter|null
	 */
	public function findeStarterNachId($id, $type = 'Tanzsport\ESV\API\Model\Starter')
	{
		if (!$id) {
			throw new \InvalidArgumentException('ID erforderlich.');
		}
		if (!is_numeric($id)) {
			throw new \InvalidArgumentException('ID muss numerisch sein.');
		}
		if (!$type) {
			throw new \InvalidArgumentException('Typ erforderlich.');
		}

		$response = $this->doGet(sprintf(self::URL_ID, $id));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), $type);
		}
	}

	/**
	 * Sucht einen Starter anhand der Wettbewerbsart und der DTV-ID oder WDSF-MIN der beteiligten Personen; gibt
	 * null zurück, falls kein entsprechender Starter gefunden wird.
	 *
	 * @param string $wettbewerbsart Wettbewerbsart
	 * @param mixed $id DTV-ID oder WDSF-MIN einer der beteiligten Personen
	 * @return Starter|null
	 * @throws \InvalidArgumentException bei fehlenden Parametern oder ungültigter Wettebewerbsart
	 */
	public function findeStarterNachDtvOderWdsfId($wettbewerbsart, $id)
	{
		if (!$wettbewerbsart) {
			throw new \InvalidArgumentException('Wettbewerbsart erforderlich.');
		}
		if (!$id) {
			throw new \InvalidArgumentException('DTV-ID oder WDSF-MIN erforderlich.');
		}
		if (!in_array($wettbewerbsart, Konstanten::getWettbewerbsarten())) {
			throw new \InvalidArgumentException("Wettbewerbsart {$wettbewerbsart} wird nicht unterstützt.");
		}

		$response = $this->doGet(sprintf(self::URL_DTV_OR_WDSF, $wettbewerbsart, $id));
		if ($response != null) {
			return $this->deserializeStarter($response->getBody(), Konstanten::WA_EINZEL);
		}
	}

	private function deserializeStarter($body, $wettbewerbsart)
	{
		if (!$body) {
			return;
		}
		switch ($wettbewerbsart) {
			case Konstanten::WA_EINZEL:
				return $this->deserializeJson($body, 'Tanzsport\ESV\API\Model\Starter\Paar');
			default:
				throw new \InvalidArgumentException("Die Wettbewerbsart {$wettbewerbsart} wird noch nicht unterstützt.");
		}
	}
}
