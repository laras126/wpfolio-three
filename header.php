<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php wp_head(); ?>
		<!-- end of wordpress head -->
		
	</head>

	<body <?php body_class(); ?>>
	
		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<div class="site-name">
						<h1 class="site-title"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></h1>
						<p class="site-description"><?php bloginfo('description'); ?></p>
					</div>
					
					<?php 
						//TODO: echo the parent category, page name, whatever
						// instead of just menu here
					?>

					<a href="#main-nav" class="menu-link"><i class="fa fa-caret-down"></i>  Menu<?php //wp_title(''); ?></a>
					
					<nav id="main-nav" role="navigation" class="site-nav nav">	
						<?php bones_main_nav(); ?>
					</nav>
					
				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
