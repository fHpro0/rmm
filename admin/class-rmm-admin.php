<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/fHpro0/rmm
 * @since      1.0.0
 *
 * @package    Rmm
 * @subpackage Rmm/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rmm
 * @subpackage Rmm/admin
 * @author     fHpro0
 */
class Rmm_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rmm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rmm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page = $_GET['page'];
		if (!isset($page) || !str_contains($page, 'rmm-options')) {
			return;
		}

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/rmm-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rmm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rmm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page = $_GET['page'];
		if (!isset($page) || !str_contains($page, 'rmm-options')) {
			return;
		}

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/rmm-admin.js', array('jquery'), $this->version, false);
	}


	/**
	 * Register Option Page for RMM.
	 *
	 * @since    1.0.0
	 */
	public function RMM_Add_Option_Page()
	{
		add_options_page(
			'Remote Metadata Remover',
			'Remote Metadata Remover',
			'manage_options',
			'rmm-options',
			[
				$this,
				'RMM_Option_Page'
			]
		);
	}

	/**
	 * Render Option Page for RMM.
	 *
	 * @since    1.0.0
	 */
	public function RMM_Option_Page()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/rmm-admin-display.php';
	}

	/**
	 * Register API Routes for RMM.
	 *
	 * @since    1.0.0
	 */
	public function rmm_register_api_routes()
	{
		register_rest_route('rmm/v1', '/metadata/update', [
			'methods' => 'GET',
			'callback' => [$this, 'rmm_metadata_update_rest_api'],
		]);
	}

	/**
	 * API Route for Metadata Updating.
	 *
	 * @since    1.0.0
	 */
	public function rmm_metadata_update_rest_api($request)
	{
		$key = $_GET['key'];

		$response = [
			"error" => true,
			"status" => ""
		];

		if (!isset($key)) {
			$response["status"] = "please parse infos";
			return $response;
		}

		if ($key !== get_option(Rmm_Helper::RMM_Secret_Key)) {
			$response["status"] = "you are not allowed";
			return $response;
		}

		Rmm_Storage::UpdateEveryMetadata();

		$response["status"] = "All the metadata content are now up to date.";
		$response["error"] = false;
		return $response;
	}
}
