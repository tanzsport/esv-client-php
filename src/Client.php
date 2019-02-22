<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2019 Deutscher Tanzsportverband e.V.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Tanzsport\ESV\API;

use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Client as HttpClient;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Tanzsport\ESV\API\Resource\Funktionaer\FunktionaerResource;
use Tanzsport\ESV\API\Resource\Starter\StarterResource;
use Tanzsport\ESV\API\Resource\Veranstaltung\VeranstaltungResource;

/**
 * Zentrale Klasse für den Zugriff auf die ESV-API. Benötigt einen Endpunkt, einen User-Agent, das ESV-Token, einen
 * Benutzernamen und ein Passwort. Nach Initialisierung des Containers können die einzelnen Resourcen
 * verwendet werden.
 *
 * @package Tanzsport\ESV\API
 */
class Client
{

	private static $SVC_HTTPCLIENT = 'esvHttpClient';
	private static $SVC_SERIALIZER = 'serializer';
	private static $SVC_RESOURCE_STARTER = 'resourceStarter';
	private static $SVC_RESOURCE_FUNKTIONAER = 'resourceFunktionaer';
	private static $SVC_RESOURCE_VERANSTALTUNG = 'resourceVeranstaltung';

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
	private $compress;

	/**
	 * @var bool
	 */
	private $verifySsl;

	/**
	 * @var array
	 */
	private $container;

	/**
	 * @var array
	 */
	private $serviceInstances;

	/**
	 * @var SerializerInterface
	 */
	private $externalSerializer;

	public function __construct(Endpunkt $endpunkt, $userAgent, $token, $user, $password, $compress = false,
		$verifySsl = true, SerializerInterface $serializer = null)
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
		$this->compress = $compress;
		$this->verifySsl = $verifySsl;

		$this->externalSerializer = $serializer;
		$this->boot();
	}

	private function boot()
	{
		$this->container = [];

		$this->bind(self::$SVC_HTTPCLIENT, function () {
			return $this->createHttpClient();
		});

		$this->bind(self::$SVC_SERIALIZER, function () {
			return $this->createSerializer();
		});

		$this->bind(self::$SVC_RESOURCE_STARTER, function () {
			return new StarterResource($this->getHttpClient(), $this->getSerializer());
		});

		$this->bind(self::$SVC_RESOURCE_FUNKTIONAER, function () {
			return new FunktionaerResource($this->getHttpClient(), $this->getSerializer());
		});

		$this->bind(self::$SVC_RESOURCE_VERANSTALTUNG, function () {
			return new VeranstaltungResource($this->getHttpClient(), $this->getSerializer());
		});
	}

	private function bind($key, callable $callable)
	{
		if (!$key) {
			throw new \InvalidArgumentException('Key erforderlich!');
		}
		$this->container[$key] = $callable;
	}

	private function get($key)
	{
		if (!$key) {
			throw new \InvalidArgumentException('Key erforderlich!');
		}
		if (!isset($this->serviceInstances[$key])) {
			$this->serviceInstances[$key] = call_user_func($this->container[$key]);
		}
		return $this->serviceInstances[$key];
	}

	protected function createHttpClient()
	{
		return new HttpClient([
			'base_uri' => $this->endpunkt->getBaseUrl(),
			'verify' => $this->verifySsl,
			'decode_content' => $this->compress,
			'auth' => [$this->user, $this->password],
			'headers' => array_merge(
				['User-Agent' => sprintf('%1$s; Token=%2$s', $this->userAgent, $this->token)],
				$this->compress ? ['Accept-Encoding' => 'gzip'] : []
			)
		]);
	}

	protected function createSerializer()
	{
		if ($this->externalSerializer != null) {
			return $this->externalSerializer;
		} else {
			AnnotationRegistry::registerLoader('class_exists');
			return SerializerBuilder::create()->build();
		}
	}

	/**
	 * Gibt die Funktionär-Resource zurück.
	 *
	 * @return FunktionaerResource
	 */
	public function getFunktionaerResource()
	{
		return $this->get(self::$SVC_RESOURCE_FUNKTIONAER);
	}

	/**
	 * Gibt den HTTP-Client zurück.
	 *
	 * @return HttpClient
	 */
	public function getHttpClient()
	{
		return $this->get(self::$SVC_HTTPCLIENT);
	}

	/**
	 * Gibt den Serializer für die Serialisierung/Deserialisierung von JSON-Daten zurück.
	 *
	 * @return SerializerInterface
	 */
	public function getSerializer()
	{
		return $this->get(self::$SVC_SERIALIZER);
	}

	/**
	 * Gibt die Starter-Resource zurück.
	 *
	 * @return StarterResource
	 */
	public function getStarterResource()
	{
		return $this->get(self::$SVC_RESOURCE_STARTER);
	}

	/**
	 * Gibt die Veranstaltung-Resource zurück.
	 *
	 * @return VeranstaltungResource
	 */
	public function getVeranstaltungResource()
	{
		return $this->get(self::$SVC_RESOURCE_VERANSTALTUNG);
	}
}
