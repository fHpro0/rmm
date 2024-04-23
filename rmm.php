<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/fHpro0/rmm
 * @since             1.0.0
 * @package           Rmm
 *
 * @wordpress-plugin
 * Plugin Name:       Remote Metadata Modifier
 * Plugin URI:        https://github.com/fHpro0/rmm
 * Description:       Modify remote loaded metadata to save it on your site and load it from there or just remove it.
 * Version:           1.0.0
 * Author:            fHpro0
 * Author URI:        https://github.com/fHpro0/rmm/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Rmm
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('RMM_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-Rmm-activator.php
 */
function activate_Rmm()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-rmm-activator.php';
	Rmm_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-Rmm-deactivator.php
 */
function deactivate_Rmm()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-rmm-deactivator.php';
	Rmm_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_Rmm');
register_deactivation_hook(__FILE__, 'deactivate_Rmm');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-rmm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Rmm()
{

	$plugin = new Rmm();
	$plugin->run();
}
run_Rmm();
