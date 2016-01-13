<?php
global $course;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<?php
	//if ( learn_press_is_enrolled_course() ) {
	//	learn_press_get_template_part( 'course_content', 'learning_page' );
	//} else
		learn_press_get_template_part( 'course_content', 'landing_page' );	
	?>
</article><!-- #post-## -->
