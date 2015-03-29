<?php
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
	 * @param bool $verify SSL-Zertifikate verifizieren
	 */
	public function __construct(Endpunkt $endpoint, $userAgent, $token, $user, $password, $verify = true)
	{
		parent::__construct(['base_url' => $endpoint->getBaseUrl()]);
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
		$this->setDefaultOption('headers', ['User-Agent' => sprintf('%1$s; Token=%2$s', $userAgent, $token)]);
		$this->setDefaultOption('auth', [$user, $password]);
		$this->setDefaultOption('verify', $verify);
		$this->endpoint = $endpoint;
	}

}
