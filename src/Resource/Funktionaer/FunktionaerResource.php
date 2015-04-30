<?php
namespace Tanzsport\ESV\API\Resource\Funktionaer;

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

	public function findeFunktionaerNachDtvId($id)
	{
		if (!$id) {
			throw new \InvalidArgumentException('DTV-ID erforderlich!');
		}

		$response = $this->doGet(sprintf(self::URL_ID, $id));
		if ($response != null) {
			return $this->deserializeFunktionaer($response->getBody());
		}
	}

	private function deserializeFunktionaer($body)
	{
		return $this->deserializeJson($body, 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer');
	}
}