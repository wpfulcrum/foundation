<?php

if (!function_exists('fulcrum_declare_plugin_constants')) {
    /**
     * Get the plugin's URL, obtained from the plugin's root file.
     *
     * @since 3.0.0
     *
     * @param string $prefix Constant prefix
     * @param string $rootPath Plugin's root file
     *
     * @returns string Returns the plugin URL
     */
    function fulcrum_declare_plugin_constants($prefix, $rootPath)
    {
        if (!defined($prefix . '_PLUGIN_DIR')) {
            define($prefix . '_PLUGIN_DIR', plugin_dir_path($rootPath));
        }

        if (!defined($prefix . '_PLUGIN_URL')) {
            define($prefix . '_PLUGIN_URL', fulcrum_get_plugin_url($rootPath));
        }
    }
}

if (!function_exists('fulcrum_get_plugin_url')) {
    /**
     * Get the plugin's URL, obtained from the plugin's root file.
     *
     * @since 3.0.0
     *
     * @param string $rootPath Plugin's root file
     *
     * @returns string Returns the plugin URL
     */
    function fulcrum_get_plugin_url($rootPath)
    {
        $pluginUrl = plugin_dir_url($rootPath);
        if (!is_ssl()) {
            return $pluginUrl;
        }
        return str_replace('http://', 'https://', $pluginUrl);
    }
}

if (!function_exists('fulcrum_is_dev_environment')) {
    /**
     * Checks if the current environment is set to local dev or not.
     *
     * @since 3.0.0
     *
     * @returns bool
     */
    function fulcrum_is_dev_environment()
    {
        if (!defined('FULCRUM_ENV')) {
            return false;
        }

        return FULCRUM_ENV === 'dev';
    }
}
