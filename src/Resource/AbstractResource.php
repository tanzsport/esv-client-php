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

namespace Tanzsport\ESV\API\Resource;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use Tanzsport\ESV\API\Cache\CachingStrategy;

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
	 * @var SerializerInterface
	 */
	protected $serializer;

	/**
	 * @var CachingStrategy
	 */
	protected $cachingStrategy;

	/**
	 * @param HttpClient $client
	 * @param SerializerInterface $serializer
	 */
	public function __construct(HttpClient $client, SerializerInterface $serializer, CachingStrategy $cachingStrategy)
	{
		$this->client = $client;
		$this->serializer = $serializer;
		$this->cachingStrategy = $cachingStrategy;
	}

	/**
	 * @param string $url relative URL
	 * @param string $type Typ-Deklaration
	 * @param mixed $default Standard-Wert, wenn der API-Aufruf keinen Wert zurückgibt
	 * @return mixed
	 * @throws ClientException
	 * @throws ServerException
	 * @throws \InvalidArgumentException
	 */
	protected function getForEntity($url, $type, $default = null)
	{
		if (!$url) {
			throw new \InvalidArgumentException('URL erforderlich!');
		}
		if (!$type) {
			throw new \InvalidArgumentException('Typ erforderlich!');
		}

		$cached = $this->cachingStrategy->getCachedResponseEntity($url);
		if ($cached != null) {
			return $cached;
		}

		try {
			$response = $this->client->get($url);
			$entity = $this->deserializeJson($response->getBody(), $type, 'json') ?: $default;
			if ($entity != null && $entity != $default) {
				$this->cachingStrategy->cacheResponseEntity($url, $entity);
			}
			return $entity;
		} catch (ClientException $e) {
			if ($e->getCode() == 404) {
				return null;
			}
			throw $e;
		}
	}

	protected function createTypedArrayDescriptor($type)
	{
		return sprintf('array<%1$s>', $type);
	}

	private function deserializeJson($data, $type)
	{
		return $this->serializer->deserialize($data, $type, 'json');
	}
}
