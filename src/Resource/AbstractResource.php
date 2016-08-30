<?php

/*
 * Copyright (c) 2015 Deutscher Tanzsportverband e.V.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
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

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
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
	 * @var SerializerInterface
	 */
	protected $serializer;

	/**
	 * @param HttpClient $client
	 * @param SerializerInterface $serializer
	 */
	public function __construct(HttpClient $client, SerializerInterface $serializer)
	{
		$this->client = $client;
		$this->serializer = $serializer;
	}

	/**
	 * @param string $url relative URL
	 * @return ResponseInterface|null
	 * @throws ClientException
	 * @throws ServerException
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
