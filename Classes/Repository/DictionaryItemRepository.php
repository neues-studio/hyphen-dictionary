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

namespace NeuesStudio\HyphenDictionary\Repository;

use NeuesStudio\HyphenDictionary\Database\Query\Restriction\LanguageRestriction;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DictionaryItemRepository implements SingletonInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table;

    public function __construct(Connection $connection = null, string $table = 'tx_hyphendictionary_item')
    {
        $this->connection = $connection;
        $this->table = $table;

        if ($this->connection === null) {
            $this->connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
        }
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

        $dictItems = $queryBuilder->execute();

        while ($dictItem = $dictItems->fetch()) {
            yield $dictItem['word'] => $dictItem['hyphenated_word'];
        }
    }
}
