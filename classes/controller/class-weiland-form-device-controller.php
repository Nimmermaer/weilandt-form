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
class Weiland_Form_Device_Controller extends Weiland_Form_Admin_Controller
{


    /**
     *  list devices
     */
    public function listAction()
    {
        global $wpdb;

        echo $this->view->render('backend/device/list.html', array(
            'siteUrl' => get_site_url(),
            'forms'   => $GLOBALS['Forms'],
        ));
    }

    /**
     * show device
     */
    public function showAction()
    {
        echo $this->view->render('backend/device/show.html', array(
            'siteUrl' => get_site_url(),
            'forms'   => $GLOBALS['Forms']
        ));
    }

    /**
     * edit device
     */
    public function editAction()
    {

        $device = Weiland_Form_Device_Model::findById($this->request->arguments['device']['id']);
        echo $this->view->render('backend/device/edit.html', array(
            'device'  => $device,
            'forms'   => $GLOBALS['Forms'],
            'siteUrl' => get_site_url(),
        ));
    }

    /**
     * render a new device form
     */
    public function newAction()
    {
        echo $this->view->render('backend/device/new.html', array(
            'forms'   => $GLOBALS['Forms'],
            'siteUrl' => get_site_url(),
        ));
    }

    /**
     * add a device
     */
    public function addAction()
    {
        $message = 'funktioniert nicht';
        $class = 'error';

        if ($this->request->arguments['device']) {
            $devicetoAdd = new Weiland_Form_Device_Model($this->request->arguments['device']);
            if(is_object($devicetoAdd)) {
                $devicetoAdd->persist();
                $message = 'Neues Gerät <strong>' . $devicetoAdd->name . '</strong> erstellt!';
                $class   = 'updated';
            }
        }

        if (function_exists('queue_flash_message')) {
            queue_flash_message($message, $class );
        }
        $this->redirect('dashboard', 'admin');
    }

    /**
     * update an old device
     */
    public function updateAction()
    {
          $message = 'funktioniert nicht';

        if ($this->request->arguments['device']['id']) {
            $deviceToUpdate = Weiland_Form_Device_Model::findById($this->request->arguments['device']['id']);
            if(is_object($deviceToUpdate)) {
                $deviceToUpdate->updateValuesFromRequest($this->request->arguments['device']);
                if ($deviceToUpdate->persist()) {
                    $message = 'funktioniert';
                }
            }
        }

        if (function_exists('queue_flash_message')) {
            queue_flash_message($message, $class = 'error');
        }

        $this->redirect('dashboard', 'admin');
    }

    /**
     * delete device
     */
    public function deleteAction()
    {
        $flash ['message']= 'Gerät nicht gelöscht';
        $flash ['class']= 'error';
        if ($this->request->arguments['device']['id']) {
            $deviceToDelete = Weiland_Form_Device_Model::findById($this->request->arguments['device']['id']);
            if (is_object($deviceToDelete) && $deviceToDelete->delete()) {
                $flash ['message']= 'Device gelöscht';
                $flash ['class']= 'updated';
            }
        }
        if (function_exists('queue_flash_message')) {
            queue_flash_message($flash ['message'],  $flash ['class']);
        }

        $this->redirect('dashboard', 'admin');
    }

}
