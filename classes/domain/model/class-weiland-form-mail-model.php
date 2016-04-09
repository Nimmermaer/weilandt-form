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
 * Class Weiland_Form_Mail_Model
 */
class Weiland_Form_Mail_Model extends Weiland_Form_Model {

	const tableName = 'pl_weilandt_form_mail';

	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $backAdress = '';

	/**
	 * @var string
	 */
	public $repeatRepair ='';

	/**
	 * @var string
	 */
	public $comments ='';

	/**
	 * @var string
	 */
	public $agb = '';

	/**
	 * @var integer
	 */
	public $hidden = 0;

	/**
	 * @var integer
	 */
	public $deleted = 0;

	/**
	 * @var integer
	 */
	public $userId = 0;

	/**
	 * @var array
	 */
	protected $repairDevices = '';

	/**
	 * 
	 */
	protected function initializeObject() {
		 $values  = $this->repairDevices;
		if ( $values ) {
			foreach ( $values as $repairDevice ) {
			//var_dump($repairDevice);
				$repairDevice       = new Weiland_Form_Device_Repair_Model( $repairDevice );
				$repairDevice->persist( );
			}
		}
	}

}
