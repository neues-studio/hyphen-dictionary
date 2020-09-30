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

namespace NeuesStudio\HyphenDictionary\Database\Query\Restriction;

use TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\QueryRestrictionInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

/**
 * Query builder restriction to restrict results only for current
 * language or all languages.
 * Only usable for FE.
 */
class LanguageRestriction implements QueryRestrictionInterface
{
    /**
     * Main method to build expressions for given tables
     * Evaluates the ctrl/languageField flag of the table and adds the according restriction if set
     *
     * @param array $queriedTables Array of tables, where array key is table alias and value is a table name
     * @param ExpressionBuilder $expressionBuilder Expression builder instance to add restrictions with
     * @return CompositeExpression The result of query builder expression(s)
     */
    public function buildExpression(array $queriedTables, ExpressionBuilder $expressionBuilder): CompositeExpression
    {
        $constraints = [];
        foreach ($queriedTables as $tableAlias => $tableName) {
            $languageFieldName = $GLOBALS['TCA'][$tableName]['ctrl']['languageField'] ?? null;
            if (!empty($languageFieldName)) {
                try {
                    $language = $this->getLanguage();
                    $constraints[] = $expressionBuilder->in(
                        $tableAlias . '.' . $languageFieldName,
                        [-1, $language->getLanguageId()]
                    );
                } catch (NoSiteLanguageException $e) {
                }
            }
        }

        return $expressionBuilder->andX(...$constraints);
    }

    /**
     * @return SiteLanguage
     * @throws NoSiteLanguageException
     */
    protected function getLanguage(): ?SiteLanguage
    {
        if (empty($GLOBALS['TYPO3_REQUEST'])) {
            throw new NoSiteLanguageException('No TYPO3 request object.', 1600852536);
        }

        $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');

        if (!$language) {
            throw new NoSiteLanguageException('No site language attribute.', 1600852582);
        }

        return $language;
    }
}
