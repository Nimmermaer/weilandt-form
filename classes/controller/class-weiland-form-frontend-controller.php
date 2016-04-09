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
 * Class Weiland_Form_Frontend_Controller
 */
class Weiland_Form_Frontend_Controller extends Weiland_Form_Controller
{

    const tableName = 'pl_weilandt_form_device';

    /**
     * @param $attr
     */
    public function dispatchForm($attr)
    {
        if (key($attr) == 'formular')
           $this->showFormAction($attr['formular']);
     }

    /**
     * @param $id
     */
    public function showFormAction($id)
    {
        global $wpdb;
        $countries = $rawResults = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'countries');
        esc_url(admin_url('admin-post.php'));

       if(file_exists(WEILANDT_PATH . '/res/html/templates/frontend/form'.$id.'.html')) {
            echo $this->view->render('frontend/form'.$id.'.html', array(
                'countries' => $countries,
                'devices'   => Weiland_Form_Device_Model::findByAttribute('formId', $id),
            ));
        }else {
            echo $this->view->render('frontend/error.html');
        }
    }

}
