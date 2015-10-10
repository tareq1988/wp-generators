<?php

/**
 * Handle the form submissions
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
     * Handle the %singular_name% new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['%submit_name%'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '%nonce%' ) ) {
            die( __( 'Are you cheating?', '%textdomain%' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', '%textdomain%' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=%page_slug%' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

%form_fields%
        // some basic validation
%required_form_fields%        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = %form_fields_array%

        // New or edit?
        if ( ! $field_id ) {

            %prefix%_insert_%singular_name%( $fields );

        } else {

            $fields['id'] = $field_id;

            %prefix%_insert_%singular_name%( $fields );
        }

        $redirect_to = add_query_arg( array( 'affected' => $affected ), $page_url );
        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Form_Handler();