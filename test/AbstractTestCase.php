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

namespace Tanzsport\ESV\API;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{

	const DEFAULT_ENV = '.env.json';
	const ESV_VERIFY_SSL = 'ESV_VERIFY_SSL';
	const ESV_COMPRESS_ENABLED = 'ESV_COMPRESS_ENABLED';

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
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isCompressEnabled(), $this->isVerifySSL()
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
			$vars = array('ESV_ENDPOINT', 'ESV_TOKEN', 'ESV_USER', 'ESV_PASSWORD', self::ESV_COMPRESS_ENABLED, self::ESV_VERIFY_SSL);
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

	protected function isCompressEnabled() {
		if (isset($_SERVER[self::ESV_COMPRESS_ENABLED])) {
			if (is_bool($_SERVER[self::ESV_COMPRESS_ENABLED])) {
				return $_SERVER[self::ESV_COMPRESS_ENABLED];
			} else {
				return $_SERVER[self::ESV_COMPRESS_ENABLED] > 0;
			}
		} else {
			return true;
		}
	}
}
