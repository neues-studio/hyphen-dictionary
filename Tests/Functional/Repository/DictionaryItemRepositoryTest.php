<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Tests\Functional\Repository;

use NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @covers \NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository
 */
class DictionaryItemRepositoryTest extends FunctionalTestCase
{
    /**
     * @var non-empty-string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/hyphen_dictionary',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_hyphendictionary_item.xml');
    }

    protected function buildServerRequest(int $languageUid): void
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
    public function getAllItemsWithLanguageUidZero(): void
    {
        $this->buildServerRequest(0);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(4, iterator_to_array($subject->findAll()));
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidZeroWidthAtLeastSixCharacters(): void
    {
        $this->buildServerRequest(0);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(2, iterator_to_array($subject->findAll(6)));
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOne(): void
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(2, iterator_to_array($subject->findAll()));
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOneAtLeastSixCharacters(): void
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(0, iterator_to_array($subject->findAll(6)));
    }
}
