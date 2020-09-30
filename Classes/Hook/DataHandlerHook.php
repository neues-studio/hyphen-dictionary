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
