<?php
namespace Tanzsport\ESV\API\Resource;

use GuzzleHttp\Exception\ClientException;
use JMS\Serializer\Serializer;
use Tanzsport\ESV\API\Http\HttpClient;

/**
 * Abstrakte Basis-Klasse für Resourcen. Benötigt einen HTTP-Client und einen
 * Serializer.
 *
 * @package Tanzsport\ESV\API\Resource
 */
abstract class AbstractResource
{

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var Serializer
	 */
	protected $serializer;

	/**
	 * @param HttpClient $client
	 * @param Serializer $serializer
	 */
	public function __construct(HttpClient $client, Serializer $serializer)
	{
		$this->client = $client;
		$this->serializer = $serializer;
	}

	/**
	 * @param string $url relative URL
	 * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
	 * @throws \Exception
	 * @throws \GuzzleHttp\Exception\ClientException
	 * @throws \InvalidArgumentException
	 */
	protected function doGet($url)
	{
		if (!$url) {
			throw new \InvalidArgumentException('URL erforderlich!');
		}
		try {
			return $this->client->get($url);
		} catch (ClientException $e) {
			if ($e->getCode() == 404) {
				return null;
			}
			throw $e;
		}
	}

	protected function deserializeJson($data, $type)
	{
		return $this->serializer->deserialize($data, $type, 'json');
	}
}
