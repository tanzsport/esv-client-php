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

namespace Tanzsport\ESV\API\Resource\Veranstaltung;

use GuzzleHttp\Psr7\Response;
use Tanzsport\ESV\API\AbstractTestCase;
use Tanzsport\ESV\API\ReadsFile;

class VeranstaltungResourceTest extends AbstractTestCase
{

	use ReadsFile;

	/**
	 * @var \Tanzsport\ESV\API\MockClient
	 */
	private $client;

	/**
	 * @var \Tanzsport\ESV\API\Resource\Veranstaltung\VeranstaltungResource
	 */
	private $resource;

	/**
	 * @before
	 */
	public function before()
	{
		$this->client = $this->createClient();
		$this->resource = $this->client->getVeranstaltungResource();
	}

	/**
	 * @test
	 */
	public function liste()
	{
		$this->client->getMockHandler()->append(
			new Response(200, ['content-type' => 'application/json'], $this->readFile(__DIR__ . '/json/liste.json'))
		);
		$liste = $this->resource->getVeranstaltungen();
		$this->assertNotNull($liste);
		$this->assertCount(2, $liste);
		foreach ($liste as $v) {
			$this->assertTrue(is_a($v, 'Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung'));
		}
		$this->assertCount(0, $this->client->getMockHandler());
	}

	/**
	 * @test
	 */
	public function id()
	{
		$this->client->getMockHandler()->append(
			new Response(200, ['content-type' => 'application/json'], $this->readFile(__DIR__ . '/json/einzelaufruf.json'))
		);
		$v = $this->resource->getVeranstaltungById(1);
		$this->assertNotNull($v);
		$this->assertCount(0, $this->client->getMockHandler());
	}
}
