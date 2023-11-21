<?php
use LMS\Routes\Controller\ManagementController;
return [
    'site_ApiRoutes' => [
        'parent' => 'sites',
        'position' => ['after' => 'site_redirects'],
        'path' => '/module/site/ApiRoutes',
        'labels' => 'LLL:EXT:routes/Resources/Private/Language/locallang_mod.xlf',

        'icon' => 'EXT:routes/ext_icon.svg',
        'extensionName' => 'Routes',
        'controllerActions' => [
            ManagementController::class => [
                'index',
                'show',
            ],
        ],
        'navigationComponentId' => '',
        'inheritNavigationComponentFromMainModule' => false,
    ]
];
