<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LPR_Certificate_Meta_Box_Field' ) && class_exists( 'RWMB_Field' ) ) {
    class LPR_Certificate_Meta_Box_Field extends RWMB_Field {
        static $font_faces = array();
        static function admin_enqueue_scripts(){
            //wp_enqueue_style( 'rwmb-certificate-css', LPR_Certificate::instance()->get_plugin_url( 'assets/css/certificate.css' ) );
            //wp_enqueue_script( 'rwmb-certificate-script', LPR_Certificate::instance()->get_plugin_url( 'assets/js/certificate.js' ), array('jquery', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-draggable') );
        }

        /**
         * Get certificate
         */
        static function get_certificates(){
            $args = array(
                'post_type'         => LPR_CERTIFICATE_CPT,
                'posts_per_page'    => -1
            );
            $certificates = array();

            if( $posts = get_posts( $args ) ) foreach( $posts as $post ){
                $post->preview = get_post_meta( $post->ID, '_lpr_certificate_preview', true );
                $certificates[] = $post;
            }
            return $certificates;
        }

        /**
         * Output html
         *
         * @param  mixed $meta
         * @param  string $field
         * @return string
         */
        static function html( $meta, $field ) {
            ob_start();
            ?>
            <div id="lpr-certificate-gallery-block">

            </div>
            <div id="lpr-certificate-gallery">
                <div class="lpr-cg-right">
                    <button class="button button-primary lpr-select-certificate-template" type="button"><?php _e( 'Select' );?></button>
                </div>
                <div class="lpr-cg-left">
                    <?php $galleries = self::get_certificates();?>
                    <ul>
                        <?php if( $galleries ): foreach( $galleries as $gal ): if( !empty( $gal->preview ) && !empty( $gal->preview['url'] ) ): ?>
                            <li data-id="<?php echo $gal->ID;?>"><img src="<?php echo $gal->preview['url'];?>" /></li>
                        <?php endif; endforeach; endif;?>
                    </ul>
                </div>
            </div>
            <?php $cert = self::get_certificate();?>
            <div id="lpr-certificate-preview" class="<?php echo $cert ? 'has-cert' : '';?>">
                <div class="lpr-cert">
                    <?php if( $cert ):?>
                        <img src="<?php echo $cert['url'];?>" />
                        <input type="hidden" name="_lpr_course_certificate" value="<?php echo $cert['id'];?>" />
                    <?php endif;?>
                </div>
                <span class="lpr-empty-text"><i><?php _e( 'No certificate' );?></i></span>
                <span class="lpr-remove-cert"><i class="dashicons dashicons-trash"></i></span>
                <span class="lpr-select-cert"><i class="dashicons dashicons-plus"></i></span>
            </div>

            <?php
            $output = ob_get_clean();
            return $output;
        }

        /**
         * Get certificate
         */
        static function get_certificate(){
            if( !isset($_GET['post']) ) return;
            $post = get_post( $_GET['post'] );
            $cert_id = get_post_meta( $post->ID, '_lpr_course_certificate', true );

            if( $cert_id ){
                $cert = get_post( $cert_id );
                if( $cert ){
                    $preview = get_post_meta( $cert->ID, '_lpr_certificate_preview', true );
                    if( $preview ) return array_merge( $preview, array( 'id' => $cert->ID) );
                }
            }
            return false;
        }

        /**
         * Add actions
         */
        static function add_actions() {
            // Do same actions as file field
            parent::add_actions();

            add_action( 'save_post', array( __CLASS__, 'save_post' ) );
        }

        /**
         * Save post
         *
         * @param  int $post_id
         */
        static function save_post( $post_id ){
            if( LPR_COURSE_CPT != get_post_type( $post_id ) ) return;
            $certificate_id = isset( $_POST['_lpr_course_certificate'] ) ? $_POST['_lpr_course_certificate'] : 0;
            if( $certificate_id ){
                update_post_meta( $post_id, '_lpr_course_certificate', $certificate_id );
            }else{
                delete_post_meta( $post_id, '_lpr_course_certificate' );
            }

        }

    }
}
