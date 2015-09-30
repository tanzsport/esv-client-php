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

use Tanzsport\ESV\API\Model\Funktionaer\Funktionaer;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zur Abfrage von Funktionären.
 *
 * @package Tanzsport\ESV\API\Resource\Funktionaer
 */
class FunktionaerResource extends AbstractResource
{

	const URL_ID = 'api/v1/funktionaer/%1$s';
	const URL_LIST = 'api/v1/funktionaere';

	/**
	 * Sucht einen Funktionär anhand seiner DTV-ID; gibt null zurück, falls kein entsprechender Funktionär gefunden wird.
	 *
	 * @param $id DTV-ID des Funktionärs
	 * @return Funktionaer|null
	 */
	public function findeFunktionaerNachDtvId($id)
	{
		if (!$id) {
			throw new \InvalidArgumentException('DTV-ID erforderlich!');
		}

		$response = $this->doGet(sprintf(self::URL_ID, $id));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'Tanzsport\ESV\API\Model\Funktionaer\Funktionaer');
		}
	}

	/**
	 * Lädt die Gesamtliste aller Funktionäre (aus Datenschutzgründen ohne Titel und Vor- sowie Nachnamen).
	 *
	 * @return Funktionaer[]
	 */
	public function findeAlleFunktionaere()
	{
		$response = $this->doGet(sprintf(self::URL_LIST));
		if ($response != null) {
			return $this->deserializeJson($response->getBody(), 'array<Tanzsport\ESV\API\Model\Funktionaer\Funktionaer>');
		}
	}
}