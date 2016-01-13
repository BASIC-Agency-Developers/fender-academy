<?php
/**
 * Register hook LearnPress for learner
 *
 * @param $installed
 *
 * @return mixed
 */
function learn_press_register_hook_mycred_learner( $installed ) {
	$installed['learnpress_learner'] = array(
		'title'       => __( 'LearnPress: for learners', 'learn_press' ),
		'description' => __( 'Award %_plural% to users who are learning in LearnPress courses system.', 'learn_press' ),
		'callback'    => array( 'myCred_LearnPress_Learner' )
	);
	return $installed;
}

add_filter( 'mycred_setup_hooks', 'learn_press_register_hook_mycred_learner' );


/**
 * Class myCred_LearnPress_Learner
 */
class myCred_LearnPress_Learner extends myCRED_Hook {

	/**
	 * Construct
	 */
	function __construct( $hook_prefs, $type = 'mycred_default' ) {
		$defaults = array(
			'take_free_course' => array(
				'creds' => 1,
				'log'   => '%plural%' . ' ' . __( 'for taking a free course', 'learn_press' ),
				'limit' => '1/d',
			),
			'take_paid_course' => array(
				'creds' => 5,
				'log'   => '%plural%' . ' ' . __( 'for taking a paid course', 'learn_press' ),
				'limit' => '1/d',
			),
			'pass_course'      => array(
				'creds' => 5,
				'log'   => '%plural%' . ' ' . __( 'for passing a course', 'learn_press' ),
				'limit' => '1/d',
			),
		);

		parent::__construct(
			array(
				'id'       => 'learnpress_learner',
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
		add_action( 'learn_press_update_order_status', array( $this, 'take_course' ), 10, 2 );

		// Action pass a course
		add_action( 'learn_press_user_finished_course', array( $this, 'pass_course' ), 10, 2 );

	}

	/**
	 * Check if user enroll a course successfully
	 *
	 * @param $status
	 * @param $order_id
	 */
	public function take_course( $status, $order_id ) {
		// Check if order is invalid
		if ( !$order_id ) {
			return;
		}

		$user_id = get_post_meta( $order_id, '_learn_press_customer_id', true ) ? get_post_meta( $order_id, '_learn_press_customer_id', true ) : 0;

		// Check if user is invalid
		if ( !$user_id ) {
			return;
		}

		// Check if user or order is invalid
		if ( $this->core->exclude_user( $user_id ) ) {
			return;
		}

		$take_course = get_post_meta( $order_id, '_learn_press_transaction_method', true ) == 'free' ? 'take_free_course' : 'take_paid_course';

		// Make sure we award points other then zero
		if ( !isset( $this->prefs[$take_course]['creds'] ) ) {
			return;
		}
		if ( empty( $this->prefs[$take_course]['creds'] ) || $this->prefs[$take_course]['creds'] == 0 ) {
			return;
		}

		$course = learn_press_get_course_info( $order_id );

		// Check if course is invalid
		if ( !$course || !isset( $course['id'] ) ) {
			return;
		}

		// Execute
		if ( !$this->over_hook_limit( $take_course, 'learnpress_learner', $user_id ) ) {
			$this->core->add_creds(
				'learnpress_learner',
				$user_id,
				$this->prefs[$take_course]['creds'],
				$this->prefs[$take_course]['log'],
				$course['id'],
				array( 'ref_type' => 'post' ),
				$this->mycred_type
			);
		}
	}

	/**
	 * Check if user passed a course
	 *
	 * @param $course_id
	 * @param $user_id
	 */
	public function pass_course( $course_id, $user_id ) {

		// Check if course or user is invalid
		if ( !$course_id || !$user_id ) {
			return;
		}

		// Check if user or order is invalid
		if ( $this->core->exclude_user( $user_id ) ) {
			return;
		}

		// Check if user has not passed the course
		if ( !learn_press_user_has_passed_course( $course_id, $user_id ) ) {
			return;
		}

		// Make sure we award points other then zero
		if ( !isset( $this->prefs['pass_course']['creds'] ) ) {
			return;
		}
		if ( empty( $this->prefs['pass_course']['creds'] ) || $this->prefs['pass_course']['creds'] == 0 ) {
			return;
		}
		// Execute
		if ( !$this->over_hook_limit( 'pass_course', 'learnpress_learner', $user_id ) ) {
			$this->core->add_creds(
				'learnpress_learner',
				$user_id,
				$this->prefs['pass_course']['creds'],
				$this->prefs['pass_course']['log'],
				$course_id,
				array( 'ref_type' => 'post' ),
				$this->mycred_type
			);
		}
	}


	/**
	 * Add Settings
	 */
	public function preferences() {
		// Our settings are available under $this->prefs
		$prefs = $this->prefs; ?>

		<label for="<?php echo $this->field_id( array( 'take_free_course' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for taking a free course', 'learn_press' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'take_free_course' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'take_free_course' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['take_free_course']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'take_free_course' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'take_free_course' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'take_free_course' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['take_free_course']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>
		<label class="subheader"><?php _e( 'Limit', 'learn_press' ); ?></label>
		<ol>
			<li>
				<?php echo $this->hook_limit_setting( $this->field_name( array( 'take_free_course' => 'limit' ) ), $this->field_id( array( 'take_free_course' => 'limit' ) ), $prefs['take_free_course']['limit'] ); ?>
			</li>
		</ol>

		<label for="<?php echo $this->field_id( array( 'take_paid_course' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for taking a paid course', 'learn_press' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'take_paid_course' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'take_paid_course' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['take_paid_course']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'take_paid_course' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'take_paid_course' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'take_paid_course' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['take_paid_course']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>
		<label class="subheader"><?php _e( 'Limit', 'learn_press' ); ?></label>
		<ol>
			<li>
				<?php echo $this->hook_limit_setting( $this->field_name( array( 'take_paid_course' => 'limit' ) ), $this->field_id( array( 'take_paid_course' => 'limit' ) ), $prefs['take_paid_course']['limit'] ); ?>
			</li>
		</ol>

		<label for="<?php echo $this->field_id( array( 'pass_course' => 'creds' ) ); ?>" class="subheader"><?php echo $this->core->template_tags_general( __( '%plural% for passing a course', 'learn_press' ) ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'pass_course' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'pass_course' => 'creds' ) ); ?>" value="<?php echo $this->core->number( $prefs['pass_course']['creds'] ); ?>" size="8" />
				</div>
			</li>
		</ol>
		<label for="<?php echo $this->field_id( array( 'pass_course' => 'log' ) ); ?>" class="subheader"><?php _e( 'Log Template', 'learn_press' ); ?></label>
		<ol>
			<li>
				<div class="h2">
					<input type="text" name="<?php echo $this->field_name( array( 'pass_course' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'pass_course' => 'log' ) ); ?>" value="<?php echo esc_attr( $prefs['pass_course']['log'] ); ?>" class="long" />
				</div>
				<span class="description"><?php echo $this->available_template_tags( array( 'general', 'post' ) ); ?></span>
			</li>
		</ol>
		<label class="subheader"><?php _e( 'Limit', 'learn_press' ); ?></label>
		<ol>
			<li>
				<?php echo $this->hook_limit_setting( $this->field_name( array( 'pass_course' => 'limit' ) ), $this->field_id( array( 'pass_course' => 'limit' ) ), $prefs['pass_course']['limit'] ); ?>
			</li>
		</ol>
		<?php
	}

	/**
	 * Sanitize Preferences
	 */
	public function sanitise_preferences( $data ) {

		$actions = array( 'take_free_course', 'take_paid_course', 'pass_course' );
		foreach ( $actions as $action ) {
			if ( isset( $data[$action]['limit'] ) && isset( $data[$action]['limit_by'] ) ) {
				$limit = sanitize_text_field( $data[$action]['limit'] );
				if ( $limit == '' ) {
					$limit = 0;
				}
				$data[$action]['limit'] = $limit . '/' . $data[$action]['limit_by'];
				unset( $data[$action]['limit_by'] );
			}
		}

		return $data;
	}
}

