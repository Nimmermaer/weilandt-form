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

global $weilandt_db_version;
$weilandt_db_version = 1.0;

/**
 * Class Weiland_Form_Plugin_Manager
 */
class Weiland_Form_Plugin_Manager {

	/**
	 *
	 */
	public function activate() {
		$this->weilandt_form_db();
		$this->weilandt_form_update_db_check();
	}
	public function activateFrontend($attr) {
		$frontend = new Weiland_Form_Frontend_Controller();
		$frontend->dispatchForm($attr);

	}

	/**
	 * @param $className
	 */
	public function autoload( $className ) {
		if ( stristr( $className, 'controller' ) !== FALSE ) {
			$className = mb_strtolower( $className );
			$className = str_replace( '_', '-', $className );
			if(file_exists( WEILANDT_PATH . "/classes/controller/class-" . $className . ".php"))
			require_once( WEILANDT_PATH . "/classes/controller/class-" . $className . ".php" );
		}
		if ( stristr( $className, 'model' ) !== FALSE ) {
			$className = mb_strtolower( $className );
			$className = str_replace( '_', '-', $className );
			if(file_exists( WEILANDT_PATH . "/classes/domain/model/class-" . $className . ".php"))
			require_once( WEILANDT_PATH . "/classes/domain/model/class-" . $className . ".php" );
		}
		if ( stristr( $className, 'weiland' ) !== FALSE ) {
			$className = mb_strtolower( $className );
			$className = str_replace( '_', '-', $className );
			if(file_exists( WEILANDT_PATH . "/classes/class-" . $className . ".php"))
			require_once( WEILANDT_PATH . "/classes/class-" . $className . ".php" );
		}
	}

	/**
	 *
	 */
	public function run() {

		spl_autoload_register( array( &$this, 'autoload' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'integrate_admin_styles' ) );
		add_action( 'admin_menu',
		            array( &$this, 'build_menu' ) );
	}

	/**
	 *
	 */
	public function build_menu() {
		add_options_page( 'weilandt Form Options',
		                  'weilandt Form',
		                  'manage_options',
		                  'weilandt-form-menu',
		                  'weilandt_form_options' );

		add_menu_page( 'Weiland Form Items', // $page_title
		               'Weilandt Form', // menu_title
		               'manage_options', // capability
		               'Weilandt', // slug
		               array(
			               'Weiland_Form_Admin_Dispatcher',
			               'dispatch'
		               ), // function
		               'dashicons-forms', // icon_url
		               1456173925 //position
		);
	}

	/**
	 * database install
	 */
	function  weilandt_form_db() {
		global $wpdb;
		global $weilandt_db_version;
		$pl_weilandt_form_type = $wpdb->prefix . "pl_weilandt_form_type";
		$charset_collate       = $wpdb->get_charset_collate();

		$sql1 = 'CREATE TABLE IF NOT EXISTS ' . $pl_weilandt_form_type . ' (
  				 id INT NOT NULL AUTO_INCREMENT,
  				title VARCHAR(45) NULL,
  				PRIMARY KEY (id)
				)' . $charset_collate . ';';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql1 );


		$pl_weilandt_form_device = $wpdb->prefix . "pl_weilandt_form_device";
		$charset_collate         = $wpdb->get_charset_collate();

