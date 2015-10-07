<?php

/**
 * Handle the form submissions
 *
 * Although our most of the forms uses ajax and popup, some
 * are needed to submit via regular form submits. This class
 * Handles those form submission in this module
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Add entitlement with leave policies to employees
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_field_name'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'nonce_action' ) ) {
            die( __( 'Something went wrong!', 'wp-erp' ) );
        }

        if ( ! current_user_can( 'some-permission' ) ) {
            wp_die( __( 'Permission Denied!', 'wp-erp' ) );
        }

        global $wpdb;

        $table_name = 'some_table_name';
        $errors     = array();
        $page_url   = admin_url( 'admin.php?page=example-page' );

        $field_id   = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;
        $text_field = isset( $_POST['text_field'] ) ? sanitize_text_field( $_POST['text_field'] ) : '';
        $textarea   = isset( $_POST['textarea'] ) ? wp_kses_post( $_POST['textarea'] ) : '';

        if ( ! $text_field ) {
            $errors[] = 'invalid-text-field';
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        // New or edit?
        if ( ! $field_id ) {

            $fields = array(
                'location'   => $location,
                'department' => $department
            ) );

            $wpdb->insert( $table_name, $fields );

        } else {

            $fields = array(
                'location'   => $location,
                'department' => $department
            ) );

            $wpdb->update( $table_name, $fields, array( 'id' => $field_id ) );
        }


        $redirect_to = add_query_arg( array( 'affected' => $affected ), $page_url );
        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Form_Handler();