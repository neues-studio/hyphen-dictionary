<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
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
    public function emptyString(): void
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
    public function stringWithoutHyphenPlaceholders(): void
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
