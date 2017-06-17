<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    \NeoBlack\Laravel\TYPO3\Utility::registerPlugin([
        'extensionKey' => 'laravel',
        'pluginName' => 'demoPlugin',
        'pluginClass' => \NeoBlack\Laravel\Http\Controller\DemoController::class,
    ]);
    \NeoBlack\Laravel\TYPO3\Utility::registerPlugin([
        'extensionKey' => 'laravel',
        'pluginName' => 'demoPluginContent',
        'pluginClass' => \NeoBlack\Laravel\Http\Controller\DemoController::class,
        'pluginType' => \NeoBlack\Laravel\TYPO3\Utility::PLUGIN_TYPE_CONTENT_ELEMENT
    ]);
});
