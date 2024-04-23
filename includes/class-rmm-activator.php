<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/fHpro0/rmm
 * @since      1.0.0
 *
 * @package    Rmm
 * @subpackage Rmm/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rmm
 * @subpackage Rmm/includes
 * @author     fHpro0 
 */
class Rmm_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		// Create json files if not exists
		$jsonFiles = [Rmm_Storage::RMM_Available_Remote_URLS, Rmm_Storage::RMM_Modify_Remote_URLS];

		foreach ($jsonFiles as $file) {
			if (file_exists(Rmm_Storage::RMM_JSON_PATH() . $file)) continue;

			Rmm_Storage::SaveJsonFile([], $file);
		}

		// Generate secret key for the api
		if (!get_option(Rmm_Helper::RMM_Secret_Key)) {
			add_option(Rmm_Helper::RMM_Secret_Key, Rmm_Helper::generateRandomString());
		}
	}
}
