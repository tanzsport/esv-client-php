<?php
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
