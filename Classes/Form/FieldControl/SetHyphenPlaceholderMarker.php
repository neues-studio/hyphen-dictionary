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
