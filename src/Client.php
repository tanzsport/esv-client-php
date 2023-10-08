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
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Tanzsport\ESV\API\Http\EsvRequestFactory;
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

	/**
	 * @var array<string, callable>
	 */
	private array $container;

	/**
	 * @var array<string, object>
	 */
	private array $serviceInstances;

	public function __construct(
		private Endpunkt             $endpunkt,
		private string               $userAgent,
		private string               $token,
		private string               $user,
		private string               $password,
		private ?SerializerInterface $externalSerializer = null
	)
	{
		$this->boot();
	}

	private function boot(): void
	{
		$this->container = [];

		$this->bind(ClientInterface::class, function () {
			return $this->createHttpClient();
		});

		$this->bind(SerializerInterface::class, function () {
			return $this->createSerializer();
		});

		$this->bind(UriFactoryInterface::class, function () {
			return Psr17FactoryDiscovery::findRequestFactory();
		});

		$this->bind(RequestFactoryInterface::class, function () {
			return new EsvRequestFactory(
				Psr17FactoryDiscovery::findRequestFactory(),
				$this->userAgent,
				$this->token,
				$this->user,
				$this->password
			);
		});

		$this->bind(StarterResource::class, function () {
			return new StarterResource(
				$this->endpunkt,
				$this->get(ClientInterface::class),
				$this->get(UriFactoryInterface::class),
				$this->get(RequestFactoryInterface::class),
				$this->get(SerializerInterface::class)
			);
		});

		$this->bind(FunktionaerResource::class, function () {
			return new FunktionaerResource(
				$this->endpunkt,
				$this->get(ClientInterface::class),
				$this->get(UriFactoryInterface::class),
				$this->get(RequestFactoryInterface::class),
				$this->get(SerializerInterface::class)
			);
		});

		$this->bind(VeranstaltungResource::class, function () {
			return new VeranstaltungResource(
				$this->endpunkt,
				$this->get(ClientInterface::class),
				$this->get(UriFactoryInterface::class),
				$this->get(RequestFactoryInterface::class),
				$this->get(SerializerInterface::class)
			);
		});
	}

	private function bind(string $class, callable $factory): void
	{
		$this->container[$class] = $factory;
	}

	/**
	 * @template T of object
	 *
	 * @param class-string<T> $class
	 * @return T
	 */
	private function get(string $class): object
	{
		if (!isset($this->serviceInstances[$class])) {
			if (!isset($this->container[$class])) {
				throw new \InvalidArgumentException("Service '{$class}' is not defined!");
			}
			$this->serviceInstances[$class] = call_user_func($this->container[$class]);
		}
		return $this->serviceInstances[$class];
	}

	protected function createHttpClient(): ClientInterface
	{
		return Psr18ClientDiscovery::find();
	}

	protected function createSerializer(): SerializerInterface
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
	public function getFunktionaerResource(): FunktionaerResource
	{
		return $this->get(FunktionaerResource::class);
	}

	/**
	 * Gibt den HTTP-Client zurück.
	 *
	 * @return ClientInterface
	 */
	public function getHttpClient(): ClientInterface
	{
		return $this->get(ClientInterface::class);
	}

	/**
	 * Gibt den Serializer für die Serialisierung/Deserialisierung von JSON-Daten zurück.
	 *
	 * @return SerializerInterface
	 */
	public function getSerializer(): SerializerInterface
	{
		return $this->get(SerializerInterface::class);
	}

	/**
	 * Gibt die Starter-Resource zurück.
	 *
	 * @return StarterResource
	 */
	public function getStarterResource(): StarterResource
	{
		return $this->get(StarterResource::class);
	}

	/**
	 * Gibt die Veranstaltung-Resource zurück.
	 *
	 * @return VeranstaltungResource
	 */
	public function getVeranstaltungResource(): VeranstaltungResource
	{
		return $this->get(VeranstaltungResource::class);
	}
}
