<?php

if (!function_exists('fulcrum_is_child_post')) {
    /**
     * Checks if the given post is a child.
     *
     * @since 3.0.0
     *
     * @param int|WP_Post|null $postOrPostId Post Instance or Post ID to check
     *
     * @return boolean|null
     */
    function fulcrum_is_child_post($postOrPostId = null)
    {
        $post = get_post($postOrPostId);
        if (!$post || is_wp_error($post)) {
            return null;
        }

        return $post->post_parent > 0;
    }
}

if (!function_exists('fulcrum_is_parent_post')) {
    /**
     * Checks if the given post is a parent.
     *
     * @since 3.0.0
     *
     * @param int|WP_Post|null $postOrPostId Post Instance or Post ID to check
     *
     * @return boolean|null
     */
    function fulcrum_is_parent_post($postOrPostId = null)
    {
        $post = get_post($postOrPostId);
        if (!$post || is_wp_error($post)) {
            return null;
        }

        return $post->post_parent === 0;
    }
}

if (!function_exists('fulcrum_post_has_children')) {
    /**
     * Checks if the given post has children
     *
     * @since 3.0.0
     *
     * @param int|WP_Post|null $postOrPostId Post Instance or Post ID to check
     *
     * @return boolean|null
     */
    function fulcrum_post_has_children($postOrPostId = null)
    {
        $number_of_children = fulcrum_get_number_of_children($postOrPostId);

        return $number_of_children > 0;
    }
}

if (!function_exists('fulcrum_get_number_of_children')) {
    /**
     * Fetches the number of children for a given post or post ID.
     * If no post/post ID is passed in, then it uses the current post.
     *
     * @since 3.0.0
     *
     * @param int|WP_Post|null $postOrPostId Post Instance or Post ID to check
     *
     * @return int|false
     */
    function fulcrum_get_number_of_children($postOrPostId = null)
    {
        $post_id = fulcrum_extract_post_id($postOrPostId);
        if ($post_id < 1) {
            return false;
        }

        global $wpdb;
        return (int) $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_parent = %d", $post_id)
        );
    }
}

if (!function_exists('fulcrum_get_next_parent_post')) {
    /**
     * Get the next adjacent parent post.
     *
     * This function extends the SQL WHERE query of the WordPress get_adjacent_post()
     * function. It registers a callback to the `get_next_post_where` event filter,
     * which then adds a new WHERE parameter.
     *
     * @uses get_next_post()
     * @uses `get_next_post_where` filter
     * @uses fulcrum_add_parent_post_to_adjacent_sql()
     *
     * @since 3.0.0
     *
     * @param bool $inSameTerm Optional. Whether post should be in a same taxonomy term. Default false.
     * @param array|string $excludedTerms Optional. Array or comma-separated list of excluded term IDs. Default empty.
     * @param string $taxonomy Optional. Taxonomy, if $inSameTerm is true. Default 'category'.
     *
     * @return null|string|WP_Post Post object if successful. Null if global $post is not set. Empty string if no
     *                             corresponding post exists.
     */
    function fulcrum_get_next_parent_post($inSameTerm = false, $excludedTerms = '', $taxonomy = 'category')
    {
        add_filter('get_next_post_where', 'fulcrum_add_parent_post_to_adjacent_sql');

        return get_next_post($inSameTerm, $excludedTerms, $taxonomy);
    }
}

if (!function_exists('fulcrum_get_previous_parent_post')) {
    /**
     * Get the previous adjacent parent post.
     *
     * This function extends the SQL WHERE query of the WordPress get_adjacent_post()
     * function. It registers a callback to the `get_previous_post_where` event filter,
     * which then adds a new WHERE parameter.
     *
     * @uses get_previous_post()
     * @uses `get_previous_post_where` filter
     * @uses fulcrum_add_parent_post_to_adjacent_sql()
     *
     * @since 3.0.0
     *
     * @param bool $inSameTerm Optional. Whether post should be in a same taxonomy term. Default false.
     * @param array|string $excludedTerms Optional. Array or comma-separated list of excluded term IDs. Default empty.
     * @param string $taxonomy Optional. Taxonomy, if $inSameTerm is true. Default 'category'.
     *
     * @return null|string|WP_Post Post object if successful. Null if global $post is not set. Empty string if no
     *                             corresponding post exists.
     */
    function fulcrum_get_previous_parent_post($inSameTerm = false, $excludedTerms = '', $taxonomy = 'category')
    {
        add_filter('get_previous_post_where', 'fulcrum_add_parent_post_to_adjacent_sql');

        return get_previous_post($inSameTerm, $excludedTerms, $taxonomy);
    }
}

if (!function_exists('fulcrum_add_parent_post_to_adjacent_sql')) {
    /**
     * Adds a post parent WHERE SQL check to the adjacent SQL.
     *
     * In WordPress, the column `post_parent` is 0 when the content is
     * the root parent.
     *
     * Callback for the WordPress filter events `get_previous_post_where` and
     * `get_next_post_where`.
     *
     * @since 3.0.0
     *
     * @param string $whereSql
     *
     * @return string
     */
    function fulcrum_add_parent_post_to_adjacent_sql($whereSql)
    {
        $whereSql .= ' AND p.post_parent = 0';

        return $whereSql;
    }
}

if (!function_exists('fulcrum_extract_post_id')) {
    /**
     * Get the post ID from the given post or post ID.
     * If none is passed in, then it grabs the current ID.
     *
     * @since 3.0.0
     *
     * @param WP_Post|int|null $postOrPostId Given post or post ID
     *
     * @return int
     */
    function fulcrum_extract_post_id($postOrPostId = null)
    {
        if (is_object($postOrPostId)) {
            return (int) $postOrPostId->ID;
        }

        if ($postOrPostId > 0) {
            return (int) $postOrPostId;
        }

        return get_the_ID();
    }
}
