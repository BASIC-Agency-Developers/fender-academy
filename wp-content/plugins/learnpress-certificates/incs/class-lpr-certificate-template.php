<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * @param $meta_boxes
 * @return array
 */

class LPR_Certificate_Template{
    /**
     * @var int
     */
    private $post           = null;

    /**
     * @var null
     */
    private $certificate    = null;

    /**
     * Constructor     
     */
    function __construct( $initial = true ){
        if( !$initial ) return;
        $post_id = isset( $_REQUEST['post'] ) ? intval( $_REQUEST['post'] ) : 0;
        if( ! $post_id ){
            //wp_die( 'The post is empty' );
        }
        $this->post = get_post( $post_id );
        $this->certificate = get_post_meta( $post_id, '_lpr_certificate_template', true );

        add_action( 'admin_enqueue_scripts', array( $this, 'admin_head' ) );
        add_action( 'admin_enqueue_styles', array( $this, 'admin_head' ) );
        add_action( 'admin_print_scripts', array( $this, 'admin_js_template' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'update_template' ) );
        add_action( 'learn_press_enrolled_course_after_title', array( $this, 'user_profile_certificate' ), 10, 2 );

        // ajax actions
        add_action( 'wp_ajax_rwmb_image_text', array( $this, 'ajax_image_text' ) );
        add_action( 'wp_ajax_course_certificates', array( $this, 'certificate' ) );
        add_action( 'wp_ajax_nopriv_course_certificates', array( $this, 'certificate' ) );
    }

    /**
     * User Profile Certificate
     * 
     * @param  int $course 
     * @param  int $user        
     */
    function user_profile_certificate( $course, $user ){
        if( learn_press_user_has_passed_course( $course->ID, $user->ID ) ){
            $cert = get_post_meta( $course->ID, '_lpr_course_certificate', true );
            if( ! $cert ) return;
            ?>
            <div class="">
                <a href="<?php echo learn_press_certificate_url( $course->ID, $user->ID );?>" target="_blank"><img src="<?php echo learn_press_certificate_url( $course->ID, $user->ID, array( 'width' => 500));?>" /></a>
                <p>
                <?php _e( 'Download certificate as: ', 'learn_press' );?>
                <a href="<?php echo learn_press_certificate_download_url( $course->ID, $user->ID );?>">Image</a> or
                <a href="<?php echo learn_press_certificate_download_url( $course->ID, $user->ID, 'pdf' );?>">PDF</a>
                </p>
            </div>
            <?php
        }
    }

