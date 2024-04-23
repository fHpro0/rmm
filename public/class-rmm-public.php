<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/fHpro0/rmm
 * @since      1.0.0
 *
 * @package    Rmm
 * @subpackage Rmm/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rmm
 * @subpackage Rmm/public
 * @author     fHpro0 
 */
class Rmm_Public
{
	/**
	 * Content Output Buffering
	 *
	 * @since 1.0.0
	 */
	public function init_content()
	{
		//if (is_admin()) return;

		ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
	}


	/**
	 * Proccess Content Output Buffering and parse modified content
	 *
	 * @since 1.0.0
	 */
	public function shutdown_content()
	{
		if (is_admin()) return;

		$content = ob_get_clean();

		// Get remote metadata urls
		$foundRemoteMetadata = [];
		preg_match_all('/<(?:link|script|style)(?:.*)(?:href|src)=(?:"|\')(.*?)(?:"|\')(?:.*)(?:|\/|<\/link|<\/script|<\/style)>/', $content, $foundRemoteMetadata);

		// Update available remote data
		$remoteUrls = array_filter($foundRemoteMetadata[1], function ($url) {
			return !str_contains($url, get_site_url());
		}, ARRAY_FILTER_USE_BOTH);

		$availableUrls = Rmm_Storage::LoadJsonFile(Rmm_Storage::RMM_Available_Remote_URLS);
		$availableUrlsSize = count($availableUrls);
		foreach ($remoteUrls as $url) {
			if (in_array($url, $availableUrls)) continue;
			array_push($availableUrls, $url);
		}
		if (count($availableUrls) != $availableUrlsSize) {
			Rmm_Storage::SaveJsonFile($availableUrls, Rmm_Storage::RMM_Available_Remote_URLS);
		}

		// Get list of all remote metadata that should be removed
		$urls = Rmm_Storage::LoadJsonFile(Rmm_Storage::RMM_Modify_Remote_URLS);
		if (empty($urls)) {
			echo $content;
			return;
		}

		$removeUrls = [];
		$save = [];
		foreach ($urls as $url) {
			if ($url["action"] == "remove") {
				array_push($removeUrls, Rmm_Helper::replaceForRegex($url["url"]));
			} else {
				array_push($save, $url);
			}
		}

		if (!empty($removeUrls)) {
			$removeRegex = '/<(?:link|script|style)(?:.*)(?:href|src)=(?:"|\')(?:.*)(?:' . implode('|', $removeUrls) . ')(?:.*)(?:"|\')(?:.*)(?:|\/|<\/link|<\/script|<\/style)>/';
			$content = preg_replace($removeRegex, '', $content);
		}
		if (!empty($save)) {
			foreach ($save as $url) {
				$saveRegex = '/(' . Rmm_Helper::replaceForRegex($url["url"]) . ')/';
				$content = preg_replace($saveRegex, '/wp-content/plugins/rmm/storage/' . $url["type"] . '/' . $url["uuid"] . "." . $url["type"] . "?" . str_replace(" ", "x", $url["updated"]), $content);
			}
		}

		// Return modified content
		echo $content;
	}
}
