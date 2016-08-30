<?php
namespace Tanzsport\ESV\API\Cache\File;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class FileCacheItemPool implements CacheItemPoolInterface
{

	/**
	 * @var string Cache-Verzeichnis
	 */
	private $path;

	/**
	 * @var CacheItemInterface[]
	 */
	private $deferred = array();

	public function __construct($directory)
	{
		if (!$directory) {
			throw new \InvalidArgumentException('Verzeichnis erforderlich!');
		}
		$this->path = realpath($directory);
		if (!$this->path || !is_dir($this->path)) {
			throw new \InvalidArgumentException("${directory} ist kein gültiges Verzeichnis!");
		}
		if (!is_writable($this->path)) {
			throw new \InvalidArgumentException("${directory} ist nicht beschreibbar!");
		}
	}

	public function getItem($key)
	{
		return new FileCacheItem($key, $this->path);
	}

	public function getItems(array $keys = array())
	{
		if (empty($keys)) {
			return array();
		}
		$items = [];
		foreach ($keys as $key) {
			$items[$key] = $this->getItem($key);
		}
		return $items;
	}

	public function hasItem($key)
	{
		return $this->getItem($key)->isHit();
	}

	public function clear()
	{
		$cleared = true;
		$directoryIterator = new \DirectoryIterator($this->path);
		foreach ($directoryIterator as $entry) {
			if ($entry->isFile() && !$entry->isDot()) {
				if (!@unlink($entry->getPathname())) {
					// @codeCoverageIgnoreStart
					$cleared = false;
				}
				// @codeCoverageIgnoreEnd
			}
		}
		return $cleared;
	}

	public function deleteItem($key)
	{
		return $this->getItem($key)->delete();
	}

	public function deleteItems(array $keys)
	{
		$allDeleted = true;
		foreach ($keys as $key) {
			if (!$this->deleteItem($key)) {
				// @codeCoverageIgnoreStart
				$allDeleted = false;
			}
			// @codeCoverageIgnoreEnd
		}
		return $allDeleted;
	}

	public function save(CacheItemInterface $item)
	{
		if ($item instanceof FileCacheItem) {
			return $item->save();
		}
		return false;
	}

	public function saveDeferred(CacheItemInterface $item)
	{
		$this->deferred[$item->getKey()] = $item;
	}

	public function commit()
	{
		$allSaved = true;
		foreach ($this->deferred as $key => $item) {
			if (!$this->save($item)) {
				// @codeCoverageIgnoreStart
				$allSaved = false;
			}
			// @codeCoverageIgnoreEnd
		}
		return $allSaved;
	}
}
