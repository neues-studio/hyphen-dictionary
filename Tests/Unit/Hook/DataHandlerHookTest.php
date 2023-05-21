<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Tests\Unit\Service;

use NeuesStudio\HyphenDictionary\Hook\DataHandlerHook;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * Test class for \NeuesStudio\HyphenDictionary\Hook\DataHandlerHook
 */
class DataHandlerHookTest extends UnitTestCase
{
    /**
     * @test
     */
    public function saveEmptyString(): void
    {
        /** @var MockObject&DataHandler $dataHandler */
        $dataHandler = $this->getMockBuilder(DataHandler::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subject = new DataHandlerHook($this->buildCacheFrontend());
        $fields = [
            'hyphenated_word' => '',
        ];
        $subject->processDatamap_preProcessFieldArray($fields, 'tx_hyphendictionary_item', '1', $dataHandler);

        self::assertSame('', $fields['word']);
        self::assertSame(0, $fields['word_length']);
    }

    /**
     * @test
     */
    public function saveStringWithoutHyphen(): void
    {
        /** @var MockObject&DataHandler $dataHandler */
        $dataHandler = $this->getMockBuilder(DataHandler::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subject = new DataHandlerHook($this->buildCacheFrontend());
        $fields = [
            'hyphenated_word' => 'lorem',
        ];
        $subject->processDatamap_preProcessFieldArray($fields, 'tx_hyphendictionary_item', '1', $dataHandler);

        self::assertSame('lorem', $fields['word']);
        self::assertSame(5, $fields['word_length']);
    }

    /**
     * @test
     */
    public function saveStringWithOneHyphen(): void
    {
        /** @var MockObject&DataHandler $dataHandler */
        $dataHandler = $this->getMockBuilder(DataHandler::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subject = new DataHandlerHook($this->buildCacheFrontend());
        $fields = [
            'hyphenated_word' => 'lo[-]rem',
        ];
        $subject->processDatamap_preProcessFieldArray($fields, 'tx_hyphendictionary_item', '1', $dataHandler);

        self::assertSame('lo&shy;rem', $fields['hyphenated_word']);
        self::assertSame('lorem', $fields['word']);
        self::assertSame(5, $fields['word_length']);
    }

    /**
     * @test
     */
    public function saveStringWithMultipleHyphen(): void
    {
        /** @var MockObject&DataHandler $dataHandler */
        $dataHandler = $this->getMockBuilder(DataHandler::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subject = new DataHandlerHook($this->buildCacheFrontend());
        $fields = [
            'hyphenated_word' => 'sad[-]ipsc[-]ing',
        ];
        $subject->processDatamap_preProcessFieldArray($fields, 'tx_hyphendictionary_item', '1', $dataHandler);

        self::assertSame('sad&shy;ipsc&shy;ing', $fields['hyphenated_word']);
        self::assertSame('sadipscing', $fields['word']);
        self::assertSame(10, $fields['word_length']);
    }

    protected function buildCacheFrontend(): VariableFrontend
    {
        return new VariableFrontend('test', new NullBackend(''));
    }
}
