<?php

/**
 * Admin Menu
 */
class Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        add_menu_page( __( 'Human Resource', '%textdomain%' ), __( 'HR Management', '%textdomain%' ), 'erp_list_employee', 'erp-hr', array( $this, 'employee_page' ), 'dashicons-groups', null );
        add_submenu_page( 'erp-hr', __( 'Overview', '%textdomain%' ), __( 'Overview', '%textdomain%' ), 'erp_list_employee', 'erp-hr', array( $this, 'employee_page' ) );
    }

    /**
     * Handles the dashboard page
     *
     * @return void
     */
    public function employee_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                if ( ! $id ) {
                    wp_die( __( 'Item not found!', '%textdomain%' ) );
                }

                $template = dirname( __FILE__ ) . '/views/book-single.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/book-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/book-index.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

}

new Admin_Menu();