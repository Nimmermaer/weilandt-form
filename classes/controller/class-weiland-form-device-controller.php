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



	/**
	 *  list devices
	 */
	public function listAction() {
		global $wpdb;

		echo $this->view->render( 'backend/device/list.html', array(
			'siteUrl' => get_site_url(),
			'forms' => $GLOBALS['Forms'] ,
		) );
	}

	/**
	 * show device
	 */
	public function showAction() {
		echo $this->view->render( 'backend/device/show.html', array(
			'siteUrl' => get_site_url(),
			'forms' => $GLOBALS['Forms']
		) );
	}

	/**
	 * edit device
	 */
	public function editAction() {
		$device = Weiland_Form_Device_Model::findById( $_REQUEST['pl_weilandt']['uid'] );
		echo $this->view->render( 'backend/device/edit.html', array(
			'device' => $device,
			'forms' => $GLOBALS['Forms']
		) );
	}

	/**
	 * render a new device form
	 */
	public function newAction() {
		echo $this->view->render( 'backend/device/new.html', array(
			'forms' => $GLOBALS['Forms'],
			'siteUrl' => get_site_url(),
		) );
	}

	/**
	 * add a device
	 */
	public function addAction() {
		global $wpdb;
		$name                           = '';
		$pl_weilandt_form_type_id = '';
		$success                        = false;
		if ( array_key_exists( 'pl_weilandt_device', $_REQUEST ) ) {
			$name                           = $_REQUEST['pl_weilandt_device']['name'];
			$pl_weilandt_form_type_id = $_REQUEST['pl_weilandt_device']['pl_weilandt_form_type_id'];
		}

		if ( $name ) {
			$wpdb->insert( $wpdb->prefix . 'pl_weilandt_form_device', array(
				'name'                           => $name,
				'pl_weilandt_form_type_id' => $pl_weilandt_form_type_id
			) );
			$wpdb->insert_id;
			$message = 'funktioniert';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'updated' );
			}
		} else {
			$message = 'funktioniert nicht';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'error' );
			}
		}

		$this->redirect( 'dashboard', 'admin' );
	}

	/**
	 * update an old device
	 */
	public function updateAction() {
		global $wpdb;
		$name                           = '';
		$pl_weilandt_form_type_id = '';
		$success                        = false;

		if ( array_key_exists( 'device', $_REQUEST ) ) {
			$name                           = $_REQUEST['device']['name'];
			$pl_weilandt_form_type_id =      $_REQUEST['device']['pl_weilandt_form_type_id'];
			$id                             = $_REQUEST['device']['id'];
		}
		if ( $name ) {
			$wpdb->update( $wpdb->prefix . 'pl_weilandt_form_device', array(
				'name'                           => $name,
				'pl_weilandt_form_type_id' => $pl_weilandt_form_type_id
			), array(
				'id' => $id
			) );
			$wpdb->insert_id;
			$message = 'funktioniert';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'updated' );
			}
		} else {
			$message = 'funktioniert nicht';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'error' );
			}
		}

		$this->redirect( 'dashboard', 'admin' );
	}

	/**
	 * delete device
	 */
	public function deleteAction() {
		global $wpdb;

		if ( array_key_exists( 'pl_weilandt_device', $_REQUEST ) ) {
			$id = $_REQUEST['pl_weilandt_device']['uid'];
		}

		if ( $id ) {
			$wpdb->delete( $wpdb->prefix . 'pl_weilandt_form_device', array(
				'id' => $id
			) );

			$message = 'funktioniert';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'updated' );
			}
		} else {
			$message = 'funktioniert nicht';
			if ( function_exists( 'queue_flash_message' ) ) {
				queue_flash_message( $message, $class = 'error' );
			}
		}

		$this->redirect( 'dashboard', 'admin' );
	}

}
