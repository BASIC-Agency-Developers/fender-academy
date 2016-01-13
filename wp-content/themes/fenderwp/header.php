<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class=""> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title><?php wp_title(); ?></title>

		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/screen.css" media="screen" />

		<link href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/libs/modernizr.min.js"></script>

		<!--[if (gte IE 6)&(lte IE 8)]>
			<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/libs/selectivizr.min.js"></script>
		<![endif]-->
		<!--[if lt IE 9]>
			<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/libs/respond.min.js"></script>
		<![endif]-->

		<!-- Typekit -->
		<script>
			(function(d) {
				var config = {
					kitId: 'oos5bna',
					scriptTimeout: 3000,
					async: true
				},
				h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
			})(document);
		</script>
	</head>

<body id="<?php echo $identifier; ?>" data-page="dashboard" ng-app="FenderAcademy" <?php body_class(); ?>>
<?php do_action( 'before' ); ?>

<div class="viewport"><!-- .viewport start -->

	<header id="page-head" class="head">
		<a class="nav-btn nav-btn-menu" href="#main-nav">Main Navigation</a>
		<a class="nav-btn nav-btn-user" href="#user-nav">User Navigation</a>
		<a class="nav-btn nav-btn-close" href="#main">Skip Navigation</a>

		<a class="brand brand-head" href="/">
			<h1 class="meta">Fender Academy</h1>
			<img class="brand_img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/global/logo.png" width="142" alt="The Fender Academy logo" />
		</a><!-- /.brand -->

		<nav id="main-nav" class="nav nav-main nav-head">
			<h2 class="meta">Primary Navigation</h2>

			<?php 
				$menu_items = wp_get_nav_menu_items(4);
				$menu = '<ul class="nav_list">';
				foreach ($menu_items as $key => $menu_item) {
					if ($menu_item->menu_item_parent == 0){
						$parents[] = $menu_item;
					} else {
						$children[] = $menu_item;
					}
				}

				foreach ($parents as $parent){
					$class = 'nonDropdown';
					$formattedChildren = '';
					foreach ($children as $child){
						if ($child->menu_item_parent == $parent->ID) {
							$class = 'dropdown';
							$formattedChildren .= '<li><a href="'. $child->url .'">'. $child->title .'</a></li>';
						}
					}

					if ($class == 'dropdown'){
						$menu .= '<li class="dropdown">';
						$menu .= '<a class="nav_item dropdown_btn page-btn" href="'. $parent->url .'">'. $parent->title .'</a>';
						$menu .= '<ul class="dropdown_list">';
						$menu .= $formattedChildren;
						$menu .= '</ul>';
						$menu .= '</li>';
					} else {
						$menu .= '<li class="nonDropdown">';
						$menu .= '<a class="nav_item page-btn" href="'. $parent->url .'">'. $parent->title .'</a>';				
						$menu .= '</li>';
					}
				}

				echo $menu;
			?>

			<!-- <ul class="nav_list">
				<li class="dropdown">
					<a class="nav_item dropdown_btn page-btn" href="learn.html">Learn</a>

					<ul class="dropdown_list">
						<li><a href="chapter.html">Fender Fundamentals</a></li>
						<li><a href="chapter.html">Electric Guitar</a></li>
						<li><a href="chapter.html">Bass Guitar</a></li>
						<li><a href="chapter.html">Amplifiers</a></li>
						<li><a href="chapter.html">Acoustics</a></li>
						<li><a href="chapter.html">Folk &amp; Bluegrass</a></li>
						<li><a href="chapter.html">Limited Edition</a></li>
						<li><a href="#">+ See All</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="nav_item dropdown_btn page-btn" href="latest.html">Latest</a>

					<ul class="dropdown_list">
						<li><a href="latest-category.html">Video</a></li>
						<li><a href="latest-category.html">Products</a></li>
						<li><a href="latest-category.html">Events</a></li>
						<li><a href="latest-category.html">Spotlight</a></li>
						<li><a href="latest-category.html">Rewards</a></li>
						<li><a href="latest-archive.html">Archive</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="nav_item dropdown_btn page-btn" href="resources.html">Resources</a>

					<ul class="dropdown_list">
						<li><a href="resources-calendar.html">Calendar</a></li>
						<li><a href="resources-events.html">Events</a></li>
					</ul>
				</li>
				<li class="nonDropdown"><a class="nav_item page-btn" href="learn.html">Support</a></li>
			</ul> -->
		</nav><!-- /.mainNav -->

		<nav id="user-nav" class="nav nav-user nav-head">
			<h2 class="meta">User Navigation</h2>

			<div class="dropdown nav_module nav_avatar">
			
				<!-- .avatar element can have classes gold, silver, or bronze to show different pick outlines -->
				<figure class="avatar">
					<img class="avatar_img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/uploads/user-lg-01.jpg" width="32" height="32" alt="My avatar" />
				</figure>

				<span class="nav_item dropdown_btn"><span class="nav_uname">Adam</span></span>

				<ul class="dropdown_list">
					<li><a href="dashboard.html">Dashboard</a></li>
					<li><a href="account.html">My Account</a></li>
					<li><a href="#">Log Out</a></li>
				</ul>
			</div><!-- /.nav_avatar -->

			<div class="nav_module nav_iq">
				<div class="iq" data-pct="60">
					<strong class="nav_iq_title iq_title">My Fender IQ</strong>

					<div class="canvIq iq_img" data-iq="110" data-goal="200" data-size="35" data-dots="no">
						<span class="iq_lbl tertiary">102</span>
					</div>
				</div><!-- /.iq -->
			</div><!-- /.nav_iq -->
		</nav><!-- /.userNav -->
	</header><!-- /#page-head -->