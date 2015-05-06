<?php

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