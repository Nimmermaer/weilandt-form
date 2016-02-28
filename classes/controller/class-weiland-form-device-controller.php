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
class Weiland_Form_Device_Controller extends Weiland_Form_Admin_Controller{


	/**
	 *
	 */
	public function newAction() {
		echo $this->view->render( 'admin-device-new.html',
		                          array(
			                          'siteUrl' => get_site_url()
		                          ) );
	}

	/**
	 *
	 */
	public function addAction() {
		global $wpdb;
		$name = $_REQUEST['pl_weilandt_device']['name'];

		if ( $name ) {
			$wpdb->insert( $wpdb->prefix . 'pl_weilandt_form_device',
			               array(
				              	'name' => $name
			               ) );
			echo $wpdb->insert_id;

			var_dump($wpdb->insert_id);
			add_action( 'admin_notices',
				function () {
					$success = 'Neues Gerät wurde angelegt'; //_e( 'Done!', 'sample-text-domain' );
					print ' <div class="notice notice-success is-dismissible">
			<p>' . $success . '</p>
		</div>';
				} );
		} else {
			add_action( 'admin_notices', function () {

				/*$class   = 'notice notice-error';
				$message = __( 'Irks! An error has occurred.', 'sample-text-domain' );

				printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
				*/
				$success = 'Leider konnte kein neues Gerät angelegt werden'; //_e( 'Done!', 'sample-text-domain' );
				print ' <div class="notice notice-success is-dismissible">
			<p>' . $success . '</p></div>';
			});
		}

		$this->dashboardAction();
	}

}
