<?php
/*
Plugin Name: ACF Hotspots
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function hotspot_enqueue_fender($hook) {
    if ( 'post.php' != $hook ) {
        return;
    }

    wp_enqueue_script( 'hotspot_fender', plugin_dir_url( __FILE__ ) . 'hotspots.js' );
}
add_action( 'admin_enqueue_scripts', 'hotspot_enqueue_fender' );