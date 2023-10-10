<?php

namespace Tanzsport\ESV\API\Http;

use Psr\Http\Message\ResponseInterface;

class HttpException extends \Exception
{

	public function __construct(
		private ResponseInterface $response,
	)
	{
		parent::__construct("Request failed with HTTP response code {$this->response->getStatusCode()}", $response->getStatusCode());
	}

	public function getResponse(): ResponseInterface
	{
		return $this->response;
	}
}
