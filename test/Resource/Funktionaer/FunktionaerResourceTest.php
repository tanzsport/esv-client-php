<?php

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
