<?php

return [
    'ctrl' => [
        'label' => 'word',
        'descriptionColumn' => 'rowDescription',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'editlock' => 'editlock',
        'title' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item',
        'delete' => 'deleted',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'hideAtCopy' => true,
        'prependAtCopy' => '',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'searchFields' => 'word',
        'typeicon_classes' => [
            'default' => 'hyphen-dictionary-item',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_hyphendictionary_item',
                'foreign_table_where' => 'AND tx_hyphendictionary_item.pid=###CURRENT_PID### AND tx_hyphendictionary_item.sys_language_uid IN (-1,0)',
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => true,
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'editlock' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:editlock',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255
            ]
        ],
        'word' => [
            'label' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item.columns.word',
            'description' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item.columns.word.description',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'readOnly' => true,
            ],
        ],
        'hyphenated_word' => [
            'label' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item.columns.hyphenated_word',
            'description' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item.columns.hyphenated_word.description',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'placeholder' => 'LLL:EXT:hyphen_dictionary/Resources/Private/Language/locallang_tca.xlf:tx_hyphendictionary_item.columns.hyphenated_word.placeholder',
                'eval' => 'trim,required',
                'fieldControl' => [
                    'setHyphenPlaceholderMarker' => [
                        'renderType' => 'setHyphenPlaceholderMarker'
                    ],
                ],
                'hyphenPlaceholder' => [
                    'placeholder' => '[-]',
                ],
            ],
        ],
        'word_length' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;paletteCore,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;paletteLanguage,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;paletteHidden,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    rowDescription,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => '
                hyphenated_word,
                --linebreak--,
                word,
            ',
        ],
        'paletteHidden' => [
            'showitem' => '
                hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden
            ',
        ],
        'paletteLanguage' => [
            'showitem' => '
                sys_language_uid;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:sys_language_uid_formlabel,
                l10n_parent,
                l10n_diffsource
            ',
        ],
    ],
];
