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
abstract class Weiland_Form_Controller
{

    /**
     * @var Twig_Environment
     */
    protected $view = null;

    protected $request = null;

    public function __construct()
    {
        $this->showFlashMessages();
        $this->buildRequestObject();
        $this->loadView();
    }

    protected function loadView()
    {

        $languageCode = 'de_DE';
        if (class_exists('Polylang') && function_exists('pll_current_language')) {
            $languageCode = pll_current_language('locale') . 'UTF-8';
        }
        putenv('LC_ALL=' . $languageCode);
        setlocale(LC_ALL, $languageCode);
        bindtextdomain("weilandtForm", WEILANDT_PATH . '/res/lang');
        textdomain("weilandtForm");
        bind_textdomain_codeset('weilandtForm', 'UTF-8');


        require_once WEILANDT_PATH . 'vendor/twig/twig/lib/Twig/Autoloader.php';
        require_once WEILANDT_PATH . 'vendor/twig/extensions/lib/Twig/Extensions/Autoloader.php';
        Twig_Autoloader::register();
        Twig_Extensions_Autoloader::register();
        $tplDir = WEILANDT_PATH . '/res/html/templates';
        $loader = new Twig_Loader_Filesystem(WEILANDT_PATH . '/res/html/templates');

        $this->view = new Weiland_Form_View_Twig($loader, array(
            'debug' => true,
            'cache' => WEILANDT_PATH . '/res/html/twig_compilation_cache',
            'auto_reload' => true
        ));

        $this->view->addExtension(new Twig_Extensions_Extension_I18n());
        $this->view->addExtension(new Twig_Extension_Debug());

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tplDir), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            // force compilation
            if ($file->isFile()) {
                $this->view->loadTemplate(str_replace($tplDir, '', $file));
            }
        }
    }

    public function showFlashMessages()
    {
        if (class_exists('WPFlashMessages')) {
            WPFlashMessages::show_flash_messages();
        }
    }

    /**
     *
     */
    protected function buildRequestObject()
    {
        $request = new StdClass();
        $request->arguments = array();

        if (array_key_exists('pl_weilandt_form', $_REQUEST)) {
            $rawRequestArguments = $_REQUEST['pl_weilandt_form'];
            $request->arguments = $rawRequestArguments;
        }

        $this->request = $request;
    }

    abstract public function redirect($actionName, $controllerName);
}
