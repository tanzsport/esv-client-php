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

namespace Tanzsport\ESV\API\Resource\Veranstaltung;

use Tanzsport\ESV\API\Model\Veranstaltung\Veranstaltung;
use Tanzsport\ESV\API\Model\Veranstaltung\VeranstaltungMitTurnieren;
use Tanzsport\ESV\API\Resource\AbstractResource;

/**
 * Resource zur Abfrage von Veranstaltungen.
 *
 * @package Tanzsport\ESV\API\Resource\Veranstaltung
 */
class VeranstaltungResource extends AbstractResource
{

	const PATH_LIST = 'veranstaltungen';
	const PATH_ID = 'turniere/%1$s';

	/**
	 * Gibt alle Veranstaltungen zurück, auf die der aktuelle Benutzer Zugriff hat
	 *
	 * @return array<Veranstaltung>
	 */
	public function getVeranstaltungen(?string $ltv = null): array
	{
		return $this->getForList(self::PATH_LIST, Veranstaltung::class,
			'application/vnd.tanzsport.esv.v1.veranstaltungsliste.l2+json', $ltv ? ['ltv' => $ltv] : null);
	}

	/**
	 * Sucht eine Veranstaltung anhand ihrer ID.
	 *
	 * @param $id ID der Veranstaltung
	 * @return VeranstaltungMitTurnieren|null
	 */
	public function getVeranstaltungById(int $id): ?VeranstaltungMitTurnieren
	{
		return $this->getForEntity(sprintf(self::PATH_ID, $id), VeranstaltungMitTurnieren::class, null,
			'application/vnd.tanzsport.esv.v1.veranstaltung.l2+json');
	}
}
