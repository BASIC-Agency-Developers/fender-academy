<?php
/**
 * Register hook LearnPress for instructor
 *
 * @param $installed
 *
 * @return mixed
 */
function learn_press_register_hook_mycred_instructor( $installed ) {
	$installed['learnpress_instructor'] = array(
		'title'       => __( 'LearnPress: for instructors', 'learn_press_mycred' ),
		'description' => __( 'Award %_plural% to users who are teaching in LearnPress courses system.', 'learn_press_mycred' ),
		'callback'    => array( 'myCred_LearnPress_Instructor' )
	);
	return $installed;
}

add_filter( 'mycred_setup_hooks', 'learn_press_register_hook_mycred_instructor' );


/**
 * Class myCred_LearnPress_Instructor
 */
class myCred_LearnPress_Instructor extends myCRED_Hook {

	/**
	 * Construct
	 */
	function __construct( $hook_prefs, $type = 'mycred_default' ) {
		$defaults = array(
			'course_50'  => array(
				'creds' => 5,
				'log'   => '%plural%' . ' ' . __( 'for having a course with more than 50 learners', 'learn_press_mycred' ),
			),
			'course_100' => array(
				'creds' => 10,
				'log'   => '%plural%' . ' ' . __( 'for having a course with more than 100 learners', 'learn_press_mycred' ),
			),
			'course_200' => array(
				'creds' => 20,
				'log'   => '%plural%' . ' ' . __( 'for having a course with more than 200 learners', 'learn_press_mycred' ),
			),
			'course_500' => array(
				'creds' => 100,
				'log'   => '%plural%' . ' ' . __( 'for having a course with more than 500 learners', 'learn_press_mycred' ),
			),

		);

		parent::__construct(
			array(
				'id'       => 'learnpress_instructor',
				'defaults' => $defaults
			),
			$hook_prefs,
			$type
		);
	}

	/**
	 * Hook into WordPress
	 */
	public function run() {

		// Action take a course
		add_action( 'learn_press_update_order_status', array( $this, 'check_course' ), 10, 2 );

	}

	/**
	 * Check number of students in a course
	 *
	 * @param $status
	 * @param $order_id
	 */
	public function check_course( $status, $order_id ) {
		$course = learn_press_get_course_info( $order_id );

		// Check if course is invalid
		if ( !$course || !isset( $course['id'] ) || !isset( $course['instructor'] ) ) {
			return;
		}

		// Check if user is excluded
		if ( $this->core->exclude_user( $course['instructor'] ) ) {
			return;
		}

		$learners = get_post_meta( $course['id'], '_lpr_course_user', true ) ? get_post_meta( $course['id'], '_lpr_course_user', true ) : 0;

		// Check if course has no learners
		if ( !$learners ) {
			return;
		}
		switch ( count( $learners ) ) {
			case 50:
				$course_type = 'course_50';
				break;
			case 100:
				$course_type = 'course_100';
				break;
			case 200:
				$course_type = 'course_200';
				break;
			case 500:
				$course_type = 'course_500';
				break;
			default:
				return;
		}

		// Make sure we award points other then zero
		if ( !isset( $this->prefs[$course_type]['creds'] ) ) {
			return;
		}
		if ( empty( $this->prefs[$course_type]['creds'] ) || $this->prefs[$course_type]['creds'] == 0 ) {
			return;
		}

		// Execute
		$this->core->add_creds(
			'learnpress_instructor',
			$course['instructor'],
			$this->prefs[$course_type]['creds'],
			$this->prefs[$course_type]['log'],
			$course['id'],
			array( 'ref_type' => 'post' ),
			$this->mycred_type
		);
	}

	/**
	 * Add Settings
	 */
	public function preferences() {
		// Our settings are available under $this->prefs
		$prefs = $this->prefs; ?>

		<label for="<?php echo $this->field_id( array( 'course_50' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for having course with more than 50 learners', 'learn_press_mycred' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_50' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'course_50' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['course_50']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'course_50' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press_mycred' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_50' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'course_50' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['course_50']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>

		<label for="<?php echo $this->field_id( array( 'course_100' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for having course with more than 100 learners', 'learn_press_mycred' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_100' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'course_100' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['course_100']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'course_100' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press_mycred' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_100' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'course_100' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['course_100']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>

		<label for="<?php echo $this->field_id( array( 'course_200' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for having course with more than 200 learners', 'learn_press_mycred' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_200' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'course_200' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['course_200']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'course_200' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press_mycred' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_200' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'course_200' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['course_200']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>

		<label for="<?php echo $this->field_id( array( 'course_500' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for having course with more than 500 learners', 'learn_press_mycred' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_500' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'course_500' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['course_500']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'course_500' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press_mycred' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'course_500' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'course_500' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['course_500']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>

		<?php
	}

	/**
	 * Sanitize Preferences
	 */
	public function sanitise_preferences( $data ) {
		return $data;
	}
}

