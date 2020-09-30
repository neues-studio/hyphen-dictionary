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

namespace NeuesStudio\HyphenDictionary\Tests\Functional\Repository;

use NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Test class for \NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository
 */
class DictionaryItemRepositoryTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/hyphen_dictionary',
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_hyphendictionary_item.xml');
    }

    protected function buildServerRequest(int $languageUid)
    {
        $serverRequest = new ServerRequest(new Uri('/'), 'get');
        $GLOBALS['TYPO3_REQUEST'] = $serverRequest->withAttribute(
            'language',
            new SiteLanguage($languageUid, 'en', $serverRequest->getUri(), [])
        );
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidZero()
    {
        $this->buildServerRequest(0);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        $this->assertCount(4, $subject->findAll());
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidZeroWidthAtLeastSixCharacters()
    {
        $this->buildServerRequest(0);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        $this->assertCount(2, $subject->findAll(6));
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOne()
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        $this->assertCount(2, $subject->findAll());
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOneAtLeastSixCharacters()
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        $this->assertCount(0, $subject->findAll(6));
    }
}
