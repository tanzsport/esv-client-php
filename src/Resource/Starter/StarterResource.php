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

namespace Tanzsport\ESV\API\Resource\Starter;

use Tanzsport\ESV\API\Konstanten;
use Tanzsport\ESV\API\Model\Starter\Paar;
use Tanzsport\ESV\API\Model\Starter\Starter;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zu Abfrage von Startern.
 *
 * @package Tanzsport\ESV\API\Resource\Starter
 */
class StarterResource extends AbstractResource
{

	const PATH_ID = 'starter/%1$s';
	const PATH_DTV_OR_WDSF = 'starter/%1$s/%2$s';

	/**
	 * Sucht einen Starter anhand seiner ID; gibt null zurück, falls kein entsprechender Starter gefunden wird.
	 *
	 * @template T of mixed
	 *
	 * @param int $id
	 * @param class-string<T> $type Objekttyp für Deserialisierung, standardmäßig Tanzsport\ESV\API\Model\Starter
	 * @return T|null
	 */
	public function findeStarterNachId(int $id, string $type = Starter::class): mixed
	{
		return $this->getForEntity(sprintf(self::PATH_ID, $id), $type);
	}

	/**
	 * Sucht einen Starter anhand der Wettbewerbsart und der DTV-ID oder WDSF-MIN der beteiligten Personen; gibt
	 * null zurück, falls kein entsprechender Starter gefunden wird.
	 *
	 * @param string $wettbewerbsart Wettbewerbsart
	 * @param int|string $id DTV-ID oder WDSF-MIN einer der beteiligten Personen
	 * @return Starter|null
	 * @throws \InvalidArgumentException bei fehlenden Parametern oder ungültigter Wettebewerbsart
	 */
	public function findeStarterNachDtvOderWdsfId(string $wettbewerbsart, int|string $id): ?Starter
	{
		if (!in_array($wettbewerbsart, Konstanten::getWettbewerbsarten())) {
			throw new \InvalidArgumentException("Wettbewerbsart {$wettbewerbsart} wird nicht unterstützt.");
		}

		switch ($wettbewerbsart) {
			case Konstanten::WA_EINZEL:
				$type = Paar::class;
				break;
			default:
				throw new \InvalidArgumentException("Die Wettbewerbsart {$wettbewerbsart} wird noch nicht unterstützt.");
		}

		return $this->getForEntity(sprintf(self::PATH_DTV_OR_WDSF, $wettbewerbsart, $id), $type);
	}
}
