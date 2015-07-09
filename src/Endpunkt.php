<?php
namespace Tanzsport\ESV\API;

/**
 * API-Endpunkt.
 *
 * @package Tanzsport\ESV\Api
 */
class Endpunkt
{

	const Q1 = 'http://ev-q1.tanzsport-portal.de';
	const Q2 = 'http://ev-q2.tanzsport-portal.de';
	const PROD = 'https://ev.tanzsport-portal.de';

	/**
	 * @var string
	 */
	private $baseUrl;

	/**
	 * @param string $baseUrl Basis-URL; vorgegebene Endpunkte sind Q1, Q2, PROD (freie Eingabe möglich)
	 */
	public function __construct($baseUrl)
	{
		if (!$baseUrl) {
			throw new \InvalidArgumentException('Basis-URL erforderlich');
		}
		$this->baseUrl = $baseUrl;
	}

	/**
	 * Gibt die Basis-URL zurück.
	 *
	 * @return string
	 */
	public function getBaseUrl()
	{
		return $this->baseUrl;
	}
}
