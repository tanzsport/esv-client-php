<?php

namespace Tanzsport\ESV\API;

use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{

	/**
	 * @test
	 * @dataProvider createQueryStringDataProvider
	 */
	public function createQueryString(array $input, ?string $expected): void
	{
		$this->assertEquals($expected, Utils::createQueryString($input));
	}

	public function createQueryStringDataProvider(): array
	{
		return [
			'empty array' => [
				[],
				null
			],
			'single parameter' => [
				['foo' => 'bar'],
				'foo=bar'
			],
			'multi parameter' => [
				['foo' => ['bar', 'cux']],
				'foo[]=bar&foo[]=cux'
			]
		];
	}
}
