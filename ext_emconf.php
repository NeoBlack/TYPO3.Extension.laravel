<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Laravel Framework for TYPO3',
    'description' => 'Laravel for TYPO3',
    'category' => 'fe',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Frank Nägler',
    'author_email' => 'mail@naegler.net',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
