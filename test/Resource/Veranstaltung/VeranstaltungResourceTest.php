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

namespace Tanzsport\ESV\API\Resource\Veranstaltung;

use Tanzsport\ESV\API\AbstractTestCase;

class VeranstaltungResourceTest extends AbstractTestCase
{

	/**
	 * @var \Tanzsport\ESV\API\Resource\Veranstaltung\VeranstaltungResource
	 */
	private $resource;

	public function setUp()
	{
		parent::setUp();
		$this->resource = $this->client->getVeranstaltungResource();
	}

	/**
	 * @test
	 */
	public function liste()
	{
		$liste = $this->resource->getVeranstaltungen();
		$this->assertNotNull($liste);
		if (count($liste) > 0) {
			foreach ($liste as $v) {
				$this->assertTrue(is_a($v, 'Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung'));
			}
		} else {
			$this->markTestIncomplete('Veranstaltungsliste enthält keine Elemente.');
		}
	}

	/**
	 * @test
	 */
	public function id()
	{
		$liste = $this->resource->getVeranstaltungen();
		$this->assertNotNull($liste);
		if (count($liste) > 0) {
			$id = $liste[0]->id;
			$v = $this->resource->getVeranstaltungById($id);
			$this->assertNotNull($v);
			$this->assertEquals($id, $v->id);
			$this->assertNotNull($v->veranstalter);
			$this->assertNotNull($v->ausrichter);
		} else {
			$this->markTestIncomplete('Veranstaltungsliste enthält keine Elemente.');
		}
	}
}