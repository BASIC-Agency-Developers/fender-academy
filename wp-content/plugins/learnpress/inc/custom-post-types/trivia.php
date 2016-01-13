<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('LPR_Trivia_Post_Type')) {

    // class LPR_Course_Post_Type
    final class LPR_Trivia_Post_Type {

        protected static $loaded;

        function __construct() {
            if (self::$loaded)
                return;

            add_action('init', array($this, 'register_post_type'));

            add_action('admin_head', array($this, 'enqueue_script'));
            add_action('admin_init', array($this, 'add_meta_boxes'), 0);
            add_action('rwmb_trivia_curriculum_before_save_post', array($this, 'before_save_curriculum'));

            add_filter('manage_lpr_trivia_posts_columns', array($this, 'columns_head'));

            add_filter("rwmb__lpr_trivia_price_html", array($this, 'currency_symbol'), 5, 3);

            self::$loaded = true;
        }

        function currency_symbol($input_html, $field, $sub_meta) {
            return $input_html . '<span class="lpr-trivia-price-symbol">' . learn_press_get_currency_symbol() . '</span>';
        }

        /**
         * Register course post type
         */
        function register_post_type() {
            $labels = array(
                'name' => _x('Trivia', 'Post Type General Name', 'learn_press'),
                'singular_name' => _x('Trivia', 'Post Type Singular Name', 'learn_press'),
                'menu_name' => __('Trivia', 'learn_press'),
                'parent_item_colon' => __('Parent Item:', 'learn_press'),
                'all_items' => __('Trivia', 'learn_press'),
                'view_item' => __('View Trivia', 'learn_press'),
                'add_new_item' => __('Add New Trivia', 'learn_press'),
                'add_new' => __('Add New', 'learn_press'),
                'edit_item' => __('Edit Trivia', 'learn_press'),
                'update_item' => __('Update Trivia', 'learn_press'),
                'search_items' => __('Search Trivia', 'learn_press'),
                'not_found' => __('No trivia found', 'learn_press'),
                'not_found_in_trash' => __('No trivia found in Trash', 'learn_press'),
            );


            $args = array(
                'labels' => $labels,
                'public' => true,
                'query_var' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'has_archive' => ( $page_id = learn_press_get_page_id('trivia') ) && get_post($page_id) ? get_page_uri($page_id) : _x('trivia', 'Permalink Slug', 'learn_press'),
                'capability_type' => LPR_TRIVIA_CPT,
                'map_meta_cap' => true,
                'show_in_menu' => 'learn_press',
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'taxonomies' => array('trivia_category', 'trivia_tag'),
                'supports' => array('title', 'editor'),
                'hierarchical' => true,
                'rewrite' => array('slug' => _x('trivia', 'Permalink Slug', 'learn_press'), 'hierarchical' => true, 'with_front' => false)
            );
            register_post_type("lpr_trivia", $args);

            register_taxonomy('trivia_category', array("lpr_trivia"), array(
                'label' => __('Trivia Categories', 'learn_press'),
                'labels' => array(
                    'name' => __('Trivia Categories', 'learn_press'),
                    'menu_name' => __('Category', 'learn_press'),
                    'singular_name' => __('Category', 'learn_press'),
                    'add_new_item' => __('Add New Trivia Category', 'learn_press'),
                    'all_items' => __('All Categories', 'learn_press')
                ),
                'query_var' => true,
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_in_menu' => 'learn_press',
                'show_admin_column' => true,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'rewrite' => array(
                    'slug' => _x('trivia_category', 'Permalink Slug', 'learn_press'),
                    'hierarchical' => true,
                    'with_front' => false
                ),
                    )
            );
            register_taxonomy('trivia_tag', array(LPR_TRIVIA_CPT), array(
                'labels' => array(
                    'name' => __('Trivia Tags', 'learn_press'),
                    'singular_name' => __('Tag', 'learn_press'),
                    'search_items' => __('Search Trivia Tags', 'learn_press'),
                    'popular_items' => __('Popular Trivia Tags', 'learn_press'),
                    'all_items' => __('All Trivia Tags', 'learn_press'),
                    'parent_item' => null,
                    'parent_item_colon' => null,
                    'edit_item' => __('Edit Trivia Tag', 'learn_press'),
                    'update_item' => __('Update Trivia Tag', 'learn_press'),
                    'add_new_item' => __('Add New Trivia Tag', 'learn_press'),
                    'new_item_name' => __('New Trivia Tag Name', 'learn_press'),
                    'separate_items_with_commas' => __('Separate tags with commas', 'learn_press'),
                    'add_or_remove_items' => __('Add or remove tags', 'learn_press'),
                    'choose_from_most_used' => __('Choose from the most used tags', 'learn_press'),
                    'menu_name' => __('Tags', 'learn_press'),
                ),
                'public' => true,
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_menu' => 'learn_press',
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array(
                    'slug' => _x('trivia_tag', 'Permalink Slug', 'learn_press'),
                    'hierarchical' => true,
                    'with_front' => false
                ),
                    )
            );
            if (!is_admin()) {
                LPR_Assets::enqueue_script('tipsy', LPR_PLUGIN_URL . '/assets/js/jquery.tipsy.js');
                LPR_Assets::enqueue_style('tipsy', LPR_PLUGIN_URL . '/assets/css/tipsy.css');
            }
            flush_rewrite_rules();
        }

        /**
         * Add meta boxes to course post type page
         */
        function add_meta_boxes() {

            new RW_Meta_Box($this->curriculum_meta_box());
            //new RW_Meta_Box( $this->settings_meta_box() );
            new RW_Meta_Box($this->assessment_meta_box());

//			new RW_Meta_Box( $this->payment_meta_box() );
        }

        function curriculum_meta_box() {
            $prefix = '_lpr_';

            $meta_box = array(
                'id' => 'trivia_curriculum',
                'title' => __('Trivia Quizzes Section', 'learn_press'),
                'priority' => 'high',
                'pages' => array("lpr_trivia"),
                'fields' => array(
                    array(
                        'name' => __('', 'learn_press'),
                        'id' => "{$prefix}trivia_lesson_quiz",
                        'type' => 'trivia_lesson_quiz',
                        'desc' => '',
                    ),
                )
            );

            return apply_filters('learn_press_trivia_curriculum_meta_box_args', $meta_box);
        }

        function assessment_meta_box() {
            $prefix = '_lpr_';

            $meta_box = array(
                'id' => 'trivia_assessment',
                'title' => __('Trivia Assessment Settings', 'learn_press'),
                'priority' => 'high',
                'pages' => array("lpr_trivia"),
                'fields' => array(
//					array(
//						'name' => __( 'Passing Condition', 'learn_press' ),
//						'id'   => "{$prefix}trivia_condition",
//						'type' => 'number',
//						'min'  => 1,
//						'max'  => 100,
//						'desc' => __('The percentage of quiz result to finish the trivia', 'learn_press'),
//						'std'  => 50
//		
//								),

                    array(
                        'name' => __('IQ Points', 'learn_press'),
                        'id' => "{$prefix}iq_points",
                        'type' => 'number',
                        'desc' => __('The Points awarded if completed', 'learn_press'),
                        'std' => 0
                    )
                )
            );
            return apply_filters('learn_press_trivia_assessment_metabox', $meta_box);
        }

        function before_save_curriculum() {
            if ($sections = $_POST['_lpr_trivia_lesson_quiz'])
                foreach ($sections as $k => $section) {
                    if (empty($section['name'])) {
                        unset($_POST['_lpr_trivia_lesson_quiz'][$k]);
                    }
                    $_POST['_lpr_trivia_lesson_quiz'] = array_values($_POST['_lpr_trivia_lesson_quiz']);
                }
        }

        function enqueue_script() {
            if ('lpr_trivia' != get_post_type())
                return;
            ob_start();
            global $post;
            ?>
            <script>
                window.course_id = <?php echo $post->ID; ?>, form = $('#post');
                form.submit(function (evt) {
                    var $title = $('#title'),
                            $curriculum = $('.lpr-curriculum-section:not(.lpr-empty)'),
                            is_error = false;
                    if (0 == $title.val().length) {
                        alert('<?php _e('Please enter the title of the course', 'learn_press'); ?>');
                        $title.focus();
                        is_error = true;
                    } else if (0 == $curriculum.length) {
                        alert('<?php _e('Please add at least one section for the course', 'learn_press'); ?>');
                        $('.lpr-curriculum-section .lpr-section-name').focus();
                        is_error = true;
                    } else {
                        $curriculum.each(function () {
                            var $section = $('.lpr-section-name', this);
                            if (0 == $section.val().length) {
                                alert('<?php _e('Please enter the title of the section', 'learn_press'); ?>');
                                $section.focus();
                                is_error = true;
                                return false;
                            }
                        });
                    }
                    if ($('input[name="_lpr_course_payment"]:checked').val() == 'not_free' && $('input[name="_lpr_course_price"]').val() <= 0) {
                        alert('<?php _e('Please set a price for this course', 'learn_press'); ?>');
                        is_error = true;
                        $('input[name="_lpr_course_price"]').focus();
                    }
                    if (true == is_error) {
                        evt.preventDefault();
                        return false;
                    }
                });
                $('input[name="_lpr_trivia_final"]').bind('click change', function () {
                    if ($(this).val() == 'yes') {
                        $(this).closest('.rwmb-field').next().show();
                    } else {
                        $(this).closest('.rwmb-field').next().hide();
                    }
                }).filter(":checked").trigger('change')
            </script>
            <?php
            $script = ob_get_clean();
            $script = preg_replace('!</?script>!', '', $script);
            learn_press_enqueue_script($script);
        }

        /**
         * Add columns to admin manage course page
         *
         * @param  array $columns
         *
         * @return array
         */
        function columns_head($columns) {
            $user = wp_get_current_user();
            if (in_array('lpr_teacher', $user->roles)) {
                unset($columns['author']);
            }
            return $columns;
        }

    }

// end LPR_Course_Post_Type
    new LPR_Trivia_Post_Type();
}

