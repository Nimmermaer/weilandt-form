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
class Weiland_Form_Admin_Controller extends Weiland_Form_Controller {

	/**
	 *  dashboardAction
	 */
	public function dashboardAction() {
		WPFlashMessages::show_flash_messages();
		$devices = Weiland_Form_Device_Model::findAll();
		echo $this->view->render( 'admin-dashboard.html',
		                          array(
			                          'name'    => 'Michael',
			                          'devices' => $devices,
			                          'siteUrl' => get_site_url()
		                          ) );

	}
}
