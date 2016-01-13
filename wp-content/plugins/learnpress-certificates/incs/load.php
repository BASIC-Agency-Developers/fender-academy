<?php
/**
 * Project:     learnpress.
 * Author:      TuNN
 * Date:        20 Mar 2015
 *
 * Copyright 2007-2014 thimpress.com. All rights reserved.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'LPR_CERTIFICATE_CPT',          'lpr_certificate' );
define( 'LPR_CERTIFICATE_SLUG',         'certificate' );
define( 'LPR_CERTIFICATE_TYPE_SLUG',    'certificate-type' );

/**
 * Class LPR_Certificate
 *
 * @author      TuNguyen
 * @created     03 Apr 2015
 */
class LPR_Certificate{
    private static $_instance 	= false;
    private $_plugin_url		= '';
    private $_plugin_path		= '';
    /**
     * Constructor
     */
    function __construct(){

        $this->_plugin_path = LPR_CERTIFICATE_PATH;
        
        require_once( $this->_plugin_path . '/incs/class-lpr-certificate-template.php' );
        require_once( $this->_plugin_path . '/incs/class-rwmb-certificate-field.php' );

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_script' ) );

        add_filter( 'learn_press_course_settings_meta_box_args', array( $this, 'add_fields_to_meta_box' ) );
    }

