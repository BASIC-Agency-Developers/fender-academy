<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register add on LearnPress
 *
 * @param $installed
 *
 * @return mixed
 */
function learn_press_register_add_on_mycred( $installed ) {
	$installed['learnpress'] = array(
		'name'        => 'LearnPress',
		'description' => __( 'Integrating with learning management system provided by LearnPress.', 'learn_press_mycred' ),
		'addon_url'   => 'http://thimpress.com/learnpress',
		'version'     => '1.0.0',
		'author'      => 'Ken',
		'author_url'  => 'http://thimpress.com',
		'path'        => LPR_MC_PATH . '/inc/addon/mycred-addon-learnpress.php'
	);

	return $installed;

}

add_filter( 'mycred_setup_addons', 'learn_press_register_add_on_mycred' );

/**
 * Enqueue scripts
 */
function learn_press_enqueue_scripts_mycred() {
	global $pagenow;
	if ( $pagenow != 'admin.php' ) {
		return;
	}

	if ( !isset( $_GET['page'] ) || $_GET['page'] != 'myCRED_page_hooks' ) {
		return;
	}
	wp_enqueue_style( 'mycred-learnpress', LPR_MC_URL . 'inc/scripts/learnpress.css' );
}

add_action( 'init', 'learn_press_enqueue_scripts_mycred' );


/**
 * Get course information from an order
 *
 * @param $order_id
 *
 * @return array
 */
function learn_press_get_course_info( $order_id ) {
	$course_info = array();
	// Check if order is invalid
	if ( !$order_id ) {
		return $course_info;
	}

	$order_items = get_post_meta( $order_id, '_learn_press_order_items', true ) ? get_post_meta( $order_id, '_learn_press_order_items', true ) : 0;

	if ( !$order_items ) {
		return $course_info;
	}

	$products = $order_items->products;

	if ( !$products ) {
		return $course_info;
	}

	$course    = array_pop( $products );
	$course_id = isset( $course['id'] ) ? $course['id'] : 0;

	// Check if course is invalid
	if ( !$course_id ) {
		return $course_info;
	}
	$course_info['id'] = $course_id;

	$instructor_id = get_post_field( 'post_author', $course_id );

	// Check if user is invalid
	if ( !$instructor_id ) {
		return $course_info;
	}
	$course_info['instructor'] = $instructor_id;

	return $course_info;
}