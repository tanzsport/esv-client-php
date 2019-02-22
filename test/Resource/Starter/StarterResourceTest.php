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

namespace Tanzsport\ESV\API\Resource\Starter;

use GuzzleHttp\Psr7\Response;
use Tanzsport\ESV\API\AbstractTestCase;
use Tanzsport\ESV\API\ReadsFile;

class StarterResourceTestCase extends AbstractTestCase
{

	use ReadsFile;

	/**
	 * @var \Tanzsport\ESV\API\Resource\Starter\StarterResource
	 */
	private $resource;

	public function setUp()
	{
		parent::setUp();
		$this->resource = $this->client->getStarterResource();
	}

	/**
	 * @test
	 */
	public function findeStarterNachDtvId()
	{
		$this->client->getMockHandler()->append(
			new Response(200, ['content-type' => 'application/json'], $this->readFile(__DIR__ . '/json/empty-object.json'))
		);
		$starter = $this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, "DE100001050");
		$this->assertNotNull($starter);
		$this->assertCount(0, $this->client->getMockHandler());
	}

	/**
	 * @test
	 */
	public function findeStarterNachWdsfId()
	{
		$this->client->getMockHandler()->append(
			new Response(200, ['content-type' => 'application/json'], $this->readFile(__DIR__ . '/json/empty-object.json'))
		);
		$paar = $this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, 10059600);
		$this->assertNotNull($paar);
		$this->assertCount(0, $this->client->getMockHandler());
	}

	/**
	 * @test
	 */
	public function findeStarterNachWdsfId_NotFound()
	{
		$this->client->getMockHandler()->append(
			new Response(404, [])
		);
		$this->assertNull($this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, 1));
		$this->assertCount(0, $this->client->getMockHandler());
	}
}
