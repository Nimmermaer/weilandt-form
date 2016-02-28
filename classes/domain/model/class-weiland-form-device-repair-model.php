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
 * Class Weiland_Form_Device_Repair_Model
 */
class Weiland_Form_Device_Repair_Model {

	const tableName = 'pl_weilandt_form_device_repair';

	/**
	 * @var string
	 */
	public $serial_no;

	/**
	 * @var string
	 */
	public $problem_description;

	/**
	 * @var integer
	 */
	public $pl_weilandt_form_device_id;
	/**
	 * @var integer
	 */
	public $warranty;

	/**
	 * @return array
	 */
	public static function findAll() {

		global $wpdb;

		$repair_devices = array();

		$rawResults = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . self::tableName );
		foreach ( $rawResults as $rawResult ) {
			$repair_devices[] = new Weiland_Form_Device_Repair_Model( $rawResult );
		}

		return $repair_devices;
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
