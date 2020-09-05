<?php

if (! function_exists('mb_ucfirst')) {
    /**
     * Capitalize the first letter of a string,
     * even if that string is multi-byte (non-latin alphabet).
     *
     * @param string   $string   String to have its first letter capitalized.
     * @param encoding $encoding Character encoding
     *
     * @return string String with first letter capitalized.
     */
    function mb_ucfirst($string, $encoding = false)
    {
        $encoding = $encoding ? $encoding : mb_internal_encoding();

        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtoupper($firstChar, $encoding).$then;
    }
}

if (! function_exists('square_brackets_to_dots')) {
    /**
     * Turns a string from bracket-type array to dot-notation array.
     * Ex: array[0][property] turns into array.0.property.
     *
     * @param $path
     *
     * @return string
     */
    function square_brackets_to_dots($string)
    {
        $string = str_replace(['[', ']'], ['.', ''], $string);

        return $string;
    }
}

if (! function_exists('skote_url')) {
    /**
     * Appends the configured backpack prefix and returns
     * the URL using the standard Laravel helpers.
     *
     * @param $path
     *
     * @return string
     */
    function skote_url($path = null, $parameters = [], $secure = null)
    {
        $path = !$path || (substr($path, 0, 1) == '/') ? $path : '/' . $path;

        return url(config('skote.base.route_prefix', 'admin') . $path, $parameters, $secure);
    }
}

if (!function_exists('is_debug')) {
    /**
     * @return bool
     */
    function is_debug(): bool
    {
        return config('app.debug') == true;
    }
}
if (!function_exists('is_env_production')) {
    /**
     * @return bool
     */
    function is_env_production(): bool
    {
        return in_array(config('app.env'), ['production', 'prod']);
    }
}
if (!function_exists('is_env_local')) {
    /**
     * @return bool
     */
    function is_env_local(): bool
    {
        return in_array(config('app.env'), ['local']);
    }
}
if (!function_exists('is_env_dev')) {
    /**
     * @return bool
     */
    function is_env_dev(): bool
    {
        return in_array(config('app.env'), ['dev','development']);
    }
}
if (!function_exists('is_env_stage')) {
    /**
     * @return bool
     */
    function is_env_stage(): bool
    {
        return in_array(config('app.env'), ['stage']);
    }
}
