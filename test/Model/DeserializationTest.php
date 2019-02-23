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

namespace Tanzsport\ESV\API\Model;

use Tanzsport\ESV\API\AbstractTestCase;

class DeserializationTest extends AbstractTestCase
{

	/**
	 * @var \Tanzsport\ESV\API\MockClient
	 */
	private $client;

	/**
	 * @before
	 */
	public function before()
	{
		$this->client = $this->createClient();
	}

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
		$this->assertEquals('DE100001050', $f->id);
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
	public function flaeche()
	{
		$f = $this->deserialize('Flaeche.json', 'Tanzsport\ESV\API\Model\Veranstaltung\Flaeche');
		$this->assertEquals("Fläche 1", $f->id);
		$this->assertEquals("Parkett", $f->typ);
		$this->assertEquals(10.5, $f->laenge);
		$this->assertEquals(8.5, $f->breite);
	}

	/**
	 * @test
	 */
	public function funktionaere()
	{
		$liste = $this->deserialize('Funktionaere.json', 'array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>');
		$this->assertCount(2, $liste);
		$this->assertTrue(is_a($liste[0], 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer'));
	}

	/**
	 * @test
	 */
	public function person()
	{
		$person = $this->deserialize('Person.json', 'Tanzsport\ESV\API\Model\Person');
		$this->assertEquals("DE100001025", $person->id);
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
		$this->assertEquals("DE100001033", $paar->partner->id);
		$this->assertNull($paar->partner->titel);
		$this->assertEquals("Vorname 1", $paar->partner->vorname);
		$this->assertEquals("Nachname 1", $paar->partner->nachname);
		$this->assertTrue($paar->partner->maennlich);
		$this->assertEquals(1, $paar->partner->wdsfMin);
		$this->assertEquals("GER", $paar->partner->nationalitaet);

		$this->assertNotNull($paar->partnerin);
		$this->assertEquals("DE100001041", $paar->partnerin->id);
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

	/**
	 * @test
	 */
	public function turnier()
	{
		$t = $this->deserialize('Turnier.json', 'Tanzsport\ESV\API\Model\Veranstaltung\Turnier');
		$datum = new \DateTime('2014-04-18');
		$this->assertEquals(40434, $t->id);
		$this->assertEquals($datum, $t->datumVon);
		$this->assertEquals($datum, $t->datumBis);
		$this->assertEquals("09:00", $t->startzeitPlan);
		$this->assertEquals("09:10", $t->startzeitPlanKorrigiert);
		$this->assertEquals("XXL-Cup", $t->titel);
		$this->assertNotNull($t->veranstalter);
		$this->assertEquals(1, $t->veranstalter->id);
		$this->assertNotNull($t->ausrichter);
		$this->assertEquals(8002, $t->ausrichter->id);
		$this->assertEquals("Fl. 1+2", $t->flaechenId);
		$this->assertEquals("Einzel", $t->wettbewerbsart);
		$this->assertEquals("RLT", $t->turnierform);
		$this->assertEquals("Hgr", $t->startgruppe);
		$this->assertEquals("S", $t->startklasseLiga);
		$this->assertEquals("Std", $t->turnierart);
		$this->assertNotNull($t->zulassung);
		$this->assertCount(1, $t->zulassung);
		$this->assertContains('WDSF', $t->zulassung);
		$this->assertTrue($t->wanderpokal);
		$this->assertEquals(1, $t->turnierrang);
		$this->assertTrue($t->aufstiegsturnier);
		$this->assertEquals("Hgr-Std", $t->ranglistenId);
		$this->assertEquals(4711, $t->wdsfTurnierId);
		$this->assertEquals("25 EUR", $t->startgebuehr);
		$this->assertEquals("Bemerkungen Turnier", $t->bemerkungen);
		$this->assertNotNull($t->wertungsrichter);
		$this->assertCount(3, $t->wertungsrichter);
		foreach (array("DE100002005", "DE100002013", "DE100020127") as $id) {
			$this->assertContains($id, $t->wertungsrichter);
		}
		$this->assertEquals("DE100020135", $t->turnierleiter);
		$this->assertEquals("DE100020143", $t->beisitzer);
		$this->assertEquals("DE100020151", $t->chairman);
	}

	/**
	 * @test
	 */
	public function turnierstaette()
	{
		$t = $this->deserialize('Turnierstaette.json', 'Tanzsport\ESV\API\Model\Veranstaltung\Turnierstaette');
		$this->assertEquals("Vereinsheim", $t->name);
		$this->assertEquals("Musterstr. 1", $t->anschrift);
		$this->assertEquals("12345", $t->plz);
		$this->assertEquals("Berlin", $t->ort);
	}

	/**
	 * @test
	 */
	public function veranstaltung()
	{
		$v = $this->deserialize('Veranstaltung.json', 'Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung');
		$von = new \DateTime('2014-04-18');
		$bis = new \DateTime('2014-04-21');
		$this->assertEquals(2001, $v->id);
		$this->assertEquals($von, $v->datumVon);
		$this->assertEquals($bis, $v->datumBis);
		$this->assertEquals('Berlin', $v->ort);
		$this->assertEquals('Blaues Band der Spree', $v->titel);
	}

	private function deserialize($file, $type)
	{
		$object = $this->client->getSerializer()->deserialize(file_get_contents(__DIR__ . '/json/' . $file), $type, 'json');
		$this->assertNotNull($object);
		if (class_exists($type, false)) {
			$this->assertTrue(is_a($object, $type));
		}
		return $object;
	}
}
