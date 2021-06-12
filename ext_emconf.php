<?php

/*
 * This file is part of the "hyphen_dictionary" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF['hyphen_dictionary'] = [
    'title' => 'Hyphen Dictionary',
    'description' => 'Adds server-side hyphen for defined words.',
    'version' => '0.2.5',
    'category' => 'module',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'author' => 'Tim Schreiner',
    'author_email' => 'team@neues.studio',
    'author_company' => 'Neues Studio',
];
