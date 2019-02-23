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

namespace Tanzsport\ESV\API\Cache\File;

class FileCacheItemTest extends AbstractCacheTest
{

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $directory;

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var FileCacheItem
	 */
	private $item;

	/**
	 * @before
	 **/
	public function before()
	{
		$this->key = 'key';
		$this->directory = $this->getDirectory();
		if (!file_exists($this->directory)) {
			if (!mkdir($this->directory, 0777, true)) {
				throw new \RuntimeException("{$this->directory} konnte nicht erstellt werden!");
			}
		}
		$this->file = $this->directory . DIRECTORY_SEPARATOR . $this->key;
		if (file_exists($this->file)) {
			if (!@unlink($this->file)) {
				throw new \RuntimeException("{$this->file} konnte nicht gelöscht werden!");
			}
		}
		$this->item = new FileCacheItem($this->key, $this->directory);
		$this->assertFalse($this->item->exists());
		$this->assertEquals($this->key, $this->item->getKey());
	}

	/**
	 * @test
	 */
	public function save_delete()
	{
		$this->assertFalse($this->item->exists());

		$this->item->set(null);
		$this->item->save();
		$this->assertTrue($this->item->exists());
		$this->assertTrue(file_exists($this->file));

		$this->item->delete();
		$this->assertFalse($this->item->exists());
		$this->assertFalse(file_exists($this->file));
	}

	/**
	 * @test
	 */
	public function expires()
	{
		$this->assertNull($this->item->expires());

		$int = time() + 3600;
		$this->item->expiresAt($int);
		$this->assertEquals($int, $this->item->expires());
		$datetime = \DateTime::createFromFormat('U', $int);
		$this->item->expiresAt($datetime);
		$this->assertEquals($int, $this->item->expires());
		$this->item->expiresAt(null);
		$this->assertNull($this->item->expires());

		$time = time();
		$int = 3600;
		$this->item->expiresAfter($int);
		$this->assertTrue($this->item->expires() - $time - $int <= 2);
		$this->item->expiresAfter(new \DateInterval("PT{$int}S"));
		$this->assertTrue($this->item->expires() - $time - $int <= 2);
		$this->item->expiresAfter(null);
		$this->assertNull($this->item->expires());
	}

	/**
	 * @test
	 */
	public function hit()
	{
		$time = time() + 3600;
		$this->assertTrue($this->item->set('foo')->expiresAt($time)->save());

		$item = new FileCacheItem($this->key, $this->directory);
		$this->assertTrue($item->exists());
		$this->assertEquals('foo', $item->get());
		$this->assertEquals('foo', $item->get());
		$this->assertEquals($time, $item->expires());
		$this->assertTrue($item->isHit());
		$this->assertTrue($item->isHit());

		$time = time() - 3600;
		$this->item->expiresAt($time);
		$this->item->save();

		$item = new FileCacheItem($this->key, $this->directory);
		$this->assertTrue($item->exists());
		$this->assertFalse($item->isHit());
	}

	/**
	 * @test
	 */
	public function miss()
	{
		$key = 'foo';
		$item = new FileCacheItem($key, $this->directory);
		$this->assertFalse(file_exists($this->directory . DIRECTORY_SEPARATOR . $key));
		$this->assertNull($item->get());
		$this->assertFalse($item->isHit());
		$this->assertFalse($item->delete());
	}

	/**
	 * @test
	 * @expectedException \Tanzsport\ESV\API\Cache\File\InvalidArgumentException
	 * @expectedExceptionMessage erforderlich
	 */
	public function key_null()
	{
		new FileCacheItem(null, '/foo');
	}

	/**
	 * @test
	 * @expectedException \Tanzsport\ESV\API\Cache\File\InvalidArgumentException
	 * @expectedExceptionMessage String
	 */
	public function key_int()
	{
		new FileCacheItem(1, '/foo');
	}

	/**
	 * @test
	 * @expectedException \Tanzsport\ESV\API\Cache\File\InvalidArgumentException
	 * @expectedExceptionMessage ungültig
	 */
	public function key_invalid()
	{
		new FileCacheItem('/foo/bar', '/foo');
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Ablaufzeitpunkt
	 */
	public function expiresat_invalid()
	{
		$this->item->expiresAt(array());
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Ablaufzeit
	 */
	public function expiresafter_invalid()
	{
		$this->item->expiresAfter(array());
	}
}
