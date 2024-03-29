<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2019 Deutscher Tanzsportverband e.V.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
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

use Tanzsport\ESV\API\Model\Funktionaer\Funktionaer;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zur Abfrage von Funktionären.
 *
 * @package Tanzsport\ESV\API\Resource\Funktionaer
 */
class FunktionaerResource extends AbstractResource
{

	const PATH_ID = 'funktionaer/%1$s';
	const PATH_LIST = 'funktionaere';

	/**
	 * Sucht einen Funktionär anhand seiner DTV-ID; gibt null zurück, falls kein entsprechender Funktionär gefunden wird.
	 *
	 * @param string $id DTV-ID des Funktionärs
	 * @return Funktionaer|null
	 */
	public function findeFunktionaerNachDtvId(string $id): ?Funktionaer
	{
		return $this->getForEntity(sprintf(self::PATH_ID, $id), Funktionaer::class);
	}

	/**
	 * Lädt die Gesamtliste aller Funktionäre (aus Datenschutzgründen ohne Titel und Vor- sowie Nachnamen).
	 *
	 * @return array<Funktionaer>
	 */
	public function findeAlleFunktionaere(): array
	{
		return $this->getForList(self::PATH_LIST, Funktionaer::class);
	}
}
