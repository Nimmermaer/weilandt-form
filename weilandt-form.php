<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.exteo.de
 * @since             1.17
 * @package           Weilandt_form
 *
 * @wordpress-plugin
 * Plugin Name:       Weilandt Form
 * Plugin URI:        /
 * Description:       A simple plugin
 * Version:           0.0.1
 * Author:            Michael Blunck
 * Author URI:        http://www.exteo.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       weilandt-form
 * Domain Path:       /languages
 * Depends: Countries Database, WP Flash Messages
 */


/**
 * @var array formulars
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Define constants for the plugin
 */
define('WEILANDT_PATH', plugin_dir_path(__FILE__));
define('WEILANDT_URI', plugin_dir_url(__FILE__));

/**
 *  Forms
 */
$GLOBALS['Forms'] = array(
    array(
        'id' => '1',
        'name' => 'Casio Reparaturauftrag',
        'color' => 'green'
    ),
    array(
        'id' => '2',
        'name' => 'M3Mobile Reparaturauftrag',
        'color' => 'yellow'
    ),
    array(
        'id' => '3',
        'name' => 'RMA Request Form',
        'color' => 'primary'
    )
);

register_activation_hook(__FILE__,
    function () {
        require_once plugin_dir_path(__FILE__) . 'classes/class-weiland-form-plugin-manager.php';
        $pluginManager = new Weiland_Form_Plugin_Manager();
        $pluginManager->activate();

    });


function weilandt_form_options()
{
    (new Weiland_Form_Option_Controller())->optionAction();
}

add_shortcode('weilandt_frontend', function ($atts) {
    require_once plugin_dir_path(__FILE__) . 'classes/class-weiland-form-plugin-manager.php';
    $pluginManager = new Weiland_Form_Plugin_Manager();
    $pluginManager->activateFrontend($atts);
});

add_action('the_post', function () {
    if (array_key_exists('form', $_REQUEST)) {
        $form = new Weiland_Form_User_Model($_REQUEST['form']);
        $form->persist();
    }

});

add_action('admin_post_contact_form', function () {

});

$runWeilandtForm = function () {
    require_once plugin_dir_path(__FILE__) . 'classes/class-weiland-form-plugin-manager.php';
    $pluginManager = new Weiland_Form_Plugin_Manager();
    $pluginManager->run();
};
$runWeilandtForm();