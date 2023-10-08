<?php

namespace Tanzsport\ESV\API\Http;

use Http\Message\Authentication\BasicAuth;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class EsvRequestFactory implements RequestFactoryInterface
{

	private BasicAuth $basicAuth;

	public function __construct(
		private RequestFactoryInterface $parentFactory,
		private string                  $userAgent,
		private string                  $token,
		string                          $username,
		string                          $password
	)
	{
		$this->basicAuth = new BasicAuth($username, $password);
	}

	public function createRequest(string $method, $uri): RequestInterface
	{
		return $this->basicAuth->authenticate(
			$this->parentFactory->createRequest($method, $uri)
				->withHeader('User-Agent', sprintf('%1$s; token=%2$s', $this->userAgent, $this->token))
		);
	}
}
