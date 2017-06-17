<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    \NeoBlack\Laravel\TYPO3\Utility::registerPlugin([
        'extensionKey' => 'laravel',
        'pluginName' => 'demoPlugin',
        'pluginTitle' => 'Laravel Demo Plugin',
        'pluginClass' => \NeoBlack\Laravel\Http\Controller\DemoController::class,
        'pluginIconPathAndFilename' => 'EXT:laravel/Resource/Public/Icons/DemoPlugin.svg',
    ]);
});
