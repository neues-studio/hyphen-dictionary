<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Hook;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;

class DataHandlerHook
{
    private FrontendInterface $cache;

    public function __construct(FrontendInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param array<string, mixed> $fields
     */
    public function processDatamap_preProcessFieldArray(array &$fields, string $table, string $id, DataHandler $dataHandler): void
    {
        if ($table === 'tx_hyphendictionary_item') {
            if (isset($fields['hyphenated_word']) && is_string($fields['hyphenated_word'])) {
                $fields['word'] = str_replace('[-]', '', $fields['hyphenated_word']);
                $fields['word_length'] = strlen($fields['word']);
                $fields['hyphenated_word'] = str_replace('[-]', '&shy;', $fields['hyphenated_word']);
            }
        }
    }

    public function processDatamap_afterAllOperations(DataHandler $dataHandler): void
    {
        $this->cache->flush();
    }
}
