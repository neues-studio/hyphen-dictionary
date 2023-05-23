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
    'version' => '1.0.0',
    'category' => 'module',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Tim Schreiner',
    'author_email' => 'dev@tim-schreiner.de',
    'author_company' => '',
];
