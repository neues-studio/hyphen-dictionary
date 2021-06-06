<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

class ManipulateHyphenatedWord implements FormDataProviderInterface
{
    public function addData(array $result)
    {
        if ($result['command'] === 'edit'
            && $result['tableName'] === 'tx_hyphendictionary_item'
            && !empty($result['databaseRow']['hyphenated_word'])) {
            $result['databaseRow']['hyphenated_word'] = str_replace('&shy;', '[-]', $result['databaseRow']['hyphenated_word']);
        }

        return $result;
    }
}
