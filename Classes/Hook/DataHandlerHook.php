<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Hook;

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandlerHook implements SingletonInterface
{
    /**
     * @var FrontendInterface
     */
    private $cache;

    public function __construct(FrontendInterface $cache = null)
    {
        $this->cache = $cache;

        if ($this->cache === null) {
            $this->cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('hyphen_dictionary');
        }
    }

    public function processDatamap_preProcessFieldArray(array &$fields, string $table, string $id, DataHandler $dataHandler)
    {
        if ($table === 'tx_hyphendictionary_item') {
            if (isset($fields['hyphenated_word']) && is_string($fields['hyphenated_word'])) {
                $fields['word'] = str_replace('[-]', '', $fields['hyphenated_word']);
                $fields['word_length'] = strlen($fields['word']);
                $fields['hyphenated_word'] = str_replace('[-]', '&shy;', $fields['hyphenated_word']);
            }
        }
    }

    public function processDatamap_afterAllOperations(DataHandler $dataHandler)
    {
        $this->cache->flush();
    }
}
