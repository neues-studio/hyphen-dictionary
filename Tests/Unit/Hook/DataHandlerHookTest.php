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

use NeuesStudio\HyphenDictionary\Hook\DataHandlerHook;
use Nimut\TestingFramework\TestCase\UnitTestCase;
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
    public function saveEmptyString()
    {
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
    public function saveStringWithoutHyphen()
    {
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
    public function saveStringWithOneHyphen()
    {
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
    public function saveStringWithMultipleHyphen()
    {
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
