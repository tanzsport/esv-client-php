<?php
namespace Tanzsport\ESV\API\Cache\File;

use Psr\Cache\CacheItemInterface;

class FileCacheItem implements CacheItemInterface
{

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @var boolean
	 */
	private $hit = false;

	/**
	 * @var int|null
	 */
	private $expires = null;

	/**
	 * @var mixed
	 */
	private $unsavedValue;

	public function __construct($key, $directory)
	{
		if ($key === null) {
			throw new InvalidArgumentException('Cache-Schlüssel erforderlich!');
		}
		if (!is_string($key)) {
			throw new InvalidArgumentException('Cache-Schlüssel muss ein String sein!');
		}
		if (!preg_match('/^[A-Za-z0-9_\-]+$/', $key)) {
			throw new InvalidArgumentException('Cache-Schlüssel ist ungültig!');
		}
		$this->key = $key;
		$this->path = $directory . DIRECTORY_SEPARATOR . $key;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function get()
	{
		$this->read();
		return $this->value;
	}

	public function isHit()
	{
		$this->read();
		return $this->hit;
	}

	public function set($value)
	{
		$this->unsavedValue = $value;
		return $this;
	}

	public function expiresAt($expiration)
	{
		if ($expiration instanceof \DateTimeInterface) {
			$this->expires = $expiration->getTimestamp();
		} else if (is_int($expiration)) {
			$this->expires = $expiration;
		} else if ($expiration === null) {
			$this->expires = null;
		} else {
			throw new \InvalidArgumentException('Ablaufzeitpunkt muss vom Typ \DateTimeInterface, int oder NULL sein!');
		}

		return $this;
	}

	public function expiresAfter($time)
	{
		if ($time instanceof \DateInterval) {
			$this->expiresAt(\DateTime::createFromFormat('U', time())->add($time));
		} else if (is_int($time)) {
			$this->expiresAt(time() + $time);
		} else if ($time === null) {
			$this->expiresAt(null);
		} else {
			throw new \InvalidArgumentException('Ablaufzeit muss vom Typ \DateInterval, int oder NULL sein!');
		}

		return $this;
	}

	public function delete()
	{
		if ($this->exists()) {
			return @unlink($this->path);
		}
		return false;
	}

	public function exists()
	{
		return file_exists($this->path);
	}

	public function expires()
	{
		return $this->expires;
	}

	private function read()
	{
		if ($this->exists()) {
			if (($contents = file_get_contents($this->path)) !== false) {
				$item = unserialize($contents);
				if (array_key_exists('expires', $item) && array_key_exists('value', $item)) {
					$expires = $item['expires'];
					if ($expires === null || $expires >= time()) {
						$this->hit = true;
						$this->expires = $expires;
						$this->value = $item['value'];
						$this->unsavedValue = $item['value'];
					}
				}
			}
		}
	}

	public function save()
	{
		return @file_put_contents($this->path, serialize(array('expires' => $this->expires, 'value' => $this->unsavedValue))) > 0;
	}
}
