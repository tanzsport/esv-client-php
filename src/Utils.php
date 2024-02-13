<?php

namespace Tanzsport\ESV\API;

class Utils
{

	/**
	 * @param array<string, bool|float|int|string|array<bool|float|int|string>> $values
	 * @return string
	 */
	public static function createQueryString(array $values): string
	{
		$qs = join("&", array_map(function ($key) use ($values) {
			$valueForKey = $values[$key];
			if (is_array($valueForKey)) {
				return join('&', array_map(function ($value) use ($key) {
					return "{$key}[]={$value}";
				}, array_values($valueForKey)));
			} else  {
				return "{$key}={$valueForKey}";
			}
		}, array_keys($values)));

		return $qs;
	}
}
