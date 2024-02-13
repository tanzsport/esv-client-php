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

use JMS\Serializer\SerializerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Tanzsport\ESV\API\Endpunkt;
use Tanzsport\ESV\API\Http\HttpException;
use Tanzsport\ESV\API\Utils;

/**
 * Abstrakte Basis-Klasse für Ressourcen. Benötigt einen HTTP-Client und einen
 * Serializer.
 *
 * @package Tanzsport\ESV\API\Resource
 */
abstract class AbstractResource
{

	public function __construct(
		private Endpunkt                $endpunkt,
		private ClientInterface         $client,
		private UriFactoryInterface     $uriFactory,
		private RequestFactoryInterface $requestFactory,
		private SerializerInterface     $serializer
	)
	{
	}

	/**
	 * @template T of mixed
	 *
	 * @param string $path
	 * @param class-string<T> $type
	 * @param T|null $default
	 * @param string|null $accept
	 * @param array<string, bool|float|int|string|array<bool|float|int|string>> $query
	 * @return T|null
	 *
	 * @throws \Psr\Http\Client\ClientExceptionInterface
	 * @throws HttpException
	 */
	protected function getForEntity(string $path, string $type, mixed $default = null, ?string $accept = null, ?array $query = null): mixed
	{
		$response = $this->client->sendRequest($this->createRequest('GET', $path, $accept, $query));
		if ($response->getStatusCode() === 200) {
			return $this->deserializeJson($response->getBody(), $type) ?: $default;
		} else if ($response->getStatusCode() === 404) {
			return $default;
		} else {
			throw new HttpException($response);
		}
	}

	/**
	 * @template T of mixed
	 *
	 * @param string $path
	 * @param class-string<T> $itemType
	 * @param string|null $accept
	 * @param array<string, bool|float|int|string|array<bool|float|int|string>> $query
	 * @return array<T>
	 *
	 * @throws \Psr\Http\Client\ClientExceptionInterface
	 * @throws HttpException
	 */
	protected function getForList(string $path, string $itemType, ?string $accept = null, ?array $query = null): array
	{
		$response = $this->client->sendRequest($this->createRequest('GET', $path, $accept, $query));
		if ($response->getStatusCode() === 200) {
			return $this->deserializeJson($response->getBody(), $this->createTypedArrayDescriptor($itemType)) ?: [];
		} else if ($response->getStatusCode() === 404) {
			return [];
		} else {
			throw new HttpException($response);
		}
	}

	protected function createTypedArrayDescriptor(string $type): string
	{
		return sprintf('array<%1$s>', $type);
	}

	private function deserializeJson(string $data, string $type): mixed
	{
		return $this->serializer->deserialize($data, $type, 'json');
	}

	/**
	 * @param array<string, bool|float|int|string|array<bool|float|int|string>> $query
	 */
	private function createRequest(string $method, string $path, ?string $accept = null, ?array $query = null): RequestInterface
	{
		$uri = $this->createUri($path)
			->withQuery($query ? Utils::createQueryString($query) : '');
		$request = $this->requestFactory->createRequest(strtoupper($method), $uri);
		if ($accept) {
			$request = $request->withHeader('Accept', $accept);
		}
		return $request;
	}

	private function createUri(string $path): UriInterface
	{
		return $this->uriFactory->createUri(sprintf('%1$s/%2$s', $this->endpunkt->getBaseUrl(), $path));
	}
}
