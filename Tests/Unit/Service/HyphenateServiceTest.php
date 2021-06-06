<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
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
