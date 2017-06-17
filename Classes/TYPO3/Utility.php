<?php
namespace NeoBlack\Laravel\TYPO3;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class Utility
 *
 * @package NeoBlack\TYPO3
 */
class Utility
{
    const PLUGIN_TYPE_PLUGIN = 'list_type';
    const PLUGIN_TYPE_CONTENT_ELEMENT = 'CType';

    /**
     * @param array $pluginData see the following list for expected keys
     * - $pluginData['extensionKey']: required, the extension key
     * - $pluginData['pluginName']: required, the name for the plugin
     * - $pluginData['pluginTitle']: required, the title for the backend
     * - $pluginData['pluginClass']: required, the full qualified class name, must be an instance of NeoBlack\Http\Controller\AbstractPluginController
     * - $pluginData['pluginIconPathAndFilename']: required, the icon path an filename
     * - $pluginData['pluginType']: optional, default: static::PLUGIN_TYPE_PLUGIN
     *
     * @throws \InvalidArgumentException
     */
    public static function registerPlugin(array $pluginData)
    {
        $extensionKey = $pluginData['extensionKey'];
        $pluginName = $pluginData['pluginName'];
        $pluginTitle = $pluginData['pluginTitle'];
        $pluginClass = $pluginData['pluginClass'];
        $pluginIconPathAndFilename = $pluginData['pluginIconPathAndFilename'];
        $pluginType = $pluginData['pluginType'] ?? static::PLUGIN_TYPE_PLUGIN;
        $pluginSignature = strtolower($extensionKey . '_' . $pluginName);

        switch ($pluginType) {
            case self::PLUGIN_TYPE_PLUGIN:
                $pluginContent = [];
                $pluginContent[] = 'tt_content.list.20.' . $pluginSignature . ' = USER';
                $pluginContent[] = 'tt_content.list.20.' . $pluginSignature . ' {';
                $pluginContent[] = '    userFunc = ' . $pluginClass . '->dispatch';
                $pluginContent[] = '}';
                $pluginContent = implode(LF, $pluginContent);
                break;
            case self::PLUGIN_TYPE_CONTENT_ELEMENT:
                $pluginContent = [];
                $pluginContent[] = 'tt_content.' . $pluginSignature . ' =< lib.contentElement';
                $pluginContent[] = 'tt_content.' . $pluginSignature . ' {';
                $pluginContent[] = '    templateName = Generic';
                $pluginContent[] = '    20 = USER';
                $pluginContent[] = '    20 {';
                $pluginContent[] = '        userFunc = ' . $pluginClass . '->dispatch';
                $pluginContent[] = '}';
                $pluginContent = implode(LF, $pluginContent);
                break;
            default:
                throw new \InvalidArgumentException('The pluginType "' . $pluginType . '" is not suported', 1497726429);
        }
        $setup = [];
        $setup[] = '# Setting ' . $pluginSignature . ' plugin TypoScript';
        $setup[] = $pluginContent;
        ExtensionManagementUtility::addTypoScript($pluginSignature, 'setup', implode(LF, $setup), 'defaultContentRendering');
        ExtensionManagementUtility::addPlugin(
            [$pluginTitle, $pluginSignature, $pluginIconPathAndFilename],
            $pluginType,
            $extensionKey
        );
    }
}
