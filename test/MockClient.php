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

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\ClientInterface;

class MockClient extends Client
{

	private array $container = [];
	private MockHandler $mockHandler;

	public function __construct(Endpunkt $endpunkt, $userAgent, $token, $user, $password)
	{
		parent::__construct($endpunkt, $userAgent, $token, $user, $password);
		$this->mockHandler = new MockHandler();
	}

	protected function createHttpClient(): ClientInterface
	{
		$handlerStack = HandlerStack::create($this->mockHandler);
		$handlerStack->push(Middleware::history($this->container));

		return new HttpClient(['handler' => $handlerStack]);
	}

	public function getMockHandler(): MockHandler
	{
		return $this->mockHandler;
	}

	public function getHistory(): array
	{
		return $this->container;
	}
}
