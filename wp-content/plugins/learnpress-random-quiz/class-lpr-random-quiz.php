<?php

/**
 * Class LPR_Random_Quiz
 */
class LPR_Random_Quiz{
    /**
     * Constructor
     */
    function __construct(){
        add_filter( 'learn_press_quiz_question_meta_box_args', array( $this, 'random_quiz_settings' ) );
        add_action( 'admin_footer', array( $this, 'admin_script' ) );
        add_action( 'admin_init', array( $this, 'learn_press_update_quiz_mode' ) );

        add_filter( 'learn_press_get_quiz_questions', array( $this, 'get_quiz_questions' ), 99, 3 );
    }

    /**
     * Get the questions of a quiz
     * @param $questions
     * @param $quiz_id
     * @param $only_ids
     * @return array
     */
    function get_quiz_questions( $questions, $quiz_id, $only_ids ){
        $quiz_mode = get_post_meta( $quiz_id, '_lpr_quiz_mode', true );

        if( $quiz_mode != 'random' ){
            return $questions;
        }

        $quiz_questions = get_user_meta( get_current_user_id(), '_lpr_quiz_questions', true );
        if( /*learn_press_user_has_started_quiz( null, $quiz_id ) && */! empty( $quiz_questions[ $quiz_id ] ) ){
            $return = array();
            foreach( $quiz_questions[ $quiz_id ] as $q ){
                $return[ $q ] = $q;
            };
            return $return;
        }

        $quiz = get_post( $quiz_id );
        $question_ids = array();
        $limit = get_post_meta( $quiz_id, '_lpr_quiz_questions_limit', true );
        if( is_null( $limit ) || $limit == 0 ) $limit = -1;
        $query_args   = array(
            'posts_per_page' => $limit,
            //'include'        => $question_ids,
            'post_type'      => 'lpr_question',
            'post_status'    => 'publish',
            'orderby'       => 'rand'
            //'author'        => $quiz->post_author
        );

        if( $tags = get_post_meta( $quiz_id, '_lpr_quiz_questions_tags' ) ){
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'question-tag',
                    'field' => 'slug',
                    'terms' => $tags
                )
            );
        }
        if ( $only_ids ) {
            //$query_args['fields'] = 'ids';
        }
        $questions = array();
        $my_query = new WP_Query( $query_args );
        if( $my_query->have_posts() ) {
            global $post;
            while ( $my_query->have_posts() ) : $my_query->the_post();
                $questions[$post->ID] = $only_ids ? $post->ID : $post;
            endwhile;
        }
        wp_reset_query();
        $quiz_questions[ $quiz_id ] = $questions;

        update_user_meta( get_current_user_id(), '_lpr_quiz_questions', $quiz_questions );
        return $questions;
    }

    /**
     * Update quiz meta
     */
    function learn_press_update_quiz_mode(){
        if( ! empty( $_REQUEST['post'] ) && $post_id = $_REQUEST['post'] ) {
            if ( get_post_type( $post_id ) == 'lpr_quiz' && ! empty( $_REQUEST['mode'] ) && $mode = $_REQUEST['mode'] ) {
                if( in_array( $mode, array( 'random', 'manual' ) ) ) {
                    update_post_meta( $post_id, '_lpr_quiz_mode', $mode );
                    $redirect = admin_url('post.php?post=' . $post_id . '&action=edit');
                    wp_redirect($redirect);
                    exit();
                }
            }
        }
    }

    /**
     * Add fields to metabox settings
     *
     * @param array $metabox
     * @return mixed
     */
    function random_quiz_settings( $metabox ){
        $new_settings = array(
            array(
                'name' => __( 'Limit', 'learn_press' ),
                'desc' => __( 'The number of questions for quiz each time the quiz is generated. Set 0 select all', 'learn_press' ),
                'id'   => "_lpr_quiz_questions_limit",
                'type' => 'number',
                'min'  => 0,
                'max'  => 99999,
                'std'  => 10
            ),
            array(
                'name' => __( 'Tags', 'learn_press' ),
                'desc' => __( '', 'learn_press' ),
                'id'   => "_lpr_quiz_questions_tags",
                'type' => 'select_advanced',
                'multiple' => true,
                'desc' => __( 'Filter by question tags', 'learn_press' ),
                'options' => array()
            )
        );
        $tag_taxonomy = get_categories('taxonomy=question-tag&orderby=name');
        if( $tag_taxonomy ){
            foreach( $tag_taxonomy as $tag ){
                $new_settings[1]['options'][ $tag->slug ] = $tag->slug;
            }
        }
        if( ! empty( $_REQUEST['post'] ) && $post_id = $_REQUEST['post'] ){
            $quiz_mode = get_post_meta( $post_id, '_lpr_quiz_mode', true );
            if( $quiz_mode != 'random' ){
                //new RWMB_Quiz_Question_Field();
                foreach( $new_settings as $k => $new_one ) {
                    $new_settings[ $k ]['class'] = 'hide-if-js';
                }
            }else{
                if( ! empty( $metabox['fields'] ) ){
                    foreach( $metabox['fields'] as $k => $field ){
                        if( empty( $field['class'] ) ){
                            $field['class'] = 'hide-if-js';
                        }else{
                            $field['class'] .= ' hide-if-js';
                        }
                        $metabox['fields'][ $k ] = $field;
                    }
                }
            }
        }
        $metabox['fields'] = array_merge( $metabox['fields'], $new_settings );
        return $metabox;
    }

    /**
     *
     */
    function admin_script(){
        $post_id = 0;
        if( ! empty( $_REQUEST['post'] ) ){
            $post_id = $_REQUEST['post'];
        }
        if( ! $post_id ) return;
        $quiz_mode = get_post_meta($post_id, '_lpr_quiz_mode', true);
        if (!$quiz_mode || !in_array($quiz_mode, array('manual', 'random'))) {
            $quiz_mode = 'manual';
        }
        $edit_link = get_edit_post_link($post_id) . '&mode=';
        ?>

        <?php if ($quiz_mode == 'manual') { ?>
            <a id="lpr-toggle-quiz-mode" class="hide-if-js" href="<?php echo $edit_link; ?>random"
               data-mode="<?php echo $quiz_mode; ?>"><?php _e('Current Mode: Manual', 'learn_press'); ?></a>
        <?php } else { ?>
            <a id="lpr-toggle-quiz-mode" class="hide-if-js" href="<?php echo $edit_link; ?>manual"
               data-mode="<?php echo $quiz_mode; ?>"><?php _e('Current Mode: Random', 'learn_press'); ?></a>
        <?php }?>
        <script type="application/javascript">
            jQuery(function($){
                var toggle_quiz_mode = $('#lpr-toggle-quiz-mode');
                toggle_quiz_mode.appendTo( $('#questions .hndle') ).removeClass('hide-if-js');
                toggle_quiz_mode.click(function(evt){
                    if( ! confirm( '<?php printf( __( 'Are you sure to switch to %s mode?', 'learn_press' ), $quiz_mode == 'manual' ? 'random' : 'manual' );?>' ) ){
                        evt.preventDefault();
                        return;
                    }
                });
            })
        </script>
        <?php
    }
}
//
new LPR_Random_Quiz();