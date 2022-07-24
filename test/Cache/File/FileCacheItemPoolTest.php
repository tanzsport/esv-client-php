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

use Psr\Cache\CacheItemInterface;

class FileCacheItemPoolTest extends AbstractCacheTest
{

	/**
	 * @var \Tanzsport\ESV\API\Cache\File\FileCacheItemPool
	 */
	private $pool;

	/**
	 * @before
	 */
	public function before()
	{
		$this->pool = new FileCacheItemPool($this->getDirectory());
		$this->assertTrue($this->pool->clear());
	}

	/**
	 * @test
	 */
	public function create_nodir()
	{
		$this->expectExceptionMessage("Verzeichnis erforderlich");
		$this->expectException(\InvalidArgumentException::class);
		new FileCacheItemPool(null);
	}

	/**
	 * @test
	 */
	public function create_notexists()
	{
		$this->expectExceptionMessage("kein gültiges Verzeichnis");
		$this->expectException(\InvalidArgumentException::class);
		new FileCacheItemPool('/foo/bar');
	}

	/**
	 * @test
	 */
	public function getItem()
	{
		$item = $this->pool->getItem('foo');
		$this->assertNotNull($item);
		$this->assertEquals('foo', $item->getKey());
	}

	/**
	 * @test
	 */
	public function getItems()
	{
		$items = $this->pool->getItems(array());
		$this->assertTrue(is_array($items));
		$this->assertCount(0, $items);

		$items = $this->pool->getItems(array('foo', 'bar'));
		$this->assertTrue(is_array($items));
		$this->assertCount(2, $items);
	}

	/**
	 * @test
	 */
	public function save_delete()
	{
		$key = 'foo';

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertTrue($this->pool->save($item));

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertTrue($item->isHit());
		$this->assertNull($item->expires());
		$this->assertNull($item->get());

		$item = $this->pool->getItem($key);
		$time = time() + 3600;
		$item->expiresAt($time);
		$item->set('bar');
		$this->assertTrue($this->pool->save($item));

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertTrue($item->isHit());
		$this->assertEquals($time, $item->expires());
		$this->assertEquals('bar', $item->get());

		$this->assertTrue($this->pool->deleteItem($key));
	}

	/**
	 * @test
	 */
	public function saveDeferred_commit()
	{
		$key = 'foo';

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertFalse($item->isHit());

		$item->set('bar');
		$this->pool->saveDeferred($item);

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertFalse($item->isHit());

		$this->assertTrue($this->pool->commit());

		$item = $this->pool->getItem($key);
		$this->assertNotNull($item);
		$this->assertTrue($item->isHit());
	}


	/**
	 * @test
	 */
	public function items()
	{
		$keys = array('a', 'b');
		foreach ($keys as $key) {
			$item = $this->pool->getItem($key)->set('foo');
			$this->assertNotNull($item);
			$this->assertFalse($item->isHit());
			$this->assertNull($item->get());
			$this->assertTrue($this->pool->save($item));
		}
		$items = $this->pool->getItems($keys);
		$this->assertNotNull($items);
		$this->assertTrue(is_array($items));
		$this->assertCount(2, $items);
		foreach ($items as $key => $item) {
			$this->assertTrue($item->isHit());
			$this->assertEquals('foo', $item->get());
			$this->assertTrue($this->pool->hasItem($key));
		}
		$this->assertTrue($this->pool->deleteItems($keys));
		$items = $this->pool->getItems($keys);
		$this->assertNotNull($items);
		$this->assertTrue(is_array($items));
		$this->assertCount(2, $items);
		foreach ($items as $item) {
			$this->assertFalse($item->isHit());
			$this->assertNull($item->get());
			$this->assertFalse($this->pool->hasItem($key));
		}
	}

	/**
	 * @test
	 */
	public function donotsave_other()
	{
		$item = \Mockery::mock(CacheItemInterface::class);
		$this->assertFalse($this->pool->save($item));
	}

	/**
	 * @test
	 */
	public function hasNotItem()
	{
		$this->assertFalse($this->pool->hasItem('foo'));
	}
}
