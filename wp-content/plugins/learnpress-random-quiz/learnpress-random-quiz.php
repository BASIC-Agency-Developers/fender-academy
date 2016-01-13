<?php
/*
Plugin Name: LearnPress Randomize Quiz
Plugin URI: http://thimpress.com/learnpress
Description: Create a quiz with randomize questions
Author: thimpress
Version: beta
Author URI: http://thimpress.com
Tags: learnpress
*/

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// Addon path
define( 'LPR_RANDOM_QUIZ_PLUGIN_PATH', dirname( __FILE__ ) );
/**
 * Register addon
 */
function learn_press_register_random_quiz() {

    require_once( LPR_RANDOM_QUIZ_PLUGIN_PATH . '/class-lpr-random-quiz.php' );
}
add_action( 'learn_press_register_add_ons', 'learn_press_register_random_quiz' );
