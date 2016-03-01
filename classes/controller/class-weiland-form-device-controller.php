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
class Weiland_Form_Device_Controller extends Weiland_Form_Admin_Controller {




	public function listAction() {
		global $wpdb;

		echo $this->view->render( 'backend/device/list.html',
		                          array(
			                          'siteUrl' => get_site_url()
		                          ) );
	}
	public function showAction() {
		echo $this->view->render( 'backend/device/show.html',
		                          array(
			                          'siteUrl' => get_site_url()
		                          ) );
	}
	public function editAction() {
	 $device =  Weiland_Form_Device_Model::findById($_REQUEST['pl_weilandt']['uid']);
		echo $this->view->render( 'backend/device/edit.html',
			array(
				'device' => $device
			) );
	}
	/**
	 *
	 */
	public function addAction() {

		$name = '';
		$success = false;
		if ( array_key_exists( 'pl_weilandt_device', $_REQUEST ) ) {
			$name = $_REQUEST['pl_weilandt_device']['name'];
		}

		if ( $name ) {
			$wpdb->insert( $wpdb->prefix . 'pl_weilandt_form_device',
			               array(
				               'name' => $name
			               ) );
			$wpdb->insert_id;
			$message = 'funktioniert';
			if(function_exists('queue_flash_message'))
			queue_flash_message( $message, $class = 'updated' );
		} else {
			$message = 'funktioniert nicht';
			if(function_exists('queue_flash_message'))
			queue_flash_message( $message, $class = 'error' );
		}

		$this->redirect(
			'dashboard',
			'admin'
		);
	}

}
