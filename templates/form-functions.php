<?php

/**
 * Insert a new leave policy
 *
 * @param array $args
 */
function %prefix%_insert_%singular_name%( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
%form_default_array%
    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . '%mysql_table%';

%wp_errors%
    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        %add_date_field%

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