    /**
     * Add admin script     
     */
    function admin_script(){
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'wp-color-picker');
    }

    /**
     * Add fields to meta box     
     */
    function add_fields_to_meta_box( $meta_box ){
        $prefix = '_lpr_';
        $meta_box['fields'][] = array(
            'name' => __( 'Select Certificate', 'meta-box' ),
            'id' => "{$prefix}certificate",
            'type' => 'certificate'
        );
        return $meta_box;
    }

    /**
     * Get the url of this plugin
     *
     * @var     $sub    string  Optional - The sub-path to append to url of plugin
     * @return  string
     */
    function get_plugin_url( $sub = '' ){
    	if( ! $this->_plugin_url ){
    		$this->_plugin_url 	= plugins_url( '', LPR_CERTIFICATE_FILE );
    	}
        return $this->_plugin_url . ( $sub ? '/' . $sub : '' );
    }

    /**
     * Get the path of this plugin
     *
     * @var     $sub    string  Optional - The sub-path to append to path of plugin
     * @return  string
     */
    function get_plugin_path( $sub = '' ){
        return $this->_plugin_path . ( $sub ? '/' . $sub : '' );
    }

    /**
     * Get an instance of main class, create a new one if it's not loaded
     *
     * @return bool|LPR_Certificate
     */
    static function instance(){
        if( !self::$_instance ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

/**
 * Register certificate post type
 */
function lpr_certificate_post_type() {
    $user = wp_get_current_user();

	register_post_type( LPR_CERTIFICATE_CPT,
		array(
			'labels'             => array(
				'name'          => __( 'Certificate', 'learn_press' ),
				'menu_name'     => __( 'Certificates', 'learn_press' ),
				'singular_name' => __( 'Certificate', 'learn_press' ),
				'add_new_item'  => __( 'Add New Certificate', 'learn_press' ),
				'edit_item'     => __( 'Edit Certificate', 'learn_press' ),
				'all_items'     => __( 'Certificates', 'learn_press' ),
			),
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'has_archive'        => true,
			'capability_type'    => LPR_COURSE_CPT,
			'map_meta_cap'       => true,
			'show_in_menu'       => 'learn_press',
			'show_in_admin_bar'  => true,
			'show_in_nav_menus'  => true,
			'supports'           => array(
				'title',
				'author'
			),
			'rewrite'            => array( 'slug' => LPR_CERTIFICATE_SLUG ),
            'map_meta_cap' => true,
		)
	);

    LPR_Certificate::instance();

}
// Hook into the 'init' action
add_action( 'wp_loaded', 'lpr_certificate_post_type' );

/**
 * Rewrite tag 
 */
function learn_press_certificate_add_rewrite_tag() {
    add_rewrite_tag('%certificate%', '([^&]+)');
    add_rewrite_tag('%download%', '([^&]+)');
    add_rewrite_tag('%pdf%', '([^&]+)');
}

/**
 * Add rewrite rule
 */
function learn_press_certificate_add_rewrite_rule() {
    add_rewrite_rule('^certificate/([0-9]+)/([0-9]+)/?(download)?/?', 'index.php?certificate=$matches[1]|$matches[2]&download=$matches[3]', 'top');
}
add_action( 'init', 'learn_press_certificate_add_rewrite_tag', 1000 );
add_action( 'init', 'learn_press_certificate_add_rewrite_rule', 1000 );

/**
 * Certificate output
 */
function learn_press_certificate_output(){
    global $wp_query;
    if( ! empty( $wp_query->query_vars['certificate'] ) ){
        $certificate = explode('|', $wp_query->query_vars['certificate']);
        $cert = new LPR_Certificate_Template();
        $_GET['course_id']  = $certificate[0];
        $_GET['uid']        = $certificate[1];
        if( ! empty( $wp_query->query_vars['download'] ) ) $_GET['download'] = $wp_query->query_vars['download'];
        $cert->certificate();
        die();
    }
}
add_action( 'wp', 'learn_press_certificate_output', 1001 );

/**
 * Certificate Url
 * 
 * @param  int $course_id 
 * @param  int $user_id   
 * @param  array  $args
 * @return string
 */
function learn_press_certificate_url( $course_id, $user_id, $args = array() ){
    $format = null;
    $width  = null;
    $height = null;
    extract( $args );
    $params = array();
    if( $format ) $params[] = "format={$format}";
    if( $width ) $params[] = "width={$width}";
    if( $height ) $params[] = "height={$height}";

    if ( get_option('permalink_structure') ) {
        $url = get_site_url() . "/certificate/{$course_id}/{$user_id}/" . ($params ? "?" . join('&', $params) : '');
    }else{
        $url = get_site_url() . "?certificate={$course_id}|{$user_id}" . ($params ? "&" . join('&', $params) : '');
    }
    return $url;
}

/**
 * Certificate download url
 * 
 * @param  int $course_id 
 * @param  int $user_id   
 * @param  string $format
 * @return string
 */
function learn_press_certificate_download_url( $course_id, $user_id, $format = '' ){
    if ( get_option('permalink_structure') ){
        $download = get_site_url() . "/certificate/{$course_id}/{$user_id}/download" . ( $format ? "?format={$format}" : '');
    }else{
        $download = get_site_url() . "?certificate={$course_id}|{$user_id}&download=true" . ( $format ? "&format={$format}" : '');
    }
    return $download;
}

/**
 * User finish course cookies
 *
 * @param  int $course_id
 * @param  int $user_id
 */
function learn_press_user_finished_course_cookie( $course_id, $user_id ){
    if( $cert_id = get_post_meta( $course_id, '_lpr_course_certificate', true ) ) {
        set_transient('learn_press_user_finished_course_' . $user_id, $course_id);
    }
}
add_action( 'learn_press_user_finished_course', 'learn_press_user_finished_course_cookie', 10, 2);

/**
 * Certificate popout
 */
function learn_press_certificate_popout(){
    $user_id = get_current_user_id();
    $course_id = get_transient( 'learn_press_user_finished_course_' . $user_id );

    if( ! $course_id ) return;
    if( ! learn_press_user_has_passed_course( $course_id, $user_id ) ) return;

    ?>
    <div id="user-certificate">
        <p class="cert-description"><?php _e( 'Congratulations! You have passed this course and get a certificate from us.', 'learn_press' );?></p>
        <img src="<?php echo learn_press_certificate_url( $course_id, $user_id );?>" />
        <p class="cert-actions">
            <?php _e( 'Download certificate as: ', 'learn_press' );?>
            <a href="<?php echo learn_press_certificate_download_url( $course_id, $user_id );?>">Image</a> or
            <a href="<?php echo learn_press_certificate_download_url( $course_id, $user_id, 'pdf' );?>">PDF</a>
            <a href="" class="close"><?php _e( 'Close', 'learn_press' );?></a>
        </p>
    </div>
    <script type="text/javascript">
        jQuery(function($){
            $(document.body).block_ui({position: 'fixed', 'z-index': 99999, backgroundColor: '#000'});///append('<div id="user-certificate-block" />');
            $('#user-certificate').css({top: $(window).scrollTop() + 50}).fadeIn().find('.close').click(function(evt){
                evt.preventDefault();
                $(document.body).unblock_ui();
                $('#user-certificate').fadeOut(function(){$(this).remove()});
            });
        })
    </script>
    <?php
    delete_transient( 'learn_press_user_finished_course_' . $user_id );
    ?>
<?php
}
add_action( 'wp_footer', 'learn_press_certificate_popout', 99999);

/**
 * Certificate script
 */
function learn_press_certificate_script(){
    if( is_admin() ) return;
    LPR_Assets::enqueue_script( 'learnpress-block-ui', LPR_PLUGIN_URL . '/assets/js/jquery.block-ui.js' );
    wp_enqueue_style( 'certificate',  LPR_Certificate::instance()->get_plugin_url( '/assets/css/frontend-certificate.css' ) );
}
add_action( 'wp_enqueue_scripts', 'learn_press_certificate_script' );

