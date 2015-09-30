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

namespace Tanzsport\ESV\API;

/**
 * API-Konstanten.
 *
 * @package Tanzsport\ESV\Api
 */
class Konstanten
{

	const WA_DUO = 'Duo';
	const WA_EINZEL = 'Einzel';
	const WA_FORMATION_JMD = 'FormationJMD';
	const WA_FORMATION_STLAT = 'FormationStdLat';
	const WA_MANNSCHAFT = 'Mannschaft';
	const WA_SMALLGROUP = 'SmallGroup';
	const WA_SOLO = 'Solo';
	const WA_SOLO_MAENNLICH = 'SoloMaennlich';
	const WA_SOLO_WEIBLICH = 'SoloWeiblich';

	const GESCHLECHT_M = 'm';
	const GESCHLECHT_W = 'w';

	private static $wa = array(self::WA_DUO, self::WA_EINZEL, self::WA_FORMATION_JMD, self::WA_FORMATION_STLAT,
		self::WA_MANNSCHAFT, self::WA_SMALLGROUP, self::WA_SOLO, self::WA_SOLO_MAENNLICH, self::WA_SOLO_WEIBLICH);

	private function __construct()
	{
	}

	/**
	 * Gibt alle Wettbewerbsarten zurück.
	 *
	 * @return string[]
	 */
	public static function getWettbewerbsarten()
	{
		return self::$wa;
	}
}
