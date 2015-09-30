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

namespace Tanzsport\ESV\API\Model\Starter;

use Tanzsport\ESV\API\Model\Person;

/**
 * Starter vom Typ Paar.
 *
 * @package Tanzsport\ESV\API\Model\Starter
 * @property-read Person $partner Partner
 * @property-read Person $partnerin Partnerin
 */
class Paar extends Starter
{

	public function __get($key)
	{
		switch ($key) {
			case 'partner':
				return $this->getPerson(0);
			case 'partnerin':
				return $this->getPerson(1);
			default:
				return parent::__get($key);
		}
	}

	public function __isset($key)
	{
		switch ($key) {
			case 'partner':
				return $this->personExists(0);
			case 'partnerin':
				return $this->personExists(1);
			default:
				return parent::__isset($key);
		}
	}
}
