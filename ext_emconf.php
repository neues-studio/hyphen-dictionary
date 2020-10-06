<?php

$EM_CONF['hyphen_dictionary'] = [
    'title' => 'Hyphen Dictionary',
    'description' => 'Adds server-side hyphen for defined words.',
    'version' => '0.2.0',
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
