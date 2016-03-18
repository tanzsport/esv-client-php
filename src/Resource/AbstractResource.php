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
	 * @var bool|string
	 */
	protected $cacheDir;

	/**
	 * @var int
	 */
	protected $cacheTime;

	/**
	 * @param HttpClient $client
	 * @param Serializer $serializer
	 */
	public function __construct(HttpClient $client, Serializer $serializer, $cacheDir, $cacheTime)
	{
		$this->client = $client;
		$this->serializer = $serializer;
		$this->cacheDir = $cacheDir;
		$this->cacheTime = $cacheTime;
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

		$cacheFile = rtrim($this->cacheDir, '/') . '/' . md5($url);
		if ($this->cacheDir) {
			if (file_exists($cacheFile)) {
				if ((filemtime($cacheFile) + $this->cacheTime >= time())) {
					return file_get_contents($cacheFile);
				} else {
					unlink($cacheFile);
				}
			}
		}

		try {
			$data = $this->client->get($url)->getBody();
		} catch (ClientException $e) {
			if ($e->getCode() == 404) {
				$data = null;
			} else {
				throw $e;
			}
		}

		if ($this->cacheDir) {
			if (file_exists($cacheFile) && $data === null) {
				unlink($cacheFile);
			} else {
				file_put_contents($cacheFile, $data);
			}
		}

		return $data;
	}

	protected function deserializeJson($data, $type)
	{
		return $this->serializer->deserialize($data, $type, 'json');
	}
}
