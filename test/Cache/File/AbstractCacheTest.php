<?php
namespace Tanzsport\ESV\API\Cache\File;

class AbstractCacheTest extends \PHPUnit_Framework_TestCase
{

	protected function getDirectory()
	{
		return __DIR__ . '/../../../.cache';
	}
}
