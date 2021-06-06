<?php

declare(strict_types=1);

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace NeuesStudio\HyphenDictionary\Form\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;

class SetHyphenPlaceholderMarker extends AbstractNode
{
    public function render(): array
    {
        return [
            'iconIdentifier' => 'add-hyphen-placeholder',
            'title' => $GLOBALS['LANG']->sL('LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:field_control.set_hyphen_placeholder_marker.title'),
            'linkAttributes' => [
                'class' => 'hyphen-placeholder-marker',
                'data-input-name' => $this->data['elementBaseName'],
                'data-placeholder' => $this->data['parameterArray']['fieldConf']['config']['hyphenPlaceholder']['placeholder'] ?? '[-]',
            ],
            'requireJsModules' => ['TYPO3/CMS/HyphenDictionary/Form/FieldControl/SetHyphenPlaceholderMarker'],
        ];
    }
}
