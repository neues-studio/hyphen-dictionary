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

        self::assertCount(4, $subject->findAll());
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidZeroWidthAtLeastSixCharacters()
    {
        $this->buildServerRequest(0);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(2, $subject->findAll(6));
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOne()
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(2, $subject->findAll());
    }

    /**
     * @test
     */
    public function getAllItemsWithLanguageUidOneAtLeastSixCharacters()
    {
        $this->buildServerRequest(1);
        $subject = GeneralUtility::makeInstance(DictionaryItemRepository::class);

        self::assertCount(0, $subject->findAll(6));
    }
}
