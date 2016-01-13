<?php
/* Template Name: Learn Template */

get_header();

if (have_posts()) : the_post(); ?>
<div class="main-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header style="background:url(http://placehold.it/1920x600) no-repeat center center">
			<a href="#"><i class="fa fa-long-arrow-left"></i></a>
			<div class="container">
				<div class="col-sm-10 col-sm-offset-1 text-center">
					<span class="text-uppercase">get fender certified</span>
					<h1 class="text-uppercase"><?php the_title(); ?></h1>
				</div>
			</div>
		</header>

		<section>
			<div class="container">
				<div class="cta-hero text-center" style="background:url(http://placehold.it/1200x200/aaaaaa/999999) no-repeat center center;">
					<span class="text-uppercase">quiz 01 | nov 23 2015</span>
					<p class="text-center text-uppercase">stay up-to-date on the latest, take the extra credit quiz!</p>
					<a href="#" class="button text-uppercase">visit latest</a>
					<a href="#" class="button-red text-uppercase">take the quiz</a>
				</div>

				<div class="row">
					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>01 <span class="tag">updated</span></p>
							<h4 class="text-uppercase">fender brand</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 2 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>02</p>
							<h4 class="text-uppercase">electric guitar</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 8 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>03</p>
							<h4 class="text-uppercase">bass guitar</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
						</div>
						<div>
							<a href="#" class="text-uppercase button">view 8 lessons</a>
							<a href="#" class="text-uppercase button transparent"><i class="fa fa-check-circle"></i> test complete</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>04</p>
							<h4 class="text-uppercase">amplifiers</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 10 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>05</p>
							<h4 class="text-uppercase">acoustic guitars</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 10 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>06 <span class="tag">updated</span></p>
							<h4 class="text-uppercase">limited edition</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 4 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>07</p>
							<h4 class="text-uppercase">new products</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 11 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>08</p>
							<h4 class="text-uppercase">folk &amp; bluegrass</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 6 lessons</a>
						</div>
					</div>

					<div class="col-sm-4">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>09</p>
							<h4 class="text-uppercase">accessories</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">basic</span> | 
							<span class="text-uppercase"><i class="fa fa-clock-o"></i> 45 mins</span>
							<a href="#" class="show text-uppercase button">view 8 lessons</a>
						</div>
					</div>

					<div class="col-sm-4 disabled">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>10</p>
							<h4 class="text-uppercase">audio</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">coming soon 2016</span>
						</div>
					</div>

					<div class="col-sm-4 disabled">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>11</p>
							<h4 class="text-uppercase">Custom Shop</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">coming soon 2017</span>
						</div>
					</div>

					<div class="col-sm-4 disabled">
						<div>
							<img class="img-responsive" src="http://placehold.it/400x250">
						</div>
						<div>
							<p>12</p>
							<h4 class="text-uppercase">vintage</h4>
							<p>Learn about the origins of Fender and how it has shaped our continued legacy today.</p>
						</div>
						<div>
							<span class="text-uppercase">coming soon 2017</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	</article>
</div>
<?php endif; ?>

<?php get_footer(); ?>