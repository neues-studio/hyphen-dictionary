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

use NeuesStudio\HyphenDictionary\Form\FormDataProvider\ManipulateHyphenatedWord;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test class for \NeuesStudio\HyphenDictionary\Form\FormDataProvider\ManipulateHyphenatedWord
 */
class ManipulateHyphenatedWordTest extends UnitTestCase
{
    /**
     * @test
     */
    public function emptyString()
    {
        $subject = new ManipulateHyphenatedWord();
        $input = [
            'command' => 'edit',
            'tableName' => 'tx_hyphendictionary_item',
            'databaseRow' => [
                'hyphenated_word' => '',
            ],
        ];
        $result = $subject->addData($input);

        self::assertSame($input, $result);
    }

    /**
     * @test
     */
    public function stringWithoutHyphenPlaceholders()
    {
        $subject = new ManipulateHyphenatedWord();
        $input = [
            'command' => 'edit',
            'tableName' => 'tx_hyphendictionary_item',
            'databaseRow' => [
                'hyphenated_word' => 'lorem',
            ],
        ];
        $result = $subject->addData($input);

        self::assertSame('lorem', $result['databaseRow']['hyphenated_word']);
    }
}
