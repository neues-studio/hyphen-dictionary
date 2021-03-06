<?php

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

call_user_func(function () {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['hyphen_dictionary'] = \NeuesStudio\HyphenDictionary\Hook\DataHandlerHook::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\NeuesStudio\HyphenDictionary\Form\FormDataProvider\ManipulateHyphenatedWord::class] = [
        'depends' => [
            \TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEditRow::class,
        ],
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1601543996] = [
        'nodeName' => 'setHyphenPlaceholderMarker',
        'priority' => '30',
        'class' => \NeuesStudio\HyphenDictionary\Form\FieldControl\SetHyphenPlaceholderMarker::class,
    ];

    if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hyphen_dictionary'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['hyphen_dictionary'] = [
            'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
            'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
            'options' => [],
            'groups' => ['system']
        ];
    }

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'hyphen-dictionary-item',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:hyphen_dictionary/Resources/Public/Icons/HyphenDictionaryItem.svg'
        ]
    );
    $iconRegistry->registerIcon(
        'add-hyphen-placeholder',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        [
            'source' => 'EXT:hyphen_dictionary/Resources/Public/Icons/AddHyphenPlaceholder.svg'
        ]
    );
});
