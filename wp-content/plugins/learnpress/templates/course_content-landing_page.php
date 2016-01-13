<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php do_action( 'learn_press_before_course_header' ); ?>

<header class="entry-header">
	<?php do_action( 'learn_press_before_the_title' ); ?>		

	<div class="course-hero" style="background:url(http://placehold.it/1920x500/999999/777777) no-repeat center center">
		<a href="#backtolearn" class="text-uppercase"><i class="fa fa-arrow-left"></i> back to learn</a>
		<p class="subtitle text-uppercase text-center">chapter 02</p>
		<h1 class="text-uppercase text-center"><?php the_title(); ?></h1>
	</div>

	<?php do_action( 'learn_press_after_the_title' ); ?>
</header>
<!-- .entry-header -->
<?php do_action( 'learn_press_before_course_content' ); ?>
<div class="entry-content">
	<?php do_action( 'learn_press_before_the_content' ); ?>
	<?php do_action( 'learn_press_before_course_landing_content' ); ?>
	
	<?php //do_action( 'learn_press_course_landing_content' ); //this adds the list of quizes, lessons, enrolled students etc ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<span class="text-uppercase">think you're ready for the electric guitar test?</span>
				</div>
				<div class="col-sm-6 text-right">
					<a href="#" class="button button-red text-uppercase">take chapter test</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-7">
					<h2 class="text-uppercase">about electric guitars</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum. Quisque suscipit tellus malesuada massa eleifend, quis luctus sem cursus. Ut suscipit, mi non aliquam lobortis, lacus arcu bibendum erat, non tincidunt felis elit in velit.</p>
				</div>
				<div class="col-sm-5">
					<p class="text-uppercase"><strong>what you'll learn</strong></p>
					<ul>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
						<li>Lorem ipsum dolor sit amet, consectetur</li>
					</ul>
				</div>
				<div class="col-sm-12">
					<span class="text-uppercase">basic</span> | 
					<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">why fender</h3>							
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						<span class="text-uppercase"><i class="fa fa-clock-o"></i> viewed</span>
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">electric guitar anatomy</h3>							
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">series <span class="tag text-uppercase">updated</span></h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">telecaster</h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">stratocaster</h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">jaguar</h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">jazzmaster <span class="tag uppercase">updated</span></h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-item">
				<div class="row">
					<div class="col-sm-3">
						<h3 class="text-uppercase">mustang</h3>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in sem placerat, ultrices odio non, interdum libero. Ut posuere ornare fermentum.</p>
					</div>
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-1">
						<a href="#"><i class="fa fa-long-arrow-right"></i></a>
					</div>
				</div>
			</div>

			<div class="lesson-hero text-center" style="background:url(http://placehold.it/1600x200/999999/777777) no-repeat center center">
				<h3 class="text-uppercase">ready to take the test on electric guitars?</h3>
				<p>Test now to earn IQ and become Fender Certified</p>
				<a href="#" class="button button-red text-uppercase">take chapter test</a>
			</div>
		</div>
	</section>
	
	<?php do_action( 'learn_press_after_course_landing_content' ); ?>
	<?php do_action( 'learn_press_after_the_content' ); ?>
</div>
<!-- .entry-content -->
<?php do_action( 'learn_press_before_course_footer' ); ?>
<footer class="entry-footer">
	
</footer>
<!-- .entry-footer -->