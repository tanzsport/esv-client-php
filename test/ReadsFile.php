<?php

namespace Tanzsport\ESV\API;

trait ReadsFile
{

	public function readFile($path)
	{
		if (!file_exists($path)) {
			throw new \InvalidArgumentException("Datei $path existiert nicht!");
		}
		return file_get_contents($path);
	}
}
