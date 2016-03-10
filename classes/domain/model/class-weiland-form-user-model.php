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
 * Class Weiland_Form_User_Model
 */
class Weiland_Form_User_Model extends WP_User{

	const tableName = 'pl_weilandt_form_device_user';

	/**
	 * @var integer
	 */
	public $gender;

	/**
	 * @var string
	 */
	public $contact_person;

	/**
	 * @var string
	 */
	public $company;

	/**
	 * @var string
	 */
	public $street_no;

	/**
	 * @var string
	 */
	public $zip;

	/**
	 * @var string
	 */
	public $city;

	/**
	 * @var string
	 */
	public $country;

	/**
	 * @var string
	 */
	public $phone;

	/**
	 * @var string
	 */
	public $fax;

	/**
	 * @var string
	 */
	public $mail;

	/**
	 * @var string
	 */
	public $vat_no;

	/**
	 * @var string
	 */
	public $back_address;

	/**
	 * @var integer
	 */
	public $cost_estimate;

	/**
	 * @var integer
	 */
	public $repeat_repair;

	/**
	 * @var string
	 */
	public $comments;

	/**
	 * @var integer
	 */
	public $agb;

	/**
	 * @var integer
	 */
	public $hidden;

	/**
	 * @var integer
	 */
	public $deleted;

	/**
	 * @return array
	 */
	public static function findAll() {

		global $wpdb;

		$users = array();

		$rawResults = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . self::tableName );
		foreach ( $rawResults as $rawResult ) {
			$users[] = new Weiland_Form_User_Model( $rawResult );
		}

		return $users;
	}

	/**
	 * @param $values
	 */
	public function __construct( $values ) {
		foreach ( $values as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

}
