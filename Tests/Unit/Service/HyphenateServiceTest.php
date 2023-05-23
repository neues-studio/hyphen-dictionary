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
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \NeuesStudio\HyphenDictionary\Service\HyphenateService
 */
class HyphenateServiceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function hyphenateWithNoDictionaryItems(): void
    {
        /** @var MockObject&HyphenateService $subject */
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
    public function hyphenateWithDictionaryItems(): void
    {
        $dictionary = [
            'consetetur' => 'conse&shy;tetur',
            'sadipscing' => 'sad&shy;ipsc&shy;ing'
        ];
        /** @var MockObject&HyphenateService $subject */
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
