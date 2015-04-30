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
		//$f = $this->resource->findeFunktionaerNachDtvId('DE100069436');
		$this->markTestIncomplete('API ist noch nicht implementiert.');
	}
}