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

namespace NeuesStudio\HyphenDictionary\Service;

use NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class HyphenateService implements SingletonInterface
{
    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * There is a runtime cache to avoid serialize/unserialize the dictionary items using the
     * DatabaseBackend cache.
     *
     * @var FrontendInterface
     */
    private $runtimeCache;

    /**
     * @var DictionaryItemRepository
     */
    private $repository;

    public function __construct(FrontendInterface $cache = null, FrontendInterface $runtimeCache = null, DictionaryItemRepository $repository = null)
    {
        $this->cache = $cache;
        $this->repository = $repository;

        if ($this->cache === null) {
            $this->cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('hyphen_dictionary');
        }
        if ($this->runtimeCache === null) {
            $this->runtimeCache = GeneralUtility::makeInstance(CacheManager::class)->getCache('hyphen_dictionary_runtime');
        }
        if ($this->repository === null) {
            $this->repository = GeneralUtility::makeInstance(DictionaryItemRepository::class);
        }
    }

    public function hyphenate(string $content, int $minLength = 0): string
    {
        $items = $this->getDictionaryItems($minLength);

        if (empty($items)) {
            return $content;
        }

        return str_replace(array_keys($items), $items, $content);
    }

    protected function getDictionaryItems(int $minLength): array
    {
        $cacheIdentifier = 'min_word_length_' . $minLength;

        try {
            return $this->getDictionaryItemsFromCache($cacheIdentifier);
        } catch (NoCacheEntryException $e) {
            $items = iterator_to_array($this->repository->findAll($minLength));

            $this->runtimeCache->set($cacheIdentifier, $items);
            $this->cache->set($cacheIdentifier, $items, [], 0);

            return $items;
        }
    }

    /**
     * @param string $cacheIdentifier
     * @return mixed
     * @throws NoCacheEntryException
     */
    private function getDictionaryItemsFromCache(string $cacheIdentifier): array
    {
        if ($this->runtimeCache->has($cacheIdentifier)) {
            return $this->runtimeCache->get($cacheIdentifier);
        }
        if ($this->cache->has($cacheIdentifier)) {
            return $this->cache->get($cacheIdentifier);
        }

        throw new NoCacheEntryException('No cache entry found for identifier ' . $cacheIdentifier, 1601494567);
    }
}
