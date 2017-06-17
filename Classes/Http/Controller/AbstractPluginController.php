<?php

namespace NeoBlack\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

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
     *
     * @throws \InvalidArgumentException
     */
    public function dispatch() : string
    {
        $request = Request::capture();
        $response = new Response();

        $action = $request->get('action', 'index');
        if (in_array($action, $this->allowedActions, true)) {
            $action .= 'Action';
            $response = $this->{$action}($request, $response);
        }
        return $response->getContent();
    }
}
