<?php

/**
 * The storage-facing functionality of the plugin.
 *
 * @link       https://github.com/fHpro0/rmm
 * @since      1.0.0
 *
 * @package    Rmm
 * @subpackage Rmm/storage
 */

/**
 * The storage-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the storage-facing stylesheet and JavaScript.
 *
 * @package    Rmm
 * @subpackage Rmm/storage
 * @author     fHpro0 
 */
class Rmm_Storage
{
    /**
     * Public values for cache
     *
     * @since 1.0.0
     */
    public const RMM_Available_Remote_URLS = "available-remote-urls.json";
    public const RMM_Modify_Remote_URLS = "modify-remote-urls.json";

    public const RMM_Public_Path = "/wp-content/plugins/rmm/storage/";

    /**
     * Get path JSON storage
     *
     * @since 1.0.0
     */
    public static function RMM_JSON_PATH()
    {
        return plugin_dir_path(dirname(__FILE__)) . "/storage/json/";
    }

    /**
     * Load JSON File from plugin storage
     *
     * @since 1.0.0
     */
    public static function LoadJsonFile($file)
    {
        $json = file_get_contents(Rmm_Storage::RMM_JSON_PATH() . $file);

        return json_decode($json, true) ?? [];
    }

    /**
     * Load JSON File from plugin storage
     *
     * @since 1.0.0
     */
    public static function SaveJsonFile($json, $file)
    {
        file_put_contents(Rmm_Storage::RMM_JSON_PATH() . $file, json_encode($json, JSON_PRETTY_PRINT));
    }

    /**
     * Test if url exists in array
     *
     * @since 1.0.0
     */
    public static function ExistsInArray($url, $array)
    {
        foreach ($array as $item) {
            if (isset($item['url']) && $item['url'] === $url) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generates Json Struct for the array
     *
     * @since 1.0.0
     */
    public static function UrlStruct($url, $action)
    {
        $newUrl = [
            "uuid" => Rmm_Helper::generateUUIDFromURL($url),
            "url" => $url,
            "action" => $action,
            "updated" => Rmm_Helper::getDatetime()
        ];

        if ($action !== "save") return $newUrl;

        $updated = Rmm_Storage::DownloadMetadata($newUrl);
        return $updated;
    }


    /**
     * Download Metadata to server
     *
     * @since 1.0.0
     */
    public static function DownloadMetadata($file)
    {
        if ($file["action"] !== "save") return;
        $fileContents = file_get_contents($file["url"]);

        if ($fileContents === false) return;

        $extension = Rmm_Helper::getTypeFromUrl($file["url"]);

        if ($extension == "") {
            $headers = get_headers($file["url"], 1);
            $contentType = $headers['Content-Type'];


            $extensions = [
                'text/css' => 'css',
                'application/javascript' => 'js',
            ];

            $extension = $extensions[$contentType] ?? null;
        }

        // If extension not found or not supported, it will be removed
        if ($extension == null) {
            $file["action"] = "remove";
            return $file;
        }

        $file["type"] = $extension;

        $destinationDirectory = plugin_dir_path(dirname(__FILE__)) . "/storage/" . $extension;

        if (!file_exists($destinationDirectory) && !is_dir($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }

        // Attempt to save the file
        $bytesWritten = file_put_contents($destinationDirectory . "/" . $file["uuid"] . "." . $extension, $fileContents);

        if ($bytesWritten === false) return;

        $file["updated"] = Rmm_Helper::getDatetime();

        return $file;
    }

    /**
     * Update every Metadata to server
     *
     * @since 1.0.0
     */
    public static function UpdateEveryMetadata()
    {
        $definedUrls = Rmm_Storage::LoadJsonFile(Rmm_Storage::RMM_Modify_Remote_URLS);

        foreach ($definedUrls as $key => $url) {
            $updated = Rmm_Storage::DownloadMetadata($url);
            if ($updated == null) continue;
            $definedUrls[$key] = $updated;
        }

        Rmm_Storage::SaveJsonFile($definedUrls, Rmm_Storage::RMM_Modify_Remote_URLS);
    }

    /**
     * Remove saved Metadata
     *
     * @since 1.0.0
     */
    public static function RemoveMetadata($uuid, $type)
    {
        $filePath = plugin_dir_path(dirname(__FILE__)) . "/storage/" . $type . "/" . $uuid . "." . $type;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
