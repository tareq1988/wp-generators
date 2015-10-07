<?php

/**
 * Get all %singular_name%
 *
 * @param $args array
 *
 * @return array
 */
function %prefix%_get_all_%singular_name%( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = '%singular_name%-all';
    $items     = wp_cache_get( $cache_key, '%textdomain%' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . '%mysql_table_name% ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, '%textdomain%' );
    }

    return $items;
}

/**
 * Fetch all %singular_name% from database
 *
 * @return array
 */
function %prefix%_get_%singular_name%_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . '%mysql_table_name%' );
}