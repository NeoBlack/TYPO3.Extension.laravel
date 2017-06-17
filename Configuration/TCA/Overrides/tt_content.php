<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'Laravel Demo Plugin',
        'laravel_demoplugin',
        'EXT:laravel/Resources/Public/Icons/DemoPlugin.svg',
    ], 'list_type', 'laravel'
);