		$sql2 = 'CREATE TABLE  IF NOT EXISTS  ' . $pl_weilandt_form_device . '(
  				 id INT NOT NULL AUTO_INCREMENT,
                name TEXT NULL,
                pl_weilandt_form_type_id INT NOT NULL,
                PRIMARY KEY (id)
  					)' . $charset_collate . ';';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql2 );

		$pl_weilandt_form_device_repair = $wpdb->prefix . "pl_weilandt_form_device_repair";
		$charset_collate                = $wpdb->get_charset_collate();

		$sql3 = 'CREATE TABLE IF NOT EXISTS ' . $pl_weilandt_form_device_repair . '  (
  			 id INT NOT NULL AUTO_INCREMENT,
            serial_no VARCHAR(45) NULL,
            problem_description VARCHAR(45) NULL,
            pl_weilandt_form_device_id INT NOT NULL,
            warranty INT NULL,
            PRIMARY KEY (id)
			)' . $charset_collate . ';';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql3 );


		$pl_weilandt_form_device_user = $wpdb->prefix . "pl_weilandt_form_device_user";
		$charset_collate              = $wpdb->get_charset_collate();

		$sql4 = 'CREATE TABLE IF NOT EXISTS  ' . $pl_weilandt_form_device_user . ' (
  			  id INT NOT NULL AUTO_INCREMENT,
			  gender VARCHAR(45) NULL,
			  contact_person VARCHAR(45) NULL,
			  company VARCHAR(45) NULL,
			  street_no VARCHAR(45) NULL,
			  zip VARCHAR(45) NULL,
			  city VARCHAR(45) NULL,
			  country VARCHAR(45) NULL,
			  phone VARCHAR(45) NULL,
			  fax VARCHAR(45) NULL,
			  mail VARCHAR(45) NULL,
			  vat_no VARCHAR(45) NULL,
			  back_address TEXT NULL,
			  cost_estimate INT NULL,
			  repeat_repair INT NULL,
			  comments TEXT NULL,
			  agb VARCHAR(45) NULL,
			  hidden INT NULL,
			  deleted INT NULL,
			  PRIMARY KEY (id)
		)' . $charset_collate . ';';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql4 );
		$table_name      = $wpdb->prefix . "pl_weilandt_form_user_device_repair_mm";
		$charset_collate = $wpdb->get_charset_collate();

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . '  (
  		pl_weilandt_form_device_user_id INT NOT NULL,
        pl_weilandt_form_device_repair_id INT NOT NULL,
        PRIMARY KEY (pl_weilandt_form_device_user_id, pl_weilandt_form_device_repair_id)

		)' . $charset_collate . ';';
		add_option( 'weilandt_db_version', $weilandt_db_version );
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 *
	 */
	function weilandt_form_update_db_check() {
		global $weilandt_db_version;
		if ( get_site_option( 'jal_db_version' ) != $weilandt_db_version ) {
			$this->weilandt_form_db();
		}
	}


	/**
	 *
	 */
	function weilandt_form_data() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'pl_weilandt_form_device_user';
		$sql        = 'INSERT INTO' . $table_name .
		              '( id ,  gender ,  contact_person ,  company ,  street_no ,  zip ,  city ,  country ,  phone ,  fax ,  mail ,  vat_no ,  back_address ,  cost_estimate ,  repeat_repair ,  comments ,  agb ,  hidden ,  deleted ) VALUES (1, 1, "Max Mustermann",  "MusterFirma ",  "34 ",  "12345 ",  "Musterstadt ",  "AE ",  "012345 45678 ",  "012345 45678 ",  "info@mustermail.muster ",  "12 ",  "Valide Rückadresse ",  "2 ",  "1 ",  "Eine eigene Meinung ",  "1 ",  "1 ", NULL)';
		dbDelta( $sql );
	}

	/**
	 *
	 */
	function integrate_admin_styles() {
		$src['morris']    = "/wp-content/plugins/weilandt-form/res/lib/admin-theme/css/plugins/morris.css";
		$src['admin']    = "/wp-content/plugins/weilandt-form/res/lib/admin-theme/css/sb-admin.css";
		$src['bootstrap']    = "/wp-content/plugins/weilandt-form/res/lib/bootstrap/css/bootstrap.min.css";
		$src['fonts']    = "/wp-content/plugins/weilandt-form/res/lib/admin-theme/font-awesome/css/font-awesome.css";
		$src['styles']    = "/wp-content/plugins/weilandt-form/res/css/admin/styles.css";
		$handle = "weilandt_form_admin";
		foreach($src as $key => $source){
			wp_enqueue_style( $handle.'-'.$key,$source, array(), FALSE, 'all' );
		}
		$js['bootstrap']    = "/wp-content/plugins/weilandt-form/res/lib/bootstrap/js/bootstrap.min.js";
		$js['clipboard']    = "/wp-content/plugins/weilandt-form/res/js/admin/clipboard.min.js";
		$js['styles']    = "/wp-content/plugins/weilandt-form/res/js/admin/scripts.js";
		$handle = "weilandt_form_admin_js";
		foreach($js as $key => $jssource){
			wp_enqueue_script(  $handle.'-'.$key,$jssource, array(), FALSE,true );
		}
	}

}