    /**
     * Update template
     * 
     * @param  int $post_id      
     */
    function update_template( $post_id ){

        // Check if our nonce is set.
        if ( ! isset( $_POST['_lpr_certificate_template'] ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $certificate_template = $_POST['_lpr_certificate_template'];

        $thumb = wp_get_attachment_image_src( $certificate_template['id'], 'full' );
        $meta = array(
            'id'        => $certificate_template['id'],
            'src'       => $thumb[0],
            'layers'    => array()
        );

        if( isset( $certificate_template['layers'] ) ){
            foreach( $certificate_template['layers']['fontFamily'] as $k => $f ){
                $offset = explode(':', $certificate_template['layers']['offset'][$k] );
                $meta['layers'][] = array(
                    'fontFamily'        => $f,
                    'fontSize'          => $certificate_template['layers']['fontSize'][$k],
                    'color'             => $certificate_template['layers']['color'][$k],
                    'field'             => $certificate_template['layers']['field'][$k],
                    'offset'            => array( 'left' => $offset[0], 'top' => $offset[1] ),
                    'format'            => $certificate_template['layers']['format'][$k],
                    'text_align'        => $certificate_template['layers']['text_align'][$k]
                );
            }
        }

        $post = get_post( $post_id );
        update_post_meta( $post_id, '_lpr_certificate_template', $meta );

        $path = $this->get_default_path( 'preview' );

		$__x = explode( '.', $thumb[0] );
        $args = array(
            'template'      => $thumb[0],
            'path'          => $path . '/' . $post->post_name . '.' . end( $__x ),
            'layers'        => array()
        );
        if( $layers = $meta['layers']) foreach( $layers as $l ){
            $args['layers'][] = array(
                'text'          => $l['field'],
                'font_size'     => intval( $l['fontSize'] ),
                'font_name'     => $this->get_font( $l['fontFamily'] ),
                'color'         => $l['color'],
                'x'             => $l['offset']['left'],
                'y'             => $l['offset']['top']
            );
        }
        $preview_path = $this->generate_certificate( $args );
        $preview_path = str_replace( '\\', '/', $preview_path );

        update_post_meta( $post_id, '_lpr_certificate_preview', array(
            'url'   => str_replace( str_replace( '\\', '/', ABSPATH ), home_url() . '/' , $preview_path ),
            'path'  => $preview_path
        ) );
    }

    /**
     * Admin head enqueue style    
     */
    function admin_head(){
    	wp_enqueue_style( 'wp-color-picker' ); 
        wp_enqueue_style( 'rwmb-certificate-css', LPR_Certificate::instance()->get_plugin_url( 'assets/css/certificate.css' ) );
        wp_enqueue_script( 'rwmb-certificate-script', LPR_Certificate::instance()->get_plugin_url( 'assets/js/certificate.js' ), array('jquery', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-draggable') );
    }

    /**
     * Add script      
     */
    function admin_js_template(){
        $fonts = $this->get_fonts();
        $font = reset( $fonts );
        ?>
        <script type="text/javascript">
            var certificateSettings = {
                fontFamily: '<?php echo $font['name'];?>'
            }
        </script>
        <?php
        echo '<script type="text/html" id="tmpl-certificate-template-designer">';
        ?>
        <div class="certificate-designer" id="certificate-designer-{{data.id}}" data-id="{{data.id}}">
            <p class="cd-top">
                <!-- <button class="button cd-fullscreen" type="button"><?php _e('Full screen');?></button> -->
                <button class="button cd-change-template" type="button"><?php _e('Select new template');?></button>
            </p>
            <div class="cd-fields">
                <ul>
                    <?php if( $cert_fields = $this->get_certificate_fields() ):?>
                        <?php foreach( $cert_fields as $cert_field ):?>
                            <li data-field="<?php echo $cert_field['variable'] ? $cert_field['variable'] : __('Your text here');?>" data-title="<?php echo esc_attr($cert_field['title']);?>"><h4><?php echo $cert_field['title'];?></h4></li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            <div class="cd-preview">
                <img class="cd-certificate-template" src="{{data.src}}" />
                <ul class="cd-layers">

                </ul>
                <span class="line vert-line"></span>
                <span class="line hori-line"></span>
            </div>
            <input type="hidden" name="_lpr_certificate_template[id]" value="{{data.id}}" />
        </div>
        <?php
        echo '</script>';

        echo '<script type="text/html" id="tmpl-certificate-layer-options">';
        ?>
        <div class="certificate-layer-options">
            <a href="" class="hide-layer-options">&times;</a>
            <ul>
                <li>
                    <label><?php _e('Font family', '');?></label>
                    <select data-prop="font-family" name="_lpr_certificate_template[layers][fontFamily][]">

                        <?php if( $fonts = $this->get_fonts() ): $k = 0; foreach( $fonts as $font ){ ?>
                            <option value="<?php echo $font['name'];?>" <?php selected( $k == 0 ? 1 : 0 ); $k++;?>><?php echo $font['name'];?></option>
                        <?php } endif; ?>
                    </select>

                </li>
                <li>
                    <label><?php _e('Font size', '');?></label>
                    <select data-prop="font-size" name="_lpr_certificate_template[layers][fontSize][]">
                        <?php for( $i = 10; $i < 128; $i++ ){?>
                            <option value="<?php echo $i;?>px"><?php echo $i;?>px</option>
                        <?php }?>
                    </select>
                </li>
                <li>
                    <label><?php _e('Color', '');?></label>
                    <input data-prop="color" class="lpr-colorpicker" type="text" value="{{data.color}}" name="_lpr_certificate_template[layers][color][]" />
                </li>
                <li>
                    <label><?php _e('Content', '');?></label>
                    <input data-prop="field" type="text" value="" name="_lpr_certificate_template[layers][field][]" />
                </li>
                <li>
                    <label><?php _e('Text align', 'learn_press');?></label>
                    <select data-prop="text_align" name="_lpr_certificate_template[layers][text_align][]">
                        <#
                        var options = {left: '<?php _e( 'Left', 'learn_press' );?>', 'center': '<?php _e( 'Center', 'learn_press' );?>', 'right': '<?php _e( 'Right', 'learn_press' );?>'};
                        _.each( options, function(text, value){
                            var selected = value == data.text_align ? 'selected="selected"' : '';
                        #>
                        <option value="{{value}}" {{selected}}>{{text}}</option>
                        <#
                        })
                        #>
                    </select>
                </li>
                <#
                    var cls = '';
                    if( jQuery.inArray( data.field, ['start_date', 'end_date', 'current_date', 'fullname'] ) == -1 ){
                        cls = 'class=hide-if-js';
                    }
                #>
                <li {{cls}}>
                    <label><?php _e('Format', '');?></label>
                    <input data-prop="format" type="text" value="{{data.format}}" name="_lpr_certificate_template[layers][format][]" />
                </li>

            </ul>
            <input type="hidden" name="_lpr_certificate_template[layers][offset][]" value="{{data.offset.left}}:{{data.offset.top}}">
        </div>
        <?php
        echo '</script>';

        echo '<script type="text/html" id="tmpl-certificate-layer-template">';
        ?>
        <li class="certificate-designer-layer">
            <img src="{{data.src}}" />
            <span class="cd-remove-layer">&times;</span>
        </li>
        <?php
        echo '</script>';

    }

    /**
     * Add meta box
     */
    function add_meta_box(){
        add_meta_box(
            'lpr_certificate_template',
            __( 'Certificate Template', 'learn_press' ),
            array( $this, 'meta_box_content' ),
            LPR_CERTIFICATE_CPT
        );
    }

    /**
     * Show Certificate UI designer
     */
    private function _certificate_ui( ){

    ?>
    <div id="lpr_certificate_template_holder"></div>
    <script type="text/javascript">
        jQuery(function($){
            var $el = $( wp.template( 'certificate-template-designer' )(<?php echo json_encode( $this->certificate);?>) );
            $('#lpr_certificate_template_holder').replaceWith( $el );
            $el.certificateDesigner(<?php echo json_encode( $this->certificate);?>);
        });
    </script>
    <?php
    }

    /**
     * Show Upload UI
     */
    private function _upload_ui(){
    ?>
    <button class="button button-primary lpr-upload-certificate" type="button"><?php _e('Select Certificate Template', 'learn_press');?></button>
    <?php
    }

    /**
     * Meta box content
     * 
     * @param  int $post      
     */
    function meta_box_content( $post ){
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'lpr_certificate_template', 'lpr_certificate_template_nonce' );
        if( $this->certificate ) {
            $this->_certificate_ui( );
        }else{
            $this->_upload_ui();
        }
    }

    /**
     * Get certificate fields     
     */
    function get_certificate_fields(){
        $defaults = array(
            'fullname' => array(
                'name'      => 'fullname',
                'title'     => 'Fullname',
                'desc'      => __('The full name of an user'),
                'variable'  => 'fullname',
                'func'      => ''
            ),
            'date_of_birth' => array(
                'name'      => 'date_of_birth',
                'title'     => 'Date of birth',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'date_of_birth',
                'func'      => ''
            ),
            'course_name' => array(
                'name'      => 'course_name',
                'title'     => 'Course name',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'course_name',
                'func'      => ''
            ),
            'start_date' => array(
                'name'      => 'start_date',
                'title'     => 'Start date',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'start_date',
                'func'      => ''
            ),
            'end_date' => array(
                'name'      => 'end_date',
                'title'     => 'End date',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'end_date',
                'func'      => ''
            ),
            'current_date' => array(
                'name'      => 'current_date',
                'title'     => 'Current date',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'current_date',
                'func'      => ''
            ),
            'current_time' => array(
                'name'      => 'current_time',
                'title'     => 'Current time',
                'desc'      => __('The birth of date of an user'),
                'variable'  => 'current_time',
                'func'      => ''
            ),
            'custom' => array(
                'name'      => 'custom',
                'title'     => 'Custom',
                'desc'      => __('The birth of date of an user'),
                'variable'  => '',
                'func'      => ''
            )
        );
        return apply_filters( 'lpr_certificate_fields', $defaults );
    }

    /**
     * Get fonts     
     */
    function get_fonts(){
        $font_path = LPR_Certificate::instance()->get_plugin_path( "assets/fonts/" );
        $fonts = glob( $font_path . '*.ttf');
        $return = array();
        if( $fonts ) foreach( $fonts as $font_file ){
            $path = dirname( $font_file );
            $basename = basename( $font_file );
            $names = explode('.', $basename);
            $return[$basename] = array(
                'basename'  => $basename,
                'path'      => $path,
                'url'       => RWMB_URL . 'js/certificate/fonts/',
                'name'      => @reset( $names ),
                'file'      => $font_file
            );
        }
        return apply_filters( 'lpr_certificate_fonts', $return );
    }

    /**
     * ajax image text     
     */
    function ajax_image_text(){

        $font = $_GET['f'];
        $size = intval($_GET['s']);
        $color = $_GET['c'];
        $text = $_GET['t'];
        $font = $this->get_font( $font );
        $text = $this->get_field_val($text);
        $bbox = imagettfbbox( $size, 0, $font, $text);
        $width  = $bbox[2] - $bbox[6];
        $height = $bbox[3] - $bbox[7];
        $dx = 20 * $_GET['r'];
        $im    = imagecreatetruecolor($width + $dx, $height);
        imagesavealpha($im, true);
        $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $trans);
        $color = $this->hex_to_color( $im, $color );
        header("Content-type: image/png");
        $x = -$bbox[0];
        $y = -$bbox[7];
        if( file_exists( $font ) ) {
            imagefttext($im, $size, 0, $x + $dx, $y, $color, $font, $text);
        }else{

        }
        imagepng($im);
        imagedestroy($im);
        die();
    }

    /**
     * Certificate     
     */
    function certificate(){
        global $wp_query;
        $course_id      = isset( $_GET['course_id'] ) ? intval( $_GET['course_id'] ) : 0;
        $user_id        = isset( $_GET['uid'] ) ? intval( $_GET['uid'] ) : 0;
        $format         = isset( $_GET['format'] ) ? $_GET['format'] : null;
        $download       = isset( $_GET['download'] ) ? $_GET['download'] : false;
        $width          = isset( $_GET['width'] ) ? $_GET['width'] : 0;

        if( ! learn_press_user_has_finished_course( $course_id, $user_id ) ){
            wp_die( __( 'Certificate is not available', 'learn_press' ) );
        }
        // TODO: Should check here to ensure an user is completed a course
        // if user IS NOT completed a course then do nothing or give out a warning

        if( !$course_id ){
            wp_die( __( 'Course is empty' ) );
        }
        $certificate_id = get_post_meta( $course_id, '_lpr_course_certificate', true );
        if( !$certificate_id ){
            wp_die( __( 'Certificate is empty' ) );
        }        
        $certificate = get_post_meta( $certificate_id, '_lpr_certificate_template', true );
       
        $certificate = array_merge(
            $certificate, array(
                'course_id'         => $course_id,
                'user_id'           => $user_id,
                'certificate_id'    => $certificate_id
            )
        );


        if( $format == 'pdf' ){
         }
        $output_file = $this->output_certificate( $certificate );

        if( $output_file /*= $certificate['output_file']*/ ){
            $ext = strtolower( @end( $__x = explode( '.', $output_file ) ) );
            if( $format == 'pdf' ) {
                //require_once(dirname(__FILE__) . '/certificate/fpdf17/fpdf.php');
                require_once( LPR_Certificate::instance()->get_plugin_path( 'incs/tcpdf/tcpdf.php' ) );
                $name = basename($output_file);
                $__x = explode('.', $name);
                $name = @reset($__x) . '.pdf';
                $pdf = new TCPDF('l');

                $pdf->AddPage();
                $pdf->Image($output_file, 0, 0, 800, 600, strtoupper( $ext ), '', 'M', false, 300, '', false, false, 0, 'C M', false, false);
                $pdf->Output($name, $download ? 'd' : 'i');
            }else{
            	if( empty( $_REQUEST['debug'] ) ){
                    switch( $ext ) {
                        case 'png':
                            header('Content-Type: image/png');
                            break;
                        case 'jpg':
                            header('Content-Type: image/jpeg');
                            break;
                        default:
                            wp_die( __( 'Image type doesn\'t support' ) );
                    }
                }

                if( $download ) {
                    header('Content-Disposition: attachment; filename="'.basename($output_file).'"');
                }
                if( $width ){
                    list( $w, $h ) = getimagesize( $output_file );
                    $height = $h * ( $width / $w );

                    $thumb = imagecreatetruecolor( $width, $height );
                    if( $ext == 'jpg' ) {
                        $source = imagecreatefromjpeg( $output_file );
                    }else{
                        $source = imagecreatefrompng( $output_file );
                    }
                    imagecopyresampled( $thumb, $source, 0, 0, 0, 0, $width, $height, $w, $h);
                    if( $ext == 'jpg' ) {
                        imagejpeg($thumb, null, 100);
                    }else{
                        imagepng($thumb);
                    }
                }else {
                    readfile($output_file);
                }
            }
        }
        die();
    }

    /**
     * Get default certificate path
     * 
     * @param  string $sub
     * @return string
     */
    function get_default_path( $sub = null ){
    	$upload = wp_upload_dir();
        $path = $upload['basedir'] . '/tmp' . ( $sub ? '/' . $sub : '');
        $path = apply_filters( 'lpr_certificate_output_path', $path );
        if( !file_exists( $path ) ){
            @mkdir( $path, 0777, true );
            if( file_exists( $path ) ){
                file_put_contents( $path . '/index.html', '' );
            }
        }
        return $path;
    }

    /**
     * Generate certificate
     *          
     * @param  mixed $args
     * @return boolean
     */
    function generate_certificate( $args = null ){
        $template       = null;
        $layers         = null;
        $path           = null;
        $width          = null;
        $height         = null;

        list( $width, $height ) = @getimagesize( $template );
        is_array( $args ) && extract( $args );

        $type           = strtolower( @end( $__x = explode( '.', $template ) ) );

        switch( $type ) {
            case 'png':
                $im = imagecreatefrompng ( $template );
                break;
            case 'jpg':
                $im = imagecreatefromjpeg ( $template );
                break;
            default:
                
                wp_die( __( 'Image type ' . $type . ' doesn\'t support or template ' . $template . ' is not exists' ) );
        }
        if( is_array( $layers ) ) foreach($layers as $layer ){
            if (file_exists($layer['font_name'])) {
                $color = $this->hex_to_color( $im, $layer['color'] );
                $bbox = imagettfbbox( $layer['font_size'], 0, $layer['font_name'], $layer['text']);

                imagettftext($im, $layer['font_size'], 0, $layer['x'] + 20, $layer['y'] - $bbox[7], $color, $layer['font_name'], $layer['text']);
            }else{
                imagestring($im, 1, $layer['x'], $layer['y'], $layer['text'], $color);
            }
        }

        if( !$path ){
            $path = $this->get_default_path() . '/' . basename( $template );
        }
        switch( $type ) {
            case 'png':
                imagepng ( $im, $path );
                break;
            case 'jpg':
                imagejpeg ( $im, $path );
                break;
		}
        
        imagedestroy( $im );

        return file_exists( $path ) ? $path : false;
    }

    /**
     * Hex to color
     * 
     * @param  string $im  
     * @param  int $hex
     * @return int
     */
    function hex_to_color( $im, $hex ){
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $color = imagecolorallocate($im, $r, $g, $b);
        return $color;
    }

    /**
     * Get font
     * 
     * @param  string $name 
     * @param  string $type
     * @return string
     */
    function get_font( $name, $type = 'ttf' ){
        $return = LPR_Certificate::instance()->get_plugin_path( "assets/fonts/{$name}.{$type}" );
        if( ! $name || ! file_exists( $return ) ){
            $fonts = $this->get_fonts();
            $font = reset( $fonts );
            $return = $font['file'];
        }
        //echo $return;die();
        return $return;
    }

    /**
     * Output certificate
     * 
     * @param  string &$certificate
     * @return string
     */
    function output_certificate( &$certificate ){

        $src            = null;
        $dimension      = array(800, 600);
        $save_path      = null;
        $layers         = null;
        $input_type     = null;
        $output_type    = null;
        $quality        = '80';

        $course_id      = null;
        $user_id        = null;
        $certificate_id = null;

        // overidde defaults var
        is_array( $certificate ) && extract( $certificate );

        $img_info = false;
        if( !is_array( $dimension ) ){
            $img_info = @getimagesize( $src );
            if( $img_info ){
                $dimension = array( $img_info[0], $img_info[1] );
            }
        }
        if( !$img_info ){
            $img_info = @getimagesize( $src );
        }
        $input_type = strtolower( @end( $__x = explode('.', $src) ) );

        if( !$output_type ) $output_type = $input_type;
        $args = array(
            'template'       => $src,
            'layers'        => array(),
            'path'          => null
        );

        if( $layers ) foreach( $layers as $layer ){

            $words = preg_split('!\s!', $layer['field']);
            $text = array();
            foreach( $words as $word ){
                $text[] = apply_filters( 'lpr_get_certificate_field', $this->get_field_val( $word, $layer, $certificate ), $word );
            }
            $text = join(' ', $text);

            $font = $this->get_font( $layer['fontFamily'] );

            $x = $layer['offset']['left'];
            $y = $layer['offset']['top'];
            $font_size = intval( $layer['fontSize'] );// * 0.88;

            $args['layers'][] = array(
                'text'          => $text,
                'font_size'     => $font_size,
                'font_name'     => $font,
                'color'         => $layer['color'],
                'x'             => $x,
                'y'             => $y,
                'text_align'    => $layer['text_align']
            );
		}
	
        if( !$save_path ) $save_path = $this->get_default_path();
        $save_path .= "/certificate_{$course_id}_{$user_id}_{$certificate_id}.{$output_type}";
        $certificate['output_file'] = $save_path;
        $args['path']   = $save_path;
        return $this->generate_certificate( $args );
    }

    /**
     * Get field value
     * 
     * @param  string $field
     * @param   array
     * @param  string $certificate
     * @return string
     */
    function get_field_val( $field, $layer = null, $certificate = null ){

        $fields = $this->get_certificate_fields();
        $f = false;
        if( $fields ) foreach( $fields as $f ){
            if( $field == $f['variable'] || $field == $f['name'] ){
                break;
            }
            $f = false;
        }
        $return = $field;
        $user 	= get_userdata( isset( $certificate['user_id'] ) ? $certificate['user_id'] : 0 );
        $course = get_post( $certificate['course_id'] );

        if( $f ) switch( $f['variable'] ){
            case 'fullname':
                if( $layer && ! empty( $layer['format'] ) && $user ) {
                    $search = array(
                        '!\{firstname\}!',
                        '!\{lastname\}!'
                    );
                    $replace = array(
                        $user->first_name,
                        $user->last_name
                    );
                    $return = preg_replace( $search, $replace, $layer['format'] );
                }else {
                    $return = $user ? $user->last_name . ' ' . $user->first_name : $return;
                }
                break;
            case 'date_of_birth':
            	break;
            case 'course_name':                
                if( $course ) $return = $course->post_title;
                break;
            case 'start_date':
            	if( $course ) {
                    $course_time = get_user_meta( $user->ID, '_lpr_course_time', true );
                    if( $course_time && ! empty( $course_time[ $course->ID ] ) ){
                        if( $layer && ! empty( $layer['format'] ) ){
                            $format = $layer['format'];
                        }else{
                            $format = 'm.d.Y';
                        }
                        $return = date( $format, $course_time[ $course->ID ]['start'] );
                    }
                }else{

                }

                break;
            case 'end_date':
                if( $course ) {
                    $course_time = get_user_meta( $user->ID, '_lpr_course_time', true );

                    if( $course_time && ! empty( $course_time[ $course->ID ] ) ){
                        if( $layer && ! empty( $layer['format'] ) ){
                            $format = $layer['format'];
                        }else{
                            $format = 'm.d.Y';
                        }
                        $return = date( $format, $course_time[ $course->ID ]['end'] );
                    }
                }else{
                }
                break;
            case 'current_date':
            	$return = date( 'Y-m-d' );
            	break;
           	case 'current_time':
           		$return = date( 'h:i' );
           		break;
            default:

        }

        if( $f && is_callable( $f['func'] ) ){
            $return = call_user_func_array($f['func'], array($f['variable'], $certificate));
        }

        $field_name = $f && isset( $f['name'] ) ? $f['name'] : $field;
        $return = apply_filters( 'certificate_get_field', $return, $field, $certificate );
        $return = apply_filters( 'certificate_get_field_' . $field_name, $return, $certificate );

        return $return;
    }
}

new LPR_Certificate_Template();

/**
 * Update default field
 * 
 * @param  string $field 
 * @param  string $val
 * @return string
 */
function lpr_default_field_to_update( $field, $val ){
    return strtoupper($val);
}

