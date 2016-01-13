<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
global $lesson;

do_action( 'learn_press_before_main_content' );
if ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<header class="entry-header">

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div>
						<a href="#backtolearn" class="text-uppercase"><i class="fa fa-long-arrow-left"></i> back to learn</a>
						<h4 class="course-title text-uppercase">new products</h4>
					</div>
					<div>
						<ul>
							<li><a href="#" class="text-uppercase">Acoustic Pro Amplifier</a></li>
							<li><a href="#" class="text-uppercase">american elite electric guitar</a></li>
							<li class="current-item"><a href="#" class="text-uppercase">bassbreaker Amplifier</a></li>
							<li><a href="#" class="text-uppercase">george benson signature Amplifier</a></li>
							<li><a href="#" class="text-uppercase">paramount acoustic</a></li>
							<li><a href="#" class="text-uppercase">the edge signature amplifier</a></li>
							<li><a href="#" class="text-uppercase">the edge stratocaster</a></li>
							<li><a href="#" class="text-uppercase">chapter test</a> <i class="fa fa-check-circle"></i></li>						
						</ul>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="course-hero hero-style-1" style="background:url(http://placehold.it/1920x500/999999/777777) no-repeat center center">
						<div class="row">
							<div class="col-sm-4 col-sm-offset-1">
								<?php do_action( 'learn_press_before_the_title' ); ?>	
								<h1 class="text-uppercase">bassbreaker<sup>tm</sup> amplifier series</h1>
								<?php do_action( 'learn_press_after_the_title' ); ?>

								<p><strong>In this lesson, you'll dive deep into our latest exploration in amplification - the Bassbreaker series.</strong></p>
								<ul>
									<li>Identify ideal customers</li>
									<li>Explain how Bassbreaker has evolved</li>
									<li>Demonstrate the compatibility of heads and cabinets</li>
									<li>Compare the features across individual models</li>
								</ul>

								<a href="#" class="button button-white button-transparent text-uppercase">take lesson quiz</a>
								<a href="#" class="button button-white button-transparent text-uppercase">take chapter test</a>

								<a href="#" class="show text-uppercase"><i class="fa fa-angle-down"></i> scroll to start lesson</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div>
						<a href="#backtolearn" class="text-uppercase"><i class="fa fa-long-arrow-left"></i> back to learn</a>
						<h4 class="course-title text-uppercase">fender brand</h4>
					</div>
					<div>
						<ul>
							<li><a href="#" class="text-uppercase">fender fundamentals</a></li>
							<li class="current-item"><a href="#" class="text-uppercase">fender origins</a></li>
							<li><a href="#" class="text-uppercase">fender artists</a></li>
							<li><a href="#" class="text-uppercase">chapter test</a> <i class="fa fa-bullseye"></i></li>						
						</ul>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="course-hero hero-style-2" style="background:url(http://placehold.it/1920x500/ff0000/ff0022) no-repeat center center">
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4 text-center">
								<?php do_action( 'learn_press_before_the_title' ); ?>	
								<p class="subtitle text-uppercase">how it all began</p>
								<h1 class="text-uppercase">fender origins</h1>
								<?php do_action( 'learn_press_after_the_title' ); ?>

								<p><strong>In this lesson, you'll dive deep into our latest exploration in amplification - the Bassbreaker series.</strong></p>
								<ul class="text-left">
									<li>Identify ideal customers</li>
									<li>Explain how Bassbreaker has evolved</li>
									<li>Demonstrate the compatibility of heads and cabinets</li>
									<li>Compare the features across individual models</li>
								</ul>

								<a href="#" class="button button-white button-transparent text-uppercase">take lesson quiz</a>
								<a href="#" class="button button-white button-transparent text-uppercase">take chapter test</a>

								<a href="#" class="show text-uppercase">scroll to start lesson<br><i class="fa fa-angle-down"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div>
						<a href="#backtolearn" class="text-uppercase"><i class="fa fa-long-arrow-left"></i> back to learn</a>
						<h4 class="course-title text-uppercase">chapter title longer line</h4>
					</div>
					<div>
						<ul>
							<li><a href="#" class="text-uppercase">lesson title</a></li>
							<li><a href="#" class="text-uppercase">lesson title</a></li>
							<li><a href="#" class="text-uppercase">lesson title longer line</a></li>
							<li class="current-item"><a href="#" class="text-uppercase">active lesson</a></li>
							<li><a href="#" class="text-uppercase">lesson title</a></li>
							<li><a href="#" class="text-uppercase">lesson title</a></li>
							<li><a href="#" class="text-uppercase">lesson title</a></li>
							<li><a href="#" class="text-uppercase">chapter test</a> <i class="fa fa-bullseye"></i></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="course-hero hero-style-3" style="background:url(http://placehold.it/1920x500/f06942/f07544) no-repeat center center">
						<div class="row">
							<div class="col-sm-4 col-sm-offset-8">
								<?php do_action( 'learn_press_before_the_title' ); ?>	
								<p class="subtitle text-uppercase">lesson subtitle</p>
								<h1 class="text-uppercase">title of lesson</h1>
								<?php do_action( 'learn_press_after_the_title' ); ?>

								<p><strong>Objective intro summary, lorem ipsum dolor sit amet, sed do eiusmod adipiscing elit.</strong></p>
								<ul>
									<li>Identify ideal customers</li>
									<li>Explain how Bassbreaker has evolved</li>
									<li>Demonstrate the compatibility of heads and cabinets</li>
									<li>Compare the features across individual models</li>
								</ul>

								<a href="#" class="button button-white button-transparent text-uppercase">take lesson quiz</a>
								<a href="#" class="button button-white button-transparent text-uppercase">take chapter test</a>

								<a href="#" class="show text-uppercase"><i class="fa fa-angle-down"></i> scroll to start lesson</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		

	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php do_action( 'learn_press_begin_course_content_lesson_description' ); ?>
		
		<section>
			<div class="section-hero section-hero-style1" style="background:url(http://placehold.it/1920x500) no-repeat center center">				
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-4 col-sm-offset-2">
							<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1954 date style</p>
							<h2 class="text-uppercase">introduced in 1954</h2>

							<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>
						</div>
					</div>
				</div>

				<span class="tag-name">BUDDY GUY</span>
			</div>
		</section>

		<section>
			<div class="section-hero section-hero-style2" style="background:url(http://placehold.it/1920x500/c05487/c05111) no-repeat center center">				
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-4 col-sm-offset-6">
							<p class="subtitle subtitle-red text-uppercase">section title style</p>
							<h2 class="text-uppercase">knows no musical boundaries</h2>

							<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>

							<a href="#" class="button button-icon button-red text-uppercase"><i class="fa fa-arrow-circle-right"></i> learn more</a>
						</div>
					</div>
				</div>

				<span class="tag-name">MIKE DEUCE</span>
			</div>
		</section>

		<section>
			<div class="section-hero section-hero-style3" style="background:url(http://placehold.it/1920x500/abcdef/acdcef) no-repeat center center">				
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-4 col-sm-offset-4 text-center">
							<p class="subtitle subtitle-red text-uppercase">section title here</p>
							<h2 class="text-uppercase">designed for the spotlight</h2>

							<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>

							<a href="#" class="text-uppercase"><i class="fa fa-play"></i> watch video</a>
						</div>
					</div>
				</div>

				<span class="tag-name">BRUNO MARS</span>
			</div>
		</section>

		<section>
			<div class="row">
				<div class="col-sm-6">
					<img src="http://placehold.it/800x800/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<p class="subtitle subtitle-red text-uppercase">section title here</p>
							<h2 class="text-uppercase">hear the sound</h2>

							<p>Mauris posuere nulla ac ultricies auctor. Praesent venenatis dignissim felis, nec molestie ipsum hendrerit vitae. Aenean a tellus vulputate, tincidunt mauris sed, molestie lorem. Mauris ultrices congue mi, quis blandit felis scelerisque eu.</p>

							<div class="soundtracks">
								<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/88338175&amp;color=ff5500&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false"></iframe>
								<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/88338175&amp;color=ff5500&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false"></iframe>
								<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/88338175&amp;color=ff5500&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false"></iframe>
							</div>
							<div class="soundtracks-scrolls">
								<a href="#"><i class="fa fa-angle-up"></i></a>
								<a href="#"><i class="fa fa-angle-down"></i></a>
								<span class="track-no">1/7</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="row">				
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<p class="subtitle subtitle-red text-uppercase">section title here</p>
							<h2 class="text-uppercase">hear the sound</h2>

							<p>Mauris posuere nulla ac ultricies auctor. Praesent venenatis dignissim felis, nec molestie ipsum hendrerit vitae. Aenean a tellus vulputate, tincidunt mauris sed, molestie lorem. Mauris ultrices congue mi, quis blandit felis scelerisque eu.</p>

							<ul>
								<li>Mauris posuere nulla ac ultricies auctor</li>
								<li>Mauris posuere nulla ac ultricies auctor</li>
								<li>Mauris posuere nulla ac ultricies auctor</li>
								<li>Mauris posuere nulla ac ultricies auctor</li>
								<li>Mauris posuere nulla ac ultricies auctor</li>
							</ul>

							<a href="#" target="_blank" class="text-uppercase"><i class="fa fa-arrow-down"></i> download catalogue</a>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<img src="http://placehold.it/800x800/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
			</div>
		</section>

		<section>
			<div class="row">
				<div class="col-sm-6">
					<img src="http://placehold.it/800x800/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
				<div class="col-sm-6 darker-color">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<p class="subtitle subtitle-red text-uppercase">section title here</p>
							<h2 class="text-uppercase">hear the sound</h2>

							<p>Mauris posuere nulla ac ultricies auctor. Praesent venenatis dignissim felis, nec molestie ipsum hendrerit vitae. Aenean a tellus vulputate, tincidunt mauris sed, molestie lorem. Mauris ultrices congue mi, quis blandit felis scelerisque eu. Mauris posuere nulla ac ultricies auctor. Aenean a tellus vulputate, tincidunt mauris sed, molestie lorem. Mauris ultrices congue mi, quis blandit felis scelerisque eu.</p>

							<p>Mauris posuere nulla ac ultricies auctor. Praesent venenatis dignissim felis, nec molestie ipsum hendrerit vitae. Aenean a tellus vulputate, tincidunt mauris sed, molestie lorem. Mauris ultrices congue mi, quis blandit felis scelerisque eu.</p>

							<p>Discover Additional Info CTA</p>
							<a href="#" class="button button-icon button-red text-uppercase"><i class="fa fa-arrow-circle-right"></i> learn more</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="with-padding">
			<div class="row">
				<div class="col-sm-4">
					<img src="http://placehold.it/800x1000/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
				<div class="col-sm-4">
					<img src="http://placehold.it/800x1000/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
				<div class="col-sm-4">
					<img src="http://placehold.it/800x1000/333333/555555/?text=image+of+singer+here" class="img-responsive">
					<span class="tag-name">NILE RODGERS</span>
				</div>
			</div>
		</section>

		<section class="with-padding">
			<div class="row">
				<div class="col-sm-6 padding1">
					<img src="http://placehold.it/800x800/?text=image+of+singer+here" class="img-responsive">
				</div>
				<div class="col-sm-6 padding1">
					<div class="row">
						<div class="col-sm-6 padding1">
							<img src="http://placehold.it/800x800/?text=image+of+singer+here" class="img-responsive">
						</div>
						<div class="col-sm-6 padding1">
							<img src="http://placehold.it/800x800/?text=image+of+singer+here" class="img-responsive">
						</div>
						<div class="col-sm-6 padding1">
							<img src="http://placehold.it/800x800/?text=image+of+singer+here" class="img-responsive">
						</div>
						<div class="col-sm-6 padding1">
							<img src="http://placehold.it/800x800/?text=image+of+singer+here" class="img-responsive">
						</div>
					</div>					
				</div>
			</div>
		</section>

		<section>
			<img src="http://placehold.it/2000x1000/ff0000/222222/?text=img" class="img-responsive">
			<a href="#" class="text-uppercase"><i class="fa fa-play"></i> watch video</a>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
					</div>
					<div class="col-sm-5">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1951</p>
						<h2 class="text-uppercase">that same year, the precision bass was created</h2>

						<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>
					</div>
				</div>

				<div class="row">					
					<div class="col-sm-5">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1951</p>
						<h2 class="text-uppercase">that same year, the precision bass was created</h2>

						<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>
					</div>
					<div class="col-sm-7">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
					</div>
					<div class="col-sm-5">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1951</p>
						<h2 class="text-uppercase">that same year, the precision bass was created</h2>

						<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>
					</div>
				</div>

				<div class="row">					
					<div class="col-sm-5">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1951</p>
						<h2 class="text-uppercase">that same year, the precision bass was created</h2>

						<p>The Stratocaster was made famous in the hands of music royalty, from Eric Clapton to Jimi Hendrix and countless more. The Strat is more than an instrument - it's an icon with a timeless shape and unforgettable sound.</p>
					</div>
					<div class="col-sm-7">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
					</div>
				</div>
			</div>
		</section>

		<section style="background:#f2f2f2">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
						<span class="tag-name">JIMMY SMITH</span>
					</div>
					<div class="col-sm-6">						
						<h4 class="text-uppercase">semi-section title</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie.</p>
						<p> Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
				</div>

				<div class="row">					
					<div class="col-sm-6">						
						<h4 class="text-uppercase">semi-section title</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie.</p>
						<p> Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
					<div class="col-sm-6">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
						<span class="tag-name">JIMMY SMITH</span>
					</div>					
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
						<span class="tag-name">JIMMY SMITH</span>
					</div>
					<div class="col-sm-6">						
						<h4 class="text-uppercase">semi-section title</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie.</p>
						<p> Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
				</div>

				<div class="row">					
					<div class="col-sm-6">						
						<h4 class="text-uppercase">semi-section title</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie.</p>
						<p> Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
					<div class="col-sm-6">
						<img src="http://placehold.it/700x500/?text=image+of+singer+here" class="img-responsive">
						<span class="tag-name">JIMMY SMITH</span>
					</div>					
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1960</p>
						<h4 class="text-uppercase">bassman brownface "piggyback" amp</h4>

						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>

						<p>Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1960</p>
						<h4 class="text-uppercase">bassman brownface "piggyback" amp</h4>

						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>

						<p>Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<p class="subtitle subtitle-red text-uppercase">section title style</p>
						<h2 class="text-uppercase">an adventurous short-scale spirit</h2>
					</div>
					<div class="col-sm-1">						
					</div>
					<div class="col-sm-5">
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>

						<p>Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>

						<a href="#" target="_blank" class="text-uppercase"><i class="fa fa-arrow-down"></i> download catalogue</a>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<p class="subtitle subtitle-red text-uppercase">section title style</p>
						<h2 class="text-uppercase">an adventurous short-scale spirit</h2>
					</div>
					<div class="col-sm-1">						
					</div>
					<div class="col-sm-5">
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>

						<p>Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus. Ut lectus velit, viverra at ex vitae, lobortis blandit ligula. In tempor risus est, vitae porttitor dui gravida in. Nam vitae faucibus magna, sed aliquam lacus.</p>
						
						<a href="#" target="_blank" class="text-uppercase"><i class="fa fa-arrow-down"></i> download catalogue</a>
					</div>
				</div>
			</div>
		</section>
		
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">1940's</p>
						<h2 class="text-uppercase">clarence "leo" fender</h2>

						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red text-uppercase">history</p>
						<h2 class="text-uppercase">clarence "leo" fender</h2>

						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in.</p>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red text-uppercase">features</p>
						<h2 class="text-uppercase">versatility defined</h2>

						<h3 class="text-uppercase">often imitated, never duplicated: no matter the genre, nothing sings like a strat.</h3>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red text-uppercase">features</p>
						<h2 class="text-uppercase">versatility defined</h2>

						<h3 class="text-uppercase">often imitated, never duplicated: no matter the genre, nothing sings like a strat.</h3>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">"</p>
						<h4 class="text-uppercase">i've moved around with many guitars and tried many different things, and i've always come back to the stratocaster</h4>
						<span class="tag-name">ERIC CLAPTON</span>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">"</p>
						<h4 class="text-uppercase">i've moved around with many guitars and tried many different things, and i've always come back to the stratocaster</h4>
						<span class="tag-name">ERIC CLAPTON</span>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p class="subtitle subtitle-red text-uppercase text-center">sound</p>
						<h2 class="text-uppercase text-center">played by the experts</h2>						
					</div>

					<div class="col-sm-4">
						<h4 class="text-uppercase">why the stratocaster suits a variety of musical styles</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
					</div>

					<div class="col-sm-8">
						<img src="http://placehold.it/900x500/?text=image+of+singer+here" class="img-responsive">
						<a href="#"><i class="fa fa-play"></i></a>
						<span class="tag-name">STEVE ALERO, MASTER BUILDER</span>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<img src="http://placehold.it/900x500/?text=image+of+singer+here" class="img-responsive">
						<a href="#"><i class="fa fa-play"></i></a>					
					</div>

					<div class="col-sm-4">
						<p class="subtitle subtitle-red subtitle-bigger text-uppercase">2015</p>
						<h4 class="text-uppercase">bassbreaker 45</h4>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<p class="subtitle subtitle-red text-uppercase">sound</p>
						<h2 class="text-uppercase">about custom shop</h2>
					</div>

					<div class="col-sm-7">
						<img src="http://placehold.it/800x450/?text=video+here" class="img-responsive">
					</div>
					<div class="col-sm-5">
						<div>
							<img src="http://placehold.it/500x100/?text=video+here" class="img-responsive">
							<img src="http://placehold.it/500x100/?text=video+here" class="img-responsive">
							<img src="http://placehold.it/500x100/?text=video+here" class="img-responsive">
							<img src="http://placehold.it/500x100/?text=video+here" class="img-responsive">
						</div>
						<div class="soundtracks-scrolls">
							<a href="#"><i class="fa fa-angle-up"></i></a>
							<a href="#"><i class="fa fa-angle-down"></i></a>
							<span class="track-no">1/7</span>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<p class="subtitle subtitle-red text-uppercase">sound</p>
						<h2 class="text-uppercase">the sound of excellence</h2>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<iframe width="100%" height="100" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/88338175&amp;color=ff5500&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false"></iframe>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<p class="subtitle subtitle-red text-uppercase">features</p>
						<h2 class="text-uppercase">versatility defined</h2>

						<h3 class="text-uppercase">often imitated, never duplicated: no matter the genre, nothing sings like a strat.</h3>

						<img src="http://placehold.it/200x600/ff0000/ffffff/?text=guitar+with+hotspots">

						<div class="hotspot-overlay">
							<h4 class="text-uppercase">double-cutaway design</h4>
							<img src="http://placehold.it/200x100/ff0000/ffffff/">
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#555">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<p class="subtitle subtitle-red text-uppercase">section title</p>
						<h2 class="text-uppercase">from bassman to bassbreaker</h2>

						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum. Proin congue id odio eu molestie. In tempor risus est, vitae porttitor dui gravida in. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>

						<img src="http://placehold.it/200x600/ff0000/ffffff/?text=year+line">

						<div class="hotspot-overlay">
							<h4 class="text-uppercase">bassman&reg;</h4>
							<img src="http://placehold.it/200x100/ff0000/ffffff/">
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p class="subtitle subtitle-red text-uppercase text-center">style</p>
						<h2 class="text-uppercase text-center">how the strat compares</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4">
						<div class="compares-item">
							<img src="http://placehold.it/400x250" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">telecaster</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="compares-item">
							<img src="http://placehold.it/400x250" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">jaguar</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="compares-item">
							<img src="http://placehold.it/400x250" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">jazzmaster</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section style="background:#666">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p class="subtitle subtitle-red text-uppercase text-center">sound</p>
						<h2 class="text-uppercase text-center">how the jaguar sounds</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-4">
						<div class="sounds-item text-center">
							<img src="http://placehold.it/200x200?text=round+image+with+play+button" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">stratocaster</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="sounds-item text-center">
							<img src="http://placehold.it/200x200?text=round+image+with+play+button" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">stratocaster</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="sounds-item text-center">
							<img src="http://placehold.it/200x200?text=round+image+with+play+button" class="img-responsive">
							<span class="text-uppercase">with the</span>
							<h4 class="text-uppercase">stratocaster</h4>
							<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p class="subtitle subtitle-red text-uppercase text-center">sound</p>
						<h2 class="text-uppercase text-center">how the jaguar sounds</h2>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-3 col-sm-offset-3">
						<div class="contrast-item">
							<img src="http://placehold.it/400x250?text=round+image+with+play+button" class="img-responsive">
							<h4 class="text-uppercase">stratocaster</h4>
							<ul>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
							</ul>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="contrast-item">
							<img src="http://placehold.it/400x250?text=round+image+with+play+button" class="img-responsive">
							<h4 class="text-uppercase">stratocaster</h4>
							<ul>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
								<li>Pellentesque tristique magna et lorem faucibus venenatis</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section style="background:url(http://placehold.it/1920x1000/ff0000/ff66ff/?text=picture+here) no-repeat center center;">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text-center">
						<h2 class="text-uppercase">begin the stratocaster quiz</h2>
						<p>Pellentesque tristique magna et lorem faucibus venenatis. Nam imperdiet consectetur libero vitae tempor. Nam imperdiet consectetur libero vitae tempor. Quisque pretium eu leo id elementum.</p>

						<a href="#" class="button button-white button-transparent text-uppercase">start now</a>
						<a href="#gototop" class="text-uppercase">i need to review more, take me to the top <i class="fa fa-arrow-up"></i></a>
					</div>
				</div>
			</div>
		</section>
				
		<?php do_action( 'learn_press_end_course_content_lesson_description' ); ?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer">
		
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-## -->

<?php endif;
do_action( 'learn_press_after_main_content' );

get_footer(); ?>