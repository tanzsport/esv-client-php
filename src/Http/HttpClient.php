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

namespace Tanzsport\ESV\API\Http;

use GuzzleHttp\Client;
use Tanzsport\ESV\API\Endpunkt;

/**
 * HTTP-Client für die Abfrage der ESV-API. Benötigt einen Endpunkt, einen User-Agent, das ESV-Token,
 * Benutzername und Passwort.
 *
 * @package Tanzsport\ESV\API\Http
 */
class HttpClient extends Client
{

	/**
	 * @param Endpunkt $endpoint API-Endpunkt
	 * @param string $userAgent User-Agent
	 * @param string $token API-Token
	 * @param string $user Benutzername
	 * @param string $password Passwort
	 * @param bool $compress Komprimierung aktivieren
	 * @param bool $verify SSL-Zertifikate verifizieren
	 */
	public function __construct(Endpunkt $endpoint, $userAgent, $token, $user, $password, $compress = false, $verify = true)
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
		parent::__construct([
			'base_uri' => $endpoint->getBaseUrl(),
			'verify' => $verify,
			'decode_content' => $compress,
			'auth' => [$user, $password],
			'headers' => array_merge(
				['User-Agent' => sprintf('%1$s; Token=%2$s', $userAgent, $token)],
				$compress ? ['Accept-Encoding' => 'gzip'] : []
			)
		]);
		$this->endpoint = $endpoint;
	}
}
