<?php

if (!function_exists('fulcrum_prevent_direct_file_access')) {
    /**
     * Checks if the file is being accessed directly. If
     * yes, then it exits the app.
     *
     * @since 3.0.0
     *
     * @returns void
     */
    function fulcrum_prevent_direct_file_access()
    {
        if (!defined('ABSPATH')) {
            exit('Cheatin&#8217; uh?');
        }
    }
}

if (!function_exists('fulcrum_load_config')) {
    /**
     * Load and return the Config object
     *
     * @since 3.0.0
     *
     * @param string $configFile Config filename with extension
     * @param string $path Config path.  Defaults to plugin config folder
     *
     * @returns Fulcrum Returns the Config object
     */
    function fulcrum_load_config($configFile, $path = '')
    {
        Factory::create($configFile, $path);
    }
}

if (!function_exists('fulcrum_flush_rewrites')) {
    /**
     * Flush the rewrites
     *
     * @since 3.0.0
     *
     * @param bool $hardFlush (Optional) True will do a hard flush
     *
     * @returns null
     */
    function fulcrum_flush_rewrites($hardFlush = true)
    {
        flush_rewrite_rules($hardFlush);
    }
}

if (!function_exists('fulcrum_get_post_id')) {
    /**
     * Get the Post ID
     *
     * If in the back-end, it will use $_REQUEST;
     * else it uses either the incoming post ID or $post->ID
     *
     * @since 3.0.0
     *
     * @param int $postId (optional)
     *
     * @return int Returns the post ID, if one is found; else 0.
     */
    function fulcrum_get_post_id($postId = 0)
    {
        if (is_admin()) {
            return fulcrum_get_post_id_when_in_backend($postId);
        }

        return $postId < 1 ? get_the_ID() : $postId;
    }
}

if (!function_exists('fulcrum_get_post_id_when_in_backend')) {
    /**
     * Get the Post ID
     *
     * If in the back-end, it will use $_REQUEST;
     * else it uses either the incoming post ID or $post->ID
     *
     * @since 3.0.0
     *
     * @param int $postId (optional)
     *
     * @return int Returns the post ID, if one is found; else 0.
     */
    function fulcrum_get_post_id_when_in_backend($postId = 0)
    {
        if (!is_admin()) {
            return $postId;
        }

        $possibleRequestKeys = [
            'post_ID',
            'post_id',
            'post',
        ];

        foreach ($possibleRequestKeys as $key) {
            if (!isset($_REQUEST[$key])) {
                continue;
            }

            if (is_numeric($_REQUEST[$key])) {
                return (int) $_REQUEST[$key];
            }
        }

        return $postId;

        global $pagenow;
        return in_array($pagenow, ['post.php', 'post-new.php']) && isset($_REQUEST['post'])
            ? intval($_REQUEST['post'])
            : $postId;
    }
}

if (!function_exists('fulcrum_limit_by_characters')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param  string $value
     * @param  int $limit
     * @param  string $end
     *
     * @return string
     */
    function fulcrum_limit_by_characters($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
    }
}

if (!function_exists('fulcrum_word_limiter')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string $value
     * @param  int $limit
     * @param  string $end
     *
     * @return string
     */
    function fulcrum_word_limiter($value, $limit = 30, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $value, $matches);

        if (!isset($matches[0]) || strlen($value) === strlen($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]) . $end;
    }
}

