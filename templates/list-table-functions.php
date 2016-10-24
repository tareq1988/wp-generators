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
    $search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;
    $do_search = ( $search ) ? $wpdb->prepare(" AND %first_column% LIKE '%%%s%%' ", $search ) : ''; 

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
        $items = $wpdb->get_results( 'SELECT * FROM %mysql_table_name% WHERE 1=1 ' . $do_search . ' ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

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

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM  %mysql_table_name%' );
}

/**
 * Fetch a single %singular_name% from database
 *
 * @param int   $id
 *
 * @return array
 */
function %prefix%_get_%singular_name%( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM  %mysql_table_name% WHERE id = %d', $id ) );
}