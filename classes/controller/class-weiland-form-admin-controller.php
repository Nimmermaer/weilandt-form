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
 * Class Weiland_Form_Admin_Controller
 */
class Weiland_Form_Admin_Controller extends Weiland_Form_Controller
{

    /**
     *  dashboardAction
     */
    public function dashboardAction()
    {
        if (class_exists('WPFlashMessages')) {
            WPFlashMessages::show_flash_messages();
        }

        $devices = Weiland_Form_Device_Model::findAll();
        $mails = Weiland_Form_User_Model::findAll();
        $forms = $GLOBALS['Forms'];
        foreach ($forms as $key => $value) {
            $forms[$key]['devices'] = Weiland_Form_Device_Model::findByFormId($value['id']);
        }
        echo $this->view->render('backend/admin-dashboard',
            array(
                'devices' => $devices,
                'siteUrl' => get_site_url(),
                'forms' => $GLOBALS['Forms'],
                'mails' => $mails,
            ));

    }

    public function redirect($actionName, $controllerName)
    {
        $redirectUrl = get_site_url() . '/wp-admin/admin.php?page=Weilandt&pl_weilandt[controller]=' . $controllerName . '&pl_weilandt[action]=' . $actionName;

        if (!headers_sent()) {
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $redirectUrl . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $redirectUrl . '" />';
            echo '</noscript>';
            exit;
        }
    }
}
