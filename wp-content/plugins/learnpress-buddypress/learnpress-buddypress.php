<?php
/*
Plugin Name: LearnPress BuddyPress Integration
Plugin URI: http://thimpress.com/learnpress
Description: Using the profile system provided by BuddyPress
Author: thimpress
Version: 0.9.3
Author URI: http://thimpress.com
Tags: learnpress
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LPR_BP_PATH', dirname( __FILE__ ) );
/**
 * Register BuddyPress addon
 */
function learn_press_register_buddypress() {
    require_once( LPR_BP_PATH . '/init.php' );
}
add_action( 'learn_press_register_add_ons', 'learn_press_register_buddypress' );


add_action('plugins_loaded','learnpress_buddypress_translations');
function learnpress_buddypress_translations(){			
	$textdomain = 'learnpress_buddypress';
    $locale = apply_filters("plugin_locale", get_locale(), $textdomain);	    	       
    $lang_dir = dirname( __FILE__ ) . '/lang/';
    $mofile        = sprintf( '%s.mo', $locale );
    $mofile_local  = $lang_dir . $mofile;    
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;
    if ( file_exists( $mofile_global ) ) {    	
        load_textdomain( $textdomain, $mofile_global );
    } else {    	
        load_textdomain( $textdomain, $mofile_local );
    }  
}