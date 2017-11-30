<?php

if (!function_exists('fulcrum_get_current_datetime')) {
    /**
     * Get the Current DateTime
     *
     * @since 3.0.0
     *
     * @param string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return DateTime
     */
    function fulcrum_get_current_datetime($timezone = null)
    {
        return fulcrum_convert_string_to_datetime(
            '',
            fulcrum_get_timezone($timezone)
        );
    }
}

if (!function_exists('fulcrum_convert_string_to_datetime')) {
    /**
     * Convert time to DateTime and specified timezone.
     *
     * @since 3.0.0
     *
     * @param string $time The subject time to convert.
     * @param string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return DateTime
     */
    function fulcrum_convert_string_to_datetime($time = '', $timezone = 'America/Chicago')
    {
        date_default_timezone_set($timezone);
        $dt = new DateTime($time);
        $dt->setTimezone(new DateTimeZone($timezone));
        return $dt;
    }
}

if (!function_exists('fulcrum_format_string_to_datetime')) {
    /**
     * Formats a datetime string to the specified timezone and format.
     *
     * @since 3.0.0
     *
     * @param string $datetimeString The datetime string to convert.
     * @param string $format Defaults to "Y-m-d H:i:s"
     * @param null|string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return DateTime
     */
    function fulcrum_format_string_to_datetime(
        $datetimeString = '',
        $format = 'Y-m-d H:i:s',
        $timezone = null
    ) {
        $timezone = fulcrum_get_timezone($timezone);
        date_default_timezone_set($timezone);
        $dt = new DateTime($datetimeString);
        $dt->setTimezone(new DateTimeZone($timezone));
        return $dt->format($format);
    }
}

if (!function_exists('fulcrum_is_later_than_now')) {
    /**
     * Checks if the time passed in is past the current datetime
     *
     * @since 3.0.0
     *
     * @param string $timeToCompare
     * @param string $now
     * @param null|string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return DateTime
     */
    function fulcrum_is_later_than_now($timeToCompare, $now = '', $timezone = null)
    {
        $timezone = fulcrum_get_timezone($timezone);
        $now      = $now ?: fulcrum_convert_string_to_datetime('', $timezone);
        $dt       = fulcrum_convert_string_to_datetime($timeToCompare, $timezone);
        return $dt > $now;
    }
}

if (!function_exists('fulcrum_add_hours_to_datetime')) {
    /**
     * Add to DateTime
     *
     * @since 3.0.0
     *
     * @param int $hoursToAdd Number of hours to add.
     * @param string $datetime
     * @param bool|null $convertToString When true, the date time is returned as a formatted string.
     * @param string $format Defaults to "Y-m-d H:i:s"
     * @param null|string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return DateTime|string
     */
    function fulcrum_add_hours_to_datetime(
        $hoursToAdd,
        $datetime,
        $convertToString = null,
        $format = 'Y-m-d H:i:s',
        $timezone = null
    ) {
        $dt = fulcrum_convert_string_to_datetime(
            $datetime,
            fulcrum_get_timezone($timezone)
        );
        $dt->add(new DateInterval('PT' . $hoursToAdd . 'H'));

        if (true === $convertToString) {
            return $dt->format($format);
        }

        return $dt;
    }
}

if (!function_exists('fulcrum_get_timezone')) {
    /**
     * Gets the timezone.
     *
     * If one is provided, then it's returned.
     * Else, the web server's default timezone is returned.
     *
     * @since 3.0.0
     *
     * @param null|string $timezone (Optional) Specify a specific timezone. Else, uses date_default_timezone_get()
     *
     * @return null|string
     */
    function fulcrum_get_timezone($timezone = null)
    {
        if ($timezone) {
            return $timezone;
        }

        return date_default_timezone_get();
    }
}
