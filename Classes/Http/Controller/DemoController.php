<?php

namespace NeoBlack\Laravel\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
class DemoController extends AbstractPluginController
{
    /**
     * DemoController constructor.
     */
    public function __construct()
    {
        $this->allowedActions[] = 'demo';
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    protected function indexAction(Request $request, Response $response): Response
    {
        $response->setContent('indexAction');
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    protected function demoAction(Request $request, Response $response): Response
    {
        $response->setContent('demoAction');
        return $response;
    }
}
