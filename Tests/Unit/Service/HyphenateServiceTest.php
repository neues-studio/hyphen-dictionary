<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020 Neues Studio <team@neues.studio>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

namespace NeuesStudio\HyphenDictionary\Tests\Unit\Service;

use NeuesStudio\HyphenDictionary\Service\HyphenateService;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test class for \NeuesStudio\HyphenDictionary\Service\HyphenateService
 */
class HyphenateServiceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function hyphenateWithNoDictionaryItems()
    {
        $subject = $this->getMockBuilder(HyphenateService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDictionaryItems'])
            ->getMock();
        $subject->method('getDictionaryItems')->willReturn([]);

        $input = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr';
        $result = $subject->hyphenate($input);

        self::assertSame($input, $result);
    }

    /**
     * @test
     */
    public function hyphenateWithDictionaryItems()
    {
        $dictionary = [
            'consetetur' => 'conse&shy;tetur',
            'sadipscing' => 'sad&shy;ipsc&shy;ing'
        ];
        $subject = $this->getMockBuilder(HyphenateService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDictionaryItems'])
            ->getMock();
        $subject->method('getDictionaryItems')->willReturn($dictionary);

        $input = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr';
        $expectedResult = 'Lorem ipsum dolor sit amet, conse&shy;tetur sad&shy;ipsc&shy;ing elitr';
        $result = $subject->hyphenate($input);

        self::assertSame($expectedResult, $result);
    }
}
