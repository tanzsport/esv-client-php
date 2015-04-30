<?php
namespace Tanzsport\ESV\API;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Pimple\Container;
use Tanzsport\ESV\API\Http\HttpClient;
use Tanzsport\ESV\API\Resource\Funktionaer\FunktionaerResource;
use Tanzsport\ESV\API\Resource\Starter\StarterResource;

/**
 * Zentrale Klasse für den Zugriff auf die ESV-API. Benötigt einen Endpunkt, einen User-Agent, das ESV-Token, einen
 * Benutzernamen und ein Passwort. Nach Initialisierung des Containers können die einzelnen Resourcen
 * verwendet werden.
 *
 * @package Tanzsport\ESV\Api
 */
class Client
{

	const BEAN_HTTPCLIENT = 'esvHttpClient';
	const BEAN_SERIALIZER = 'serializer';
	const BEAN_RESOURCE_STARTER = 'resourceStarter';
	const BEAN_RESOURCE_FUNKTIONAER = 'resourceFunktionaer';

	/**
	 * @var Endpunkt
	 */
	private $endpunkt;

	/**
	 * @var string
	 */
	private $userAgent;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var string
	 */
	private $user;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var bool
	 */
	private $verifySsl;
	/**
	 * @var \Pimple\Container
	 */
	private $container;

	public function __construct(Endpunkt $endpunkt, $userAgent, $token, $user, $password, $verifySsl = true)
	{
		if (!$userAgent) {
			throw new \InvalidArgumentException('User-Agent erforderlich.');
		}
		if (!$token) {
			throw new \InvalidArgumentException('Token erforderlich.');
		}
		if (!$user) {
			throw new \InvalidArgumentException('Benutzername erforderlich.');
		}
		if (!$password) {
			throw new \InvalidArgumentException('Passwort erforderlich.');
		}

		$this->endpunkt = $endpunkt;
		$this->userAgent = $userAgent;
		$this->token = $token;
		$this->user = $user;
		$this->password = $password;
		$this->verifySsl = $verifySsl;
		$this->boot();
	}

	private function boot()
	{
		$this->container = new Container();

		$this->bind(self::BEAN_HTTPCLIENT, function () {
			return new HttpClient($this->endpunkt, $this->userAgent, $this->token, $this->user, $this->password, $this->verifySsl);
		});

		$this->bind(self::BEAN_SERIALIZER, function () {
			AnnotationRegistry::registerLoader('class_exists');
			return SerializerBuilder::create()->build();
		});

		$this->bind(self::BEAN_RESOURCE_STARTER, function () {
			return new StarterResource($this->getHttpClient(), $this->getSerializer());
		});

		$this->bind(self::BEAN_RESOURCE_FUNKTIONAER, function () {
			return new FunktionaerResource($this->getHttpClient(), $this->getSerializer());
		});
	}

	private function bind($key, callable $callable)
	{
		$this->container->offsetSet($key, $callable);
	}

	private function get($key)
	{
		return $this->container->offsetGet($key);
	}

	/**
	 * Gibt die Funktionär-Resource zurück.
	 *
	 * @return FunktionaerResource
	 */
	public function getFunktionaerResource()
	{
		return $this->get(self::BEAN_RESOURCE_FUNKTIONAER);
	}

	/**
	 * Gibt den HTTP-Client zurück.
	 *
	 * @return HttpClient
	 */
	public function getHttpClient()
	{
		return $this->get(self::BEAN_HTTPCLIENT);
	}

	/**
	 * Gibt den Serializer für die Serialisierung/Deserialisierung von JSON-Daten zurück.
	 *
	 * @return Serializer
	 */
	public function getSerializer()
	{
		return $this->get(self::BEAN_SERIALIZER);
	}

	/**
	 * Gibt die Starter-Resource zurück.
	 *
	 * @return StarterResource
	 */
	public function getStarterResource()
	{
		return $this->get(self::BEAN_RESOURCE_STARTER);
	}
}
