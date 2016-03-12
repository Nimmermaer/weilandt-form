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
 * Class Weiland_Form_Model
 */
class Weiland_Form_Model {

	/**
	 * @var integer
	 */
	public $id;

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
	 * @param $values
	 */
	public function __construct( $values ) {
		foreach ( $values as $key => $value ) {
			$propertyName = $this->underscoresToCamelCase($key);
			if ( property_exists( $this, $propertyName ) ) {
				$this->$propertyName = $value;
			}
		}

		if(method_exists(get_class($this), 'initializeObject')) {
			$this->initializeObject();
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return (string)$this->id;
	}

	/**
	 * @return array
	 */
	public static function findAll() {

		global $wpdb;

		$classname = get_called_class();

		$objects = array();

		$rawResults = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $classname::tableName );
		foreach ( $rawResults as $rawResult ) {
			$objects[] = new $classname( $rawResult );
		}

		return $objects;
	}

	/**
	 * @param $id
	 *
	 * @return object
	 */
	public static function findById( $id ) {

		global $wpdb;

		$classname = get_called_class();
		$object = FALSE;

		$rawResult = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . $classname::tableName . ' WHERE id = ' . $id );
		if(is_array($rawResult) && count($rawResult) > 0) {
			$object    = new Weiland_Form_Device_Model( $rawResult[0] );
		}

		return $object;
	}

	/**
	 * @return bool
	 */
	public  function update() {
		global $wpdb;
		//unset($valuesToUpdate['crdate']);
		$id = $this->id;
		unset($this->id);
		$wpdb->update(
			$wpdb->prefix . $this::tableName,
			(array)$this,
			array( 'id' => $id )
		);
		return TRUE;
	}

	/**
	 * @return bool
	 */
	public function delete()
	{
		global $wpdb;
			$wpdb->delete($wpdb->prefix . $this::tableName, array(
				'id' => $this->id
			));
		return TRUE;
	}

	/**
	 * @return bool
	 */
	public function add()
	{
		global $wpdb;
		$wpdb->insert($wpdb->prefix . $this::tableName,
			(array)$this
			);
		$wpdb->insert_id;
		return TRUE;
	}

	/**
	 * @return bool
	 */
	public function persist()
	{
		if($this->id) {
			$this->update();
		} else {
			$this->add();
		}
	}

	public function updateValuesFromRequest($values){
		foreach($values as $key => $value){
			if($key != 'id' && property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
		return $this;
	}

	protected function underscoresToCamelCase($string, $capitalizeFirstCharacter = false)
	{

		$str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

		if (!$capitalizeFirstCharacter) {
			$str[0] = strtolower($str[0]);
		}

		return $str;
	}

	public static function findByAttribute($attributeName, $attributeValue) {

		global $wpdb;

		$attributeName = lcfirst($attributeName);
		$attributeName = strtolower(preg_replace('/\B([A-Z])/', '_$1', $attributeName));

		$classname = get_called_class();

		$objects = array();

		$rawResults = $wpdb->get_results(
			'SELECT * FROM ' . $wpdb->prefix . $classname::tableName .'
			 WHERE '.$attributeName.' = '. $attributeValue
		);
		foreach ( $rawResults as $rawResult ) {
			$objects[] = new $classname( $rawResult );
		}

		return $objects;

	}

	public static function __callStatic($name, $arguments) {

		if(strrpos($name, 'findBy', -strlen($name)) !== false) {
			$attributeName = explode('findBy', $name);
			$attributeName = $attributeName[1];

			self::findByAttribute($attributeName, $arguments[0]);
		}

	}
}
