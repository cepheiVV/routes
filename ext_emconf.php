<?php

$EM_CONF['routes'] = [
    'title' => 'Extbase Yaml Routes',
    'description' => 'Provides an ability to bind a route slug to the certain Extbase Action endpoint.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.99',
            'typo3' => '12.2.0-12.6.99'
        ]
    ]
];
