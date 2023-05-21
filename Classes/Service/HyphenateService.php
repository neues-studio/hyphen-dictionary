<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Service;

use NeuesStudio\HyphenDictionary\Repository\DictionaryItemRepository;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class HyphenateService
{
    private FrontendInterface $cache;

    /**
     * Use core runtime cache to avoid serialize/unserialize the dictionary items for every hyphenate() method call
     * using the Typo3DatabaseBackend cache.
     * As the items array can grow large, this speed up the processing.
     */
    private FrontendInterface $runtimeCache;

    private DictionaryItemRepository $repository;

    public function __construct(FrontendInterface $cache, FrontendInterface $runtimeCache, DictionaryItemRepository $repository)
    {
        $this->cache = $cache;
        $this->runtimeCache = $runtimeCache;
        $this->repository = $repository;
    }

    public function hyphenate(string $content, int $minLength = 0): string
    {
        $items = $this->getDictionaryItems($minLength);

        if (empty($items)) {
            return $content;
        }

        return str_replace(array_keys($items), $items, $content);
    }

    /**
     * @return array<int, array<string, string>>
     */
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
     * @return array<int, array<string, string>>
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