if (!function_exists('fulcrum_class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param  string|object $class
     *
     * @return string
     */
    function fulcrum_class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
if (!function_exists('fulcrum_object_get')) {
    /**
     * Get an item from an object using "dot" notation.
     *
     * @param  object $object
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    function fulcrum_object_get($object, $key, $default = null)
    {
        if (is_null($key) || '' == trim($key)) {
            return $object;
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_object($object) || !isset($object->{$segment})) {
                return fulcrum_value($default);
            }
            $object = $object->{$segment};
        }

        return $object;
    }
}
if (!function_exists('fulcrum_value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     *
     * @return mixed
     */
    function fulcrum_value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('fulcrum_with')) {
    /**
     * Return the given object. Useful for chaining.
     *
     * @param  mixed $object
     *
     * @return mixed
     */
    function fulcrum_with($object)
    {
        return $object;
    }
}

if (!function_exists('fulcrum_data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed $target
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    function fulcrum_data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }
        foreach (explode('.', $key) as $segment) {
            if (is_array($target)) {
                if (!array_key_exists($segment, $target)) {
                    return fulcrum_value($default);
                }
                $target = $target[$segment];
            } elseif ($target instanceof ArrayAccess) {
                if (!isset($target[$segment])) {
                    return fulcrum_value($default);
                }
                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (!isset($target->{$segment})) {
                    return fulcrum_value($default);
                }
                $target = $target->{$segment};
            } else {
                return fulcrum_value($default);
            }
        }

        return $target;
    }
}

if (!function_exists('fulcrum_init_authordata')) {
    function fulcrum_init_authordata()
    {
        global $authordata;

        $authordata = is_object($authordata)
            ? $authordata
            : get_userdata(get_query_var('author'));
    }
}

if (!function_exists('fulcrum_get_calling_class_directory')) {
    /**
     * Get child's directory.
     *
     * @since 3.0.0
     *
     * @param mixed $object Instance of the object to work on.
     *
     * @return string
     */
    function fulcrum_get_calling_class_directory($object)
    {
        if (!is_object($object)) {
            return '';
        }
        $classInfo = new ReflectionClass(get_class($object));
        return trailingslashit(dirname($classInfo->getFileName()));
    }
}

if (!function_exists('fulcrum_add_button_class')) {
    /**
     * Add button class to a tag.
     *
     * @since 1.0.3
     *
     * @param string $html
     * @param array $classes
     *
     * @return string
     */
    function fulcrum_add_button_class($html, array $classes = [])
    {
        if (fulcrum_str_contains($html, '<a class="')) {
            $newPattern    = '<a class="%s ';
            $searchPattern = '<a class="';
        } else {
            $newPattern    = '<a class="%s"';
            $searchPattern = '<a';
        }

        $classes[]  = 'button';
        $newPattern = sprintf($newPattern, join(' ', $classes));

        return str_replace($searchPattern, $newPattern, $html);
    }
}

if (!function_exists('fulcrum_add_grid_to_post_class')) {
    /**
     * Add grid classes to the posts.
     *
     * @since 1.0.3
     *
     * @param array $classes
     *
     * @return array
     */
    function fulcrum_add_grid_to_post_class(array $classes)
    {
        global $wp_query;

        $classes[] = 'one-half';

        if ($wp_query->current_post > 0 && $wp_query->current_post % 2) {
            $classes[] = 'last';
        }

        return $classes;
    }
}

function fulcrum_sanitize_metadata($metadata, $filter = '')
{
    if (!is_array($metadata)) {
        return fulcrum_sanitize_single_metadata($metadata, $filter);
    }

    foreach ($metadata as $key => $value) {
        $metadata[$key] = fulcrum_sanitize_single_metadata($value, $filter[$key]);
    }

    return $metadata;
}

function fulcrum_sanitize_single_metadata($value, $filter = '')
{
    if ($filter) {
        return $filter($value);
    }

    if (is_numeric($value)) {
        return (int) $value;
    }

    return strip_tags($value);
}

if (!function_exists('fulcrum_get_url_relative_to_home_url')) {
    /**
     * Get the URL relative to the site's root (home url).
     *
     * Performance function.
     *
     * This function uses `get_home_url()` and caches it.  It allows us to speed up
     * building links and menus as we don't have to call `home_url( 'some-path' );`
     * over and over again.
     *
     * @since 1.2.3
     *
     * @param  string $path Optional. Path relative to the home URL. Default empty.
     * @param  string|null $scheme Optional. Scheme to give the home URL context. Accepts
     *                              'http', 'https', 'relative', 'rest', or null. Default null.
     *
     * @return string Home URL link with optional path appended.
     */
    function fulcrum_get_url_relative_to_home_url($path = '', $scheme = null)
    {
        static $homeUrl;

        if (!$homeUrl) {
            $homeUrl = get_home_url(null, '', $scheme);
        }

        if (!$homeUrl) {
            return '';
        }

        return sprintf('%s/%s', $homeUrl, ltrim($path, '/'));
    }
}
