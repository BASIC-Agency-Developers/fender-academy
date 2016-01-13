<?php

/**
 * Class LPR_Certificate_Frontend
 */
class LPR_Certificate_Frontend{
    /**
     * Constructor
     */
    function __construct(){
        $this->includes();
        add_action( 'init', array( $this, 'certificate_add_rewrite_tag' ), 1000 );
        add_action( 'init', array( $this, 'certificate_add_rewrite_rule' ), 1000 );
        add_action( 'wp', array( $this, 'certificate_output' ), 1001 );
        add_action( 'learn_press_user_finished_course', array( $this, 'user_finished_course_cookie' ), 10, 2);
        add_action( 'wp_head', array( $this, 'certificate_popout' ), 99999);
        add_action( 'wp_enqueue_scripts', array( $this, 'certificate_script' ) );
        add_action( 'learn_press_after_passed_course_content', array( $this, 'user_profile_certificate' ), 10 );
    }

    /**
     * Include common files
     */
    function includes(){
        require_once( LPR_CERTIFICATE_PATH . '/incs/class-lpr-certificate-helper.php' );
        require_once( LPR_CERTIFICATE_PATH . '/incs/class-lpr-certificate-field.php' );
    }

    /**
     * Rewrite tag
     */
    function certificate_add_rewrite_tag() {
        add_rewrite_tag('%certificate%', '([^&]+)');
        add_rewrite_tag('%download%', '([^&]+)');
        add_rewrite_tag('%pdf%', '([^&]+)');
    }

    /**
     * Add rewrite rule
     */
    function certificate_add_rewrite_rule() {
        add_rewrite_rule('^certificate/([0-9]+)/([0-9]+)/?(download)?/?', 'index.php?certificate=$matches[1]|$matches[2]&download=$matches[3]', 'top');
    }

    /**
     * Certificate output
     */
    function certificate_output(){
        global $wp_query;
        if( ! empty( $wp_query->query_vars['certificate'] ) ){
            $certificate = explode('|', $wp_query->query_vars['certificate']);
            require_once( LPR_CERTIFICATE_PATH . '/incs/tcpdf/tcpdf.php' );
            $_GET['course_id']  = $certificate[0];
            $_GET['uid']        = $certificate[1];

            $cert_data = LPR_Certificate_Helper::get_cert_data( $_GET['uid'], $_GET['course_id'] );
            if( ! empty( $wp_query->query_vars['download'] ) ) $_GET['download'] = $wp_query->query_vars['download'];
            $pdf = new TCPDF('l');
            $pdf->AddPage();

            if( $cert_data['layers'] && $layers = $cert_data['layers'] ) foreach ( $layers as $object ) {
                $pdf->StartTransform();
                $left   = $object->left - ( $object->width / 2 );
                $top    = $object->top - ( $object->height / 2 );
                switch ( $object->type ) {
                    case 'text':
                        //$align = $pdf->setAlign( $object->textAlign );
                        //$style = $pdf->setStyle( $object->fontStyle );
                        //$newColor = $this->hex2RGB( $object->fill );
                        $newColor = array('red' => '255', 'green' => '0', 'blue' => 0);
                        $pdf->setXY( $left, $top );
                        //$pdf->SetFont( "times", $style, $object->fontSize );
                        $pdf->SetTextColor( $newColor['red'], $newColor['green'], $newColor['blue'] );
                        $pdf->MultiCell( 0, $object->height, $object->text, 0, 'J', false, 1, '', '', true, 0, false, true, 0, 'T', false );
                        break;
                    case 'image':
                        $pdf->setXY( $left, $top );
                        $pdf->Rotate( 360 - $object->angle );
                        $pdf->Image( $object->src, $object->left, $object->top, $object->width, $object->height, '', '', '', false, 300, '', false, false, 0 );
                        break;
                    default:
                        break;
                }
                $pdf->StopTransform();
            }
            $pdf->Close();
            $pdf->Output( 'xxx.pdf', 'd' );
            die();
        }
    }

