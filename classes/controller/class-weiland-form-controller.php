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
 * Class Weiland_Form_Controller
 */
class Weiland_Form_Controller {

	protected $view = null;

	protected $request = null;

	public function __construct()
	{
		$this->showFlashMessages();

		$this->buildRequestObject();

		$this->loadView();
	}

	protected function loadView() {
		require_once WEILANDT_PATH . 'vendor/Twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();
		$loader     = new Twig_Loader_Filesystem( WEILANDT_PATH . '/res/html/templates' );
		$this->view = new Twig_Environment( $loader, array(
			'debug' => true,
			'cache' => WEILANDT_PATH . '/res/html/twig_compilation_cache',
		) );
		$this->view->addExtension( new Twig_Extension_Debug() );
	}

	public function showFlashMessages() {
		if ( class_exists( 'WPFlashMessages' ) ) {
			WPFlashMessages::show_flash_messages();
		}
	}

	protected function buildRequestObject() {
		$request = new StdClass();
		$request->arguments = array();

		if(array_key_exists('pl_weilandt_form', $_REQUEST)) {
			$rawRequestArguments = $_REQUEST['pl_weilandt_form'];
			$request->arguments = $rawRequestArguments;
		}

		$this->request = $request;
	}

	public function redirect( $actionName, $controllerName ) {
		$redirectUrl = get_site_url() . '/wp-admin/admin.php?page=Weilandt&pl_weilandt[controller]=' . $controllerName . '&pl_weilandt[action]=' . $actionName;

		if ( ! headers_sent() ) {
			header( 'Location: ' . $redirectUrl );
			exit;
		} else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="' . $redirectUrl . '";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url=' . $redirectUrl . '" />';
			echo '</noscript>';
			exit;
		}
	}
}
