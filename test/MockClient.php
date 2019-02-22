<?php

namespace Tanzsport\ESV\API;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class MockClient extends Client
{

	/**
	 * @var MockHandler
	 */
	private $mockHandler;

	public function __construct(Endpunkt $endpunkt, $userAgent, $token, $user, $password, $compress = false, $verifySsl = true)
	{
		parent::__construct($endpunkt, $userAgent, $token, $user, $password, $compress, $verifySsl);
		$this->mockHandler = new MockHandler();
	}

	protected function createHttpClient()
	{
		return new HttpClient(['handler' => HandlerStack::create($this->mockHandler)]);
	}

	/**
	 * @return MockHandler
	 */
	public function getMockHandler()
	{
		return $this->mockHandler;
	}
}
