<?php

class Rmm_Helper
{

    /**
     * Option Secret Key
     * @since 1.0.0
     */
    public const RMM_Secret_Key = "rmm_secret_key";

    /**
     * Generate a uuid from the url
     *
     * @since 1.0.0
     */
    public static function generateUUIDFromURL($url)
    {
        // Sanitize and normalize the URL
        $normalizedUrl = strtolower(trim($url));

        // Generate a SHA-256 hash of the URL
        $hash = hash('sha256', $normalizedUrl);

        // Convert the hash into a UUID format
        $uuid = vsprintf('%s%s%s%s%s%s%s%s', str_split($hash, 4));

        return $uuid;
    }

    /**
     * Get extension from the url
     *
     * @since 1.0.0
     */
    public static function getTypeFromUrl($url)
    {
        // Parse the URL to get path
        $path = parse_url($url, PHP_URL_PATH);

        // Get the file extension using pathinfo function
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension;
    }

    /**
     * Replaces everything in the string do be used in regex
     *
     * @since 1.0.0
     */
    public static function replaceForRegex($string)
    {
        return preg_quote($string, '/');
    }

    /**
     * Get current datetime
     *
     * @since 1.0.0
     */
    public static function getDatetime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Generate random String
     *
     * @since 1.0.0
     */
    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
