<?php

class DeserializationTest extends AbstractTestCase
{

	/**
	 * @test
	 */
	public function club()
	{
		$club = $this->deserialize('Club.json', 'Tanzsport\ESV\API\Model\Club');
		$this->assertEquals(1, $club->id);
		$this->assertEquals("Verein", $club->name);
		$this->assertNotNull($club->ltv);
	}

	/**
	 * @test
	 */
	public function ltv()
	{
		$ltv = $this->deserialize('LTV.json', 'Tanzsport\ESV\API\Model\LTV');
		$this->assertEquals(1, $ltv->id);
		$this->assertEquals('LTV', $ltv->name);
	}

	/**
	 * @test
	 */
	public function funktionaer()
	{
		$f = $this->deserialize('Funktionaer.json', 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer');
		$this->assertEquals('DE100092217', $f->id);
		$this->assertEquals(10099999, $f->wdsfMin);
		$this->assertEquals(12345, $f->lizenzNr);
		$this->assertNull($f->titel);
		$this->assertEquals('Max', $f->vorname);
		$this->assertEquals('Mustermann', $f->nachname);
		$this->assertNotNull($f->club);
		$this->assertEquals(1, $f->club->id);
		$this->assertEquals("Verein", $f->club->name);
		$this->assertNotNull($f->club->ltv);
		$this->assertEquals(1, $f->club->ltv->id);
		$this->assertEquals("LTV", $f->club->ltv->name);
		$this->assertEquals('GER', $f->staat);
		$this->assertCount(3, $f->lizenzen);
		foreach (array('TL', 'WR-A-Lat', 'WR-S-Std') as $l) {
			$this->assertTrue(in_array($l, $f->lizenzen));
		}
	}

	/**
	 * @test
	 */
	public function funktionaere()
	{
		$liste = $this->deserialize('Funktionaere.json', 'array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>');
		$this->assertNotNull($liste);
		$this->assertCount(2, $liste);
		$this->assertTrue(is_a($liste[0], 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer'));
	}

	/**
	 * @test
	 */
	public function person()
	{
		$person = $this->deserialize('Person.json', 'Tanzsport\ESV\API\Model\Person');
		$this->assertEquals("DE100092217", $person->id);
		$this->assertEquals("Dr.", $person->titel);
		$this->assertEquals("Vorname", $person->vorname);
		$this->assertEquals("Nachname", $person->nachname);
		$this->assertTrue($person->maennlich);
		$this->assertEquals(1, $person->wdsfMin);
		$this->assertEquals("GER", $person->nationalitaet);
	}

	/**
	 * @test
	 */
	public function paar()
	{
		$paar = $this->deserialize('Paar.json', 'Tanzsport\ESV\API\Model\Starter\Paar');
		$this->assertEquals(1, $paar->id);

		$this->assertNotNull($paar->partner);
		$this->assertEquals("DE100092217", $paar->partner->id);
		$this->assertNull($paar->partner->titel);
		$this->assertEquals("Vorname 1", $paar->partner->vorname);
		$this->assertEquals("Nachname 1", $paar->partner->nachname);
		$this->assertTrue($paar->partner->maennlich);
		$this->assertEquals(1, $paar->partner->wdsfMin);
		$this->assertEquals("GER", $paar->partner->nationalitaet);

		$this->assertNotNull($paar->partnerin);
		$this->assertEquals("DE100092152", $paar->partnerin->id);
		$this->assertNull($paar->partnerin->titel);
		$this->assertEquals("Vorname 2", $paar->partnerin->vorname);
		$this->assertEquals("Nachname 2", $paar->partnerin->nachname);
		$this->assertFalse($paar->partnerin->maennlich);
		$this->assertEquals(2, $paar->partnerin->wdsfMin);
		$this->assertEquals("GER", $paar->partnerin->nationalitaet);

		$this->assertNotNull($paar->club);
		$this->assertEquals(1, $paar->club->id);
		$this->assertEquals("Verein", $paar->club->name);
		$this->assertNotNull($paar->club->ltv);
		$this->assertEquals(1, $paar->club->ltv->id);
		$this->assertEquals("LTV", $paar->club->ltv->name);

		$this->assertEquals("GER", $paar->staat);
	}

	private function deserialize($file, $type)
	{
		$object = $this->client->getSerializer()->deserialize(file_get_contents(__DIR__ . '/' . $file), $type, 'json');
		$this->assertNotNull($object);
		if (class_exists($type, false)) {
			$this->assertTrue(is_a($object, $type));
		}
		return $object;
	}
}
