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

namespace Tanzsport\ESV\API;

/**
 * API-Endpunkt.
 *
 * @package Tanzsport\ESV\API
 */
class Endpunkt
{

	const PROD = 'https://ev.tanzsport-portal.de/api/v1';

	const QA = 'https://dtv-esv-qa.azurewebsites.net/api/v1';

	public function __construct(
		private string $baseUrl
	)
	{
	}

	/**
	 * Gibt die Basis-URL zurück.
	 *
	 * @return string
	 */
	public function getBaseUrl(): string
	{
		return $this->baseUrl;
	}

	/**
	 * Endpunkt für das Produktivsystem.
	 *
	 * @return Endpunkt
	 */
	static function Prod(): Endpunkt
	{
		return new Endpunkt(self::PROD);
	}

	/**
	 * Endpunkt für das QA-System.
	 *
	 * @return Endpunkt
	 */
	static function Qa(): Endpunkt
	{
		return new Endpunkt(self::QA);
	}
}
