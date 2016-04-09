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
class Weiland_Form_User_Model extends Weiland_Form_Model {

	const tableName = 'pl_weilandt_form_user';

	/**
	 * @var string
	 */
	public $gender = '';

	/**
	 * @var string
	 */
	public $contactPerson = '';

	/**
	 * @var string
	 */
	public $companyName = '';

	/**
	 * @var string
	 */
	public $companyStreet = '';

	/**
	 * @var string
	 */
	public $companyLocation = '';
	/**
	 * @var string
	 */
	public $companyCountry = '';
	/**
	 * @var string
	 */
	public $fullName = '';

	/**
	 * @var string
	 */
	public $street = '';

	/**
	 * @var string
	 */
	public $location = '';

	/**
	 * @var string
	 */
	public $country = '';

	/**
	 * @var string
	 */
	public $forms = '';

	/**
	 * @var string
	 */
	public $fax = '';

	/**
	 * @var string
	 */
	public $password = '';

	/**
	 * @var string
	 */
	public $streetNo = '';

	/**
	 * @var string
	 */
	public $zip = '';

	/**
	 * @var string
	 */
	public $city = '';

	/**
	 * @var string
	 */
	public $phone  ='';


	/**
	 * @var string
	 */
	public $email ='';

	/**
	 * @var string
	 */
	public $vatNo = '';

	/**
	 * @var integer
	 */
	public $hidden = 0;

	/**
	 * @var integer
	 */
	public $deleted = 0;

	/**
	 * @var array
	 */
	protected $mails = '';

	protected function initializeObject() {
		$values = '';
		$values  = $this->mails;
		$this->mails = array();
	if ( $values ) {
			foreach ( $values as $mail ) {
				$mail      = new Weiland_Form_Mail_Model($mail);
				$mail->userId = $this->getId();
				$mail->persist();
			}
		}
	}


}
