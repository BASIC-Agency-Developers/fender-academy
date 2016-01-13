<?php
/*
Plugin Name: LearnPress Certificates
Plugin URI: http://thimpress.com/learnpress
Description: An addon for LearnPress plugin
Author: thimpress
Author URI: http://thimpress.com
Tags: learnpress
Version: 0.9.6
*/
/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

define( 'LPR_CERTIFICATE_FILE', __FILE__ );
define( 'LPR_CERTIFICATE_PATH', dirname( __FILE__ ) );

require_once( LPR_CERTIFICATE_PATH . '/incs/class-lpr-certificate.php' );
/**
 * Register certificate add on 
 */
function learn_press_register_certificate_addon() {
    require_once( LPR_CERTIFICATE_PATH . '/incs/_load.php' );
}
add_action( 'learn_press_register_add_ons', 'learn_press_register_certificate_addon' );

/**
 * Register activation hook
 */
function _certificate_register_activation_hook(){
    $file = ABSPATH . 'wp-content/plugins/' . basename( plugin_dir_path( LPR_CERTIFICATE_FILE ) ) . '/' . basename( LPR_CERTIFICATE_FILE );
    register_activation_hook( $file, array( 'LPR_Certificate', 'create_default_certificate' ) );
}

_certificate_register_activation_hook();

