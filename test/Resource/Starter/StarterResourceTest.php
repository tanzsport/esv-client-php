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

class StarterResourceTestCase extends AbstractTestCase
{

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
	public function findeStarterNachId()
	{
		//$this->resource->findeStarterNachId(135088);
		$this->markTestIncomplete('API ist noch nicht implementiert.');
	}

	/**
	 * @test
	 */
	public function findeStarterNachDtvId()
	{
		$starter = $this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, "DE100092217");
		$this->assertNotNull($starter);
	}

	/**
	 * @test
	 */
	public function findeStarterNachWdsfId()
	{
		$paar = $this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, 10059600);

		$this->assertNotNull($paar);
		$this->assertNotNull($paar->id);

		$this->assertNotNull($paar->partner);
		$this->assertTrue($paar->partner->maennlich);
		$this->assertEquals("DE100092217", $paar->partner->id);
		$this->assertNotNull($paar->partner->vorname);
		$this->assertNotNull($paar->partner->nachname);
		$this->assertEquals(10059600, $paar->partner->wdsfMin);

		$this->assertNotNull($paar->partnerin);
		$this->assertFalse($paar->partnerin->maennlich);
		$this->assertEquals("DE100092152", $paar->partnerin->id);
		$this->assertNotNull($paar->partnerin->vorname);
		$this->assertNotNull($paar->partnerin->nachname);
		$this->assertEquals(10061867, $paar->partnerin->wdsfMin);
	}

	/**
	 * @test
	 */
	public function findeStarterNachWdsfId_NotFound()
	{
		$this->assertNull($this->resource->findeStarterNachDtvOderWdsfId(\Tanzsport\ESV\API\Konstanten::WA_EINZEL, 1));
	}
}
