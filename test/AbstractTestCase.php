<?php

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{

	const DEFAULT_ENV = '.env.json';
	const ESV_VERIFY_SSL = 'ESV_VERIFY_SSL';

	/**
	 * @var \Tanzsport\ESV\API\Client
	 */
	protected $client;

	public function setUp()
	{
		parent::setUp();

		$envFile = $this->getEnvFile();
		if ($envFile != null) {
			$this->setEnv($envFile);
		}

		date_default_timezone_set('Europe/Berlin');

		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isVerifySSL()
		);
	}

	protected function getEnvFile()
	{
		return __DIR__ . '/../' . self::DEFAULT_ENV;
	}

	protected function setEnv($envFile)
	{
		if (file_exists($envFile)) {
			$objEnv = json_decode(file_get_contents($envFile));
			$vars = array('ESV_ENDPOINT', 'ESV_TOKEN', 'ESV_USER', 'ESV_PASSWORD', self::ESV_VERIFY_SSL);
			foreach ($vars as $var) {
				if (isset($objEnv->$var)) {
					$_SERVER[$var] = $objEnv->$var;
				}
			}
		}
	}

	protected function getEnv($var)
	{
		if (!$var) {
			throw new InvalidArgumentException('Variable erforderlich!');
		}
		if (isset($_SERVER[$var])) {
			return $_SERVER[$var];
		} else {
			throw new RuntimeException("Umgebungsvariable {$var} ist nicht definiert.");
		}
	}

	protected function isVerifySSL()
	{
		if (isset($_SERVER[self::ESV_VERIFY_SSL])) {
			if (is_bool($_SERVER[self::ESV_VERIFY_SSL])) {
				return $_SERVER[self::ESV_VERIFY_SSL];
			} else {
				return $_SERVER[self::ESV_VERIFY_SSL] > 0;
			}
		} else {
			return true;
		}
	}
}
