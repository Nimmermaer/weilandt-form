<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 27.02.2016  Michael <michael.blunck@phth.de>, PHTH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *  Created by PhpStorm.
 ******************************************************************/

/**
 * Class Weiland_Form_Frontend_Dispatcher
 */
class Weiland_Form_Frontend_Dispatcher
{

    /**
     * @param string|FALSE $defaultControllerName
     * @param string|FALSE $defaultActionName
     */
    public static function dispatch($defaultControllerName = FALSE, $defaultActionName = FALSE)
    {
        if (array_key_exists('pl_weilandt', $_REQUEST)) {
            $class = 'Weiland_Form_Frontend_' . ucfirst($_REQUEST['pl_weilandt']['controller']) . '_Controller';
            $action = $_REQUEST['pl_weilandt']['action'] . 'Action';
            $controller = new $class();
            $controller->$action();
        } elseif ($defaultControllerName && $defaultActionName) {
            $controller = new $defaultControllerName();
            $controller->$defaultActionName();
        } else {
            $controller = new Weiland_Form_Frontend_Controller();
            $controller->indexAction();
        }
    }
}
