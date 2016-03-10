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
 * Class Weiland_Form_Device_Model
 */
class Weiland_Form_Device_Model {

	const tableName = 'pl_weilandt_form_device';

	/**
	 * @var int
	 */
	public $id = 0;

	/**
	 * @var string
	 */
	public $name = '';
	/**
	 * @var int
	 */
	public $pl_weilandt_form_type_id = 0;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function getPlWeilandtFormDeviceRepair() {
		return $this->pl_weilandt_form_type_id;
	}

	/**
	 * @param int $pl_weilandt_form_type_id
	 */
	public function setPlWeilandtFormDeviceRepair( $pl_weilandt_form_type_id ) {
		$this->pl_weilandt_form_type_id = $pl_weilandt_form_type_id;
	}


	/**
	 * @return array
	 */
	public static function findAll() {

		global $wpdb;

		$devices = array();

		$rawResults = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . self::tableName );
		foreach ( $rawResults as $rawResult ) {
			$devices[] = new Weiland_Form_Device_Model( $rawResult );
		}

		return $devices;
	}

	/**
	 * @param $id
	 *
	 * @return Weiland_Form_Device_Model
	 */
	public static function findById( $id ) {

		global $wpdb;

		$devices   = array();
		$rawResult = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . self::tableName . ' WHERE id=' . $id );
		$device    = new Weiland_Form_Device_Model( $rawResult[0] );

		return $device;
	}

	/**
	 * @param $id
	 * @param $name
	 * @param $pl_weilandt_form_type_id
	 */
	public static function update( $id, $name, $pl_weilandt_form_type_id ) {
		global $wpdb;
		$wpdb->update(
			$wpdb->prefix . self::tableName,
			array(
				'name'                           => $name,
				'pl_weilandt_form_type_id' => $pl_weilandt_form_type_id
			),
			array( 'id' => $id )
		);
	}

	/**
	 * @param $values
	 */
	public function __construct( $values ) {
		if ( count( $values ) > 1 ) {
			foreach ( $values as $key => $value ) {
				if ( property_exists( $this, $key ) ) {
					$this->$key = $value;
				}
			}
		} else {
			$this->id   = $values->id;
			$this->name = $values->name;
			if ( property_exists( $values, 'pl_weilandt_form_type_id' ) ) {
				$this->pl_weilandt_form_type_id = $values->pl_weilandt_form_type_id;
			}

		}
	}
}
