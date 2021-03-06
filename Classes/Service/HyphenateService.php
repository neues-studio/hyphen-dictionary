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
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
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
     * Use core runtime cache to avoid serialize/unserialize the dictionary items for every hyphenate() method call
     * using the Typo3DatabaseBackend cache.
     * As the items array can grow large, this speed up the processing.
     *
     * @var FrontendInterface
     */
    private $runtimeCache;

    /**
     * @var DictionaryItemRepository
     */
    private $repository;

    /**
     * HyphenateService constructor.
     * @param FrontendInterface|null $cache
     * @param FrontendInterface|null $runtimeCache
     * @param DictionaryItemRepository|null $repository
     * @throws NoSuchCacheException
     */
    public function __construct(FrontendInterface $cache = null, FrontendInterface $runtimeCache = null, DictionaryItemRepository $repository = null)
    {
        $this->cache = $cache;
        $this->runtimeCache = $runtimeCache;
        $this->repository = $repository;

        if ($this->cache === null) {
            $this->cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('hyphen_dictionary');
        }
        if ($this->runtimeCache === null) {
            // This should only be called in TYPO3 v9. TYPO3 v9 uses "cache_runtime" as identifier.
            // TYPO3 v10 uses only "runtime" that in TYPO3 v10, the runtime cache should be injected by DI.
            $this->runtimeCache = GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_runtime');
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
