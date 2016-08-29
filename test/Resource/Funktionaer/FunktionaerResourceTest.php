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

namespace Tanzsport\ESV\API\Resource\Funktionaer;

use Tanzsport\ESV\API\AbstractTestCase;

class FunktionaerResourceTest extends AbstractTestCase
{

	/**
	 * @var \Tanzsport\ESV\API\Resource\Funktionaer\FunktionaerResource
	 */
	private $resource;

	public function setUp()
	{
		parent::setUp();
		$this->resource = $this->client->getFunktionaerResource();
	}

	/**
	 * @test
	 */
	public function einzelaufruf()
	{
		$f = $this->resource->findeFunktionaerNachDtvId('DE100069436');
		$this->assertNotNull($f);
		$this->assertEquals('DE100069436', $f->id);
	}

	/**
	 * @test
	 */
	public function liste()
	{
		$liste = $this->resource->findeAlleFunktionaere();
		$this->assertNotNull($liste);
		if(count($liste) > 0) {
			foreach($liste as $f) {
				$this->assertTrue(is_a($f, 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer'));
			}
		}
		else {
			$this->markTestIncomplete('Keine Funktionäre geladen.');
		}
	}
}
