<?php
/*
Plugin Name: LearnPress myCRED Integration
Plugin URI: http://thimpress.com/learnpress
Description: Running with the point management system - myCred
Author: ThimPress
Version: 1.0.0
Author URI: http://thimpress.com
Tags: learnpress, lms, myCred
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'LPR_MC_PATH', plugin_dir_path( __FILE__ ) );
define( 'LPR_MC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register myCred addon
 */
function learn_press_register_mycred() {
	require_once( LPR_MC_PATH . '/init.php' );
}

add_action( 'learn_press_register_add_ons', 'learn_press_register_mycred' );


