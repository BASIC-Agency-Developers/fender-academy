<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _tk
 */
?>

<footer id="colophon" class="site-footer" role="contentinfo">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>
	<div class="container">
		<div class="row">
			<div class="site-footer-inner col-sm-3">
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>
			<div class="site-footer-inner col-sm-6">
				<?php wp_nav_menu(
					array(
						'theme_location' 	=> 'secondary',
						'depth'             => 1,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'menu_class' 		=> 'nav footer-navbar',
						'menu_id'			=> 'footer-main-menu',
					)
				); ?>
			</div>
			<div class="site-footer-inner col-sm-3 text-right">
				<a href="#" class="button button-totop text-uppercase">top <i class="fa fa-long-arrow-up"></i></a>
			</div>

			<div class="col-sm-12 text-center">
				<span class="text-uppercase">copyright &copy; 2015 fender musical instruments corporation. all rights reserved.</span>
			</div>
		</div>
	</div><!-- close .container -->
</footer><!-- close #colophon -->

<?php wp_footer(); ?>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/lib/jquery.min.js"><\/script>')</script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugins.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.min.js"></script>

<!-- App Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/app.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/app/controllers/triviaController.js"></script>		</div><!-- /.viewport -->
</div><!-- /.viewport -->
</body>
</html>
