<?php

/**
 * Insert a new leave policy
 *
 * @param array $args
 */
function prefix_insert_%singular_name%( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'date'      => current_time( 'mysql' )
    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . '%mysql_table%';

    // some basic validation
    if ( empty( $args['name'] ) ) {
        return new WP_Error( 'no-name', __( 'No name provided.', 'wp-error' ) );
    }

    if ( ! intval( $args['value'] ) ) {
        return new WP_Error( 'no-value', __( 'No duration provided.', 'wp-error' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}