<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Repository;

use Doctrine\DBAL\Driver\Result;
use NeuesStudio\HyphenDictionary\Database\Query\Restriction\LanguageRestriction;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DictionaryItemRepository implements SingletonInterface
{
    protected Connection $connection;

    protected string $table;

    public function __construct(Connection $connection, string $table = 'tx_hyphendictionary_item')
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function findAll(int $minLength = 0): \Generator
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->add(GeneralUtility::makeInstance(LanguageRestriction::class));

        $queryBuilder
            ->select('word', 'hyphenated_word')
            ->from($this->table);

        if ($minLength > 0) {
            $queryBuilder->where(
                $queryBuilder->expr()->gte('word_length', $queryBuilder->createNamedParameter($minLength))
            );
        }

        /** @var Result $dictItems */
        $dictItems = $queryBuilder->execute();

        while ($dictItem = $dictItems->fetchAssociative()) {
            yield $dictItem['word'] => $dictItem['hyphenated_word'];
        }
    }
}
