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

class ResourceCacheTest extends AbstractTestCase
{

	/**
	 * @var \Tanzsport\ESV\API\Resource\Funktionaer\FunktionaerResource
	 */
	private $resource;

	public function setUp()
	{
		parent::setUp();
		mkdir(__DIR__ . '/cache_files/');
	}

	public function tearDown()
	{
		exec('rm -rf ' . __DIR__ . '/cache_files/');
	}

	/**
	 * @test
	 */
	public function gecached()
	{
		// Erster Aufruf => Resource wird gecached
		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isCompressEnabled(), $this->isVerifySSL(),
			__DIR__ . '/cache_files/'
		);
		$this->resource = $this->client->getFunktionaerResource();
		$this->resource->findeFunktionaerNachDtvId('DE100069436');

		// Client mit falschen Credentials => Execption falls er benutzt wird, sollte ja aber im Cache sein
		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			'wrong', 'wrong', $this->isCompressEnabled(), $this->isVerifySSL(), __DIR__ . '/cache_files/'
		);
		$this->resource = $this->client->getFunktionaerResource();
		$f = $this->resource->findeFunktionaerNachDtvId('DE100069436');
		$this->assertNotNull($f);
		$this->assertEquals('DE100069436', $f->id);
	}

	/**
	 * @test
	 */
	public function ungecached()
	{
		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isCompressEnabled(), $this->isVerifySSL(),
			__DIR__ . '/cache_files/'
		);
		$this->resource = $this->client->getFunktionaerResource();
		$f = $this->resource->findeFunktionaerNachDtvId('DE100015948');
		$this->assertNotNull($f);
		$this->assertEquals('DE100015948', $f->id);
	}

	/**
	 * @test
	 */
	public function cache_abgelaufen()
	{
		// Erster Aufruf => Resource wird gecached
		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isCompressEnabled(), $this->isVerifySSL(),
			__DIR__ . '/cache_files/'
		);
		$this->resource = $this->client->getFunktionaerResource();
		$this->resource->findeFunktionaerNachDtvId('DE100069436');

		// Cache-Datei manipulieren, sodass Test fehlschlägt, wenn Daten verwendet werden
		$file = __DIR__ . '/cache_files/6427a320b79c3ea6ea98408bfd18c11c';
		file_put_contents($file, str_replace('DE100069436', '0', file_get_contents($file)));

		sleep(3);

		$this->client = new \Tanzsport\ESV\API\Client(
			new \Tanzsport\ESV\API\Endpunkt($this->getEnv('ESV_ENDPOINT')), 'PHPUnit', $this->getEnv('ESV_TOKEN'),
			$this->getEnv('ESV_USER'), $this->getEnv('ESV_PASSWORD'), $this->isCompressEnabled(), $this->isVerifySSL(),
			__DIR__ . '/cache_files/', 1
		);
		$this->resource = $this->client->getFunktionaerResource();
		$f = $this->resource->findeFunktionaerNachDtvId('DE100069436');
		$this->assertNotNull($f);
		$this->assertEquals('DE100069436', $f->id);
	}
}
