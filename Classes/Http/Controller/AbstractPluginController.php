<?php

namespace NeoBlack\Laravel\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
 * Class AbstractPluginController
 *
 * @package NeoBlack\Http\Controllers
 */
abstract class AbstractPluginController extends BaseController {

    /**
     * The allowed actions for this plugin
     * @var array
     */
    protected $allowedActions = ['index'];

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var string
     */
    protected $pluginName;

    /**
     * AbstractPluginController constructor.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     */
    public function __construct()
    {
        $this->initSettings();
        $this->initView();
    }

    /**
     *
     * @throws \InvalidArgumentException
     */
    public function dispatch($content, $config) : string
    {
        $request = Request::capture();
        $response = new Response();

        $this->pluginName = $config['pluginName'];

        $action = $request->get('action', 'index');
        if (in_array($action, $this->allowedActions, true)) {
            $this->view->setTemplate($this->getControllerName() . '/' . ucfirst($action) . '.html');
            $action .= 'Action';
            $response = $this->{$action}($request, $response);
        }
        return $response->getContent();
    }

    /**
     *
     */
    protected function initSettings()
    {
        $this->settings = $this->getTypoScriptFrontendController()->tmpl->setup['plugin.']['tx_laravel.'];
    }

    /**
     *
     * @throws \InvalidArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \RuntimeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     */
    protected function initView()
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplateRootPaths($this->settings['view.']['templateRootPaths.']);
        $this->view->setPartialRootPaths($this->settings['view.']['partialRootPaths.']);
        $this->view->setLayoutRootPaths($this->settings['view.']['layoutRootPaths.']);
        $renderingContext = $this->view->getRenderingContext();
        $renderingContext->setControllerName($this->getControllerName());
        $this->view->setRenderingContext($renderingContext);
        $this->view->getRequest()->setControllerExtensionName('Laravel');
        $this->view->getRequest()->setControllerName($this->getControllerName());
        $this->view->getRequest()->setPluginName($this->pluginName);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * @return string
     */
    protected function getControllerName(): string
    {
        $controllerName = GeneralUtility::trimExplode('\\', get_class($this));
        $controllerName = array_pop($controllerName);
        return str_replace('Controller', '', $controllerName);
    }
}