add_action('load-post.php', 'selected_trivia_post_meta_boxes_setup');
add_action('load-post-new.php', 'selected_trivia_post_meta_boxes_setup');

function selected_trivia_post_meta_boxes_setup() {

    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action('add_meta_boxes', 'selected_trivia_add_post_meta_boxes');
    add_action('save_post', 'selected_trivia_save_post_class_meta', 10, 2);
}

function selected_trivia_add_post_meta_boxes() {

    add_meta_box(
            'selected_trivia', // Unique ID
            esc_html__('Selected Trivia', 'example'), // Title
            'selected_trivia_post_class_meta_box_html', // Callback function
            array('lpr_trivia'), // Admin page (or post type)
            'side', // Context
            'default'         // Priority
    );
}

function selected_trivia_post_class_meta_box_html($object, $box) {
    wp_nonce_field(basename(__FILE__), 'selected_trivia_post_class_nonce');
    ?>

    <p>
        <label for="st-post-class"><?php _e("This week trivia", 'example'); ?></label>
        <br />
        <input class="widefat" type="checkbox" name="st-post-class" id="st-post-class" <?php  echo $object->ID == get_option('weekly_trivia') ? 'checked = "checked"': '' ?>  size="30" />

    </p>
    <?php

}

function selected_trivia_save_post_class_meta($post_id, $post) {
     if ( !isset( $_POST['selected_trivia_post_class_nonce'] ) || !wp_verify_nonce( $_POST['selected_trivia_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;
    update_option('weekly_trivia', $post_id);
}
