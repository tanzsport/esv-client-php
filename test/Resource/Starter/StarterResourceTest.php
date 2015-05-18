<?php

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
