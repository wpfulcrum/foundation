<?php

namespace Fulcrum\Support\Helpers;

if (!function_exists('fulcrum_hard_get_option_value')) {
    /**
     * Gets the option value from the `wp_options` database.  This is a hard
     * get, as it queries the database directly to avoid any caching.
     *
     * @since 3.0.0
     *
     * @param string $optionName
     * @param int $defaultValue Default value to return if the option does not
     * exist.  The default value is 0.
     *
     * @return int|null|string
     */
    function fulcrum_hard_get_option_value($optionName, $defaultValue = 0)
    {
        if (null === $optionName) {
            return $defaultValue;
        }

        global $wpdb;

        $sqlQuery = $wpdb->prepare(
            "
				SELECT option_value
				FROM {$wpdb->prefix}options
				WHERE option_name = %s
			",
            $optionName
        );

        $result = $wpdb->get_var($sqlQuery);

        if (null === $result) {
            return $defaultValue;
        }

        return $result;
    }
}