    /**
     * Certificate Url
     *
     * @param  int $course_id
     * @param  int $user_id
     * @param  array  $args
     * @return string
     */
    function certificate_url( $course_id, $user_id, $args = array() ){
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
    function certificate_download_url( $course_id, $user_id, $format = '' ){
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
    function user_finished_course_cookie( $course_id, $user_id ){

        if( $cert_id = get_post_meta( $course_id, '_lpr_course_certificate', true ) ) {
            set_transient('learn_press_user_finished_course_' . $user_id, $course_id);
        }
    }

    /**
     * Certificate popout
     */
    function certificate_popout(){

        $user_id = get_current_user_id();
        $course_id = get_transient( 'learn_press_user_finished_course_' . $user_id );

        if( ! $course_id ) return;
        if( ! learn_press_user_has_passed_course( $course_id, $user_id ) ) return;
        $cert_data = LPR_Certificate_Helper::get_cert_data( $user_id, $course_id );

        $this->certificate_script();
        ?>
        <div class="user-certificate" id="<?php echo get_post_field('post_name', $course_id);?>">
            <p class="cert-description"><?php _e( 'Congratulations! You have passed this course and get a certificate from us.', 'learn_press' );?></p>
            <canvas class="cert-canvas">

            </canvas>
            <p class="cert-actions">
                <?php _e( 'Download certificate as: ', 'learn_press' );?>
                <a class="cert-download-png" href="#download-png" data-name="<?php echo $cert_data['cert_name'];?>">PNG</a> |
                <a class="cert-download-svg" href="#download-svg" data-name="<?php echo $cert_data['cert_name'];?>">SVG</a>
                <!-- <a href="<?php echo $this->certificate_download_url( $course_id, $user_id, 'pdf' );?>">PDF</a>-->
                <a href="" class="close"><?php _e( 'Close', 'learn_press' );?></a>
            </p>
        </div>
        <script type="text/javascript">
            <?php if( $used_fonts = LPR_Certificate_Helper::get_google_fonts_from_data( $cert_data ) ):?>
                WebFont.load({
                    google: {
                        families: <?php echo json_encode( $used_fonts );?>
                    },
                    active: function(a, b) {
                        if( window.certificates ){
                            $.each( window.certificates, function(){
                                this.renderAll();
                            });
                        }
                    }
                });
            <?php endif;?>
            jQuery(function($){
                showCert( $('#<?php echo get_post_field('post_name', $course_id);?>'), <?php echo json_encode( $cert_data );?> )
            })
        </script>
        <?php
        delete_transient( 'learn_press_user_finished_course_' . $user_id );
        ?>
    <?php
    }

    /**
     * Display Certificate link in user profile
     */
    function user_profile_certificate(){
        global $post;
        if( $post ){
            $course_id = $post->ID;
        }else{
            $course_id = 0;
        }
        $user_id = get_current_user_id();
        if( learn_press_user_has_passed_course( $course_id, $user_id ) ){
            $cert = get_post_meta( $course_id, '_lpr_course_certificate', true );
            if( ! $cert ) return;
            $cert_data = LPR_Certificate_Helper::get_cert_data( $user_id, $course_id );
            ?>
            <div class="user-certificate" id="<?php echo get_post_field('post_name', $course_id);?>">
                <p class="cert-description"><?php _e( 'Congratulations! You have passed this course and get a certificate from us.', 'learn_press' );?></p>
                <canvas class="cert-canvas">

                </canvas>
                <p class="cert-actions">
                    <?php _e( 'Download certificate as: ', 'learn_press' );?>
                    <a class="cert-download-png" href="#download-png" data-name="<?php echo $cert_data['cert_name'];?>">PNG</a> |
                    <a class="cert-download-svg" href="#download-svg" data-name="<?php echo $cert_data['cert_name'];?>">SVG</a>
                    <!-- <a href="<?php echo $this->certificate_download_url( $course_id, $user_id, 'pdf' );?>">PDF</a>-->
                    <a href="" class="close"><?php _e( 'Close', 'learn_press' );?></a>
                </p>
            </div>
            <script type="text/javascript">
                jQuery(function ($) {
                    <?php if( $used_fonts = LPR_Certificate_Helper::get_google_fonts_from_data( $cert_data ) ):?>
                    WebFont.load({
                        google: {
                            families: <?php echo json_encode( $used_fonts );?>
                        },
                        active: function(a, b) {
                            if( window.certificates ){
                                $.each( window.certificates, function(){
                                    this.renderAll();
                                });
                            }
                        }
                    });
                    <?php endif;?>
                    $('.cert-profile-view').click(function(e){
                        e.preventDefault();
                        showCert( $('#<?php echo get_post_field('post_name', $course_id);?>'), <?php echo json_encode( $cert_data );?>);
                    });

                })
            </script>
            <a href="#" class="cert-profile-view" data-id="<?php echo $course_id;?>" data-user="<?php echo $user_id;?>"><?php _e( 'Your Certificate', 'lpr_certificate');?></a>
        <?php
        }
    }

    /**
     * Certificate script
     */
    function certificate_script(){

        LPR_Assets::enqueue_script( 'learnpress-block-ui', LPR_PLUGIN_URL . '/assets/js/jquery.block-ui.js' );
        wp_enqueue_script( 'webfont', '//ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js' );
        wp_enqueue_script( 'fabric-js', plugins_url( '/assets/js/fabric.js', LPR_CERTIFICATE_FILE ) );
        wp_enqueue_script( 'certificate',  plugins_url( '/assets/js/frontend-certificate.js', LPR_CERTIFICATE_FILE ), array( 'jquery') );
        wp_enqueue_style( 'certificate',  plugins_url( '/assets/css/frontend-certificate.css', LPR_CERTIFICATE_FILE ) );
    }

}