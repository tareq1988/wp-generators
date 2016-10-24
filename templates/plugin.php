<?php
/**
 * Plugin Name: Babsonraac Admin Pages
 * Plugin URI: http://www.groupkayak.com
 * Description: This plugin adds some Admin features into the backend.
 * Version: 1.0.0
 * Author: Kevin Angulo
 * Author URI: http://www.groupkayak.com
 * License: GPL2
 */

add_action('init', function(){

    include dirname( __FILE__ ) . '/includes/class-address-admin-menu.php';
    include dirname( __FILE__ ) . '/includes/class-address-list-table.php';
    include dirname( __FILE__ ) . '/includes/class-form-handler.php';
    include dirname( __FILE__ ) . '/includes/address-functions.php';

    new Address_Admin_menu();
});