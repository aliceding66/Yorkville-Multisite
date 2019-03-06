<?php

require_once __DIR__ . '/yorkville_dev_production_manager.php'; 

?>

<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3587288-35"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-3587288-35');
		</script>
	
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		
		<?php wp_head(); ?>
		
		<!-- AppBar -->
		<?php 
			$current_user = wp_get_current_user();
			$email = $current_user->data->user_email;
		?>
		
		<script type="text/javascript">
			// Jquery in DOM
			(function (jQuery) {
				window.$ = jQuery.noConflict();
			})(jQuery);
			
			window.email = "<?php echo $email; ?>";
			
		</script>
		
		<!-- YU GLOBAL BRANDING -->
		<script type="text/javascript">
	
			/*
			<?php if( wp_get_current_user()->data->ID ){?>
				window.user = <?php echo wp_get_current_user()->data->ID; ?>;
			<?php }else{ ?>
				window.user = 0;
			<?php } ?>
			console.log("USER WAS: "+window.user);
			var appbar = document.createElement("script");
			appbar.type = "text/javascript"; 
			appbar.async = true;
			appbar.src = "//<?php echo $YORKVILLE['home']; ?>/wp-content/themes/yu2018/subdomains/appbar/init.js";
			console.log("APPBAR SOURCE: "+appbar.src);
			
			// Write to DOM
			document.getElementsByTagName("head")[0].appendChild(appbar);
			*/
			window.animsitionLoaded = false;
			setInterval(function(){
				if($('.animsition').css('opacity') == 0) {
					if(window.animsitionLoaded == false){
						$('.animsition').animsition('in');
						window.animsitionLoaded = true;
					}
				}
			},500);
			
		</script>
		<!-- AppBar -->
		

		
	</head>
	
	<body <?php body_class(); ?>>
	<div style="display:none;" class="cachebuster-<?php echo rand(); ?>">

		<?php echo rand(); ?>

	</div>

		<div class="animsition">
	
		
		<header>

			<!-- social-media -->
			<div class="header-social">
				<div class="grid-container">
					<div class="grid-x">
						<ul>
							<li>
								<a href="https://twitter.com/YorkvilleU" target="_blank"><span class="screen-reader-text">Link to Twitter account</span><i class="fab fa-twitter" aria-hidden="true"></i></a>
							</li>
							<li>
								<a href="https://www.facebook.com/YorkvilleUniversity" target="_blank"><span class="screen-reader-text">Link to Twitter account</span><i class="fab fa-facebook" aria-hidden="true"></i></a>
							</li>
							<li>
								<a href="https://www.youtube.com/user/YorkvilleUniversity" target="_blank"><span class="screen-reader-text">Link to Youtube account</span><i class="fab fa-youtube" aria-hidden="true"></i></a>
							</li>
							<li>
								<a href="https://www.linkedin.com/school/2378290/" target="_blank"><span class="screen-reader-text">Link to Youtube account</span><i class="fab fa-linkedin" aria-hidden="true"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<!-- user -->
			<div class="header-user">
				<div class="grid-container">
					<div class="grid-x">

						<a href="http://my.yorkvilleu.ca/">
							<img class="yu_logo" src="/wp-content/themes/yu2018/img/logo.jpg" alt="YorkvilleU Logo"/>
						</a>
						<div class="header-user_right">
							<a href="http://askyu.azure.yorkvilleu.ca" class="ask button">
								<i class="fas fa-search" aria-hidden="true"></i>
								AskYU   
							</a>
							<a href="http://my.yorkvilleu.ca" class="ask button" style="margin-left:10px;">
								<i class="fas fa-th" aria-hidden="true"></i> MyYU   
							</a>
							<?php 
							if (is_user_logged_in()) {
								
							
							
							$user = wp_get_current_user(); ?>
							&nbsp; &nbsp;<a class="tooltip" href="https://portal.office.com/account/#personalinfo" target="_blank"><img id="header-avatar" src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>"><span class="tooltiptext">Click to sign in and update your profile images</span></a>
							<?php }
							else { ?>
								<img src="https://library.yorkvilleu.ca/wp-content/themes/yu2018/img/user.png" style="margin-left:10px; height:50px;">
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<!-- search -->
			<div class="header-search">
				<div class="grid-container">
					<div class="grid-x">
						<div class="cell small-8 small-offset-2">
							<button class="close">
								<span class="screen-reader-text">Close search menu</span>
								<i class="fab fa-times close" aria-hidden="true"></i>
							</button>
							<div class="clearfix">
								<h3 class="text-center">What can we help with?</h3>
								<form class="header-search-form" action="#">
									<input placeholder="Search" type="text">
									<input value="Search" type="submit">
								</form>
								<h4 class="text-center">Helpful Links</h4>
								<div class="grid-x search-links">
									<div class="cell small-12 large-6">
										<p>Category</p>
										<ul>
											<li>
												<a href="#">Link 1</a>
											</li>
											<li>
												<a href="#">Link 2</a>
											</li>
											<li>
												<a href="#">Link 3</a>
											</li>
										</ul>
									</div>
									<div class="cell small-12 large-6">
										<p>Other Section</p>
										<ul>
											<li>
												<a href="#">Link 1</a>
											</li>
											<li>
												<a href="#">Link 2</a>
											</li>
											<li>
												<a href="#">Link 3</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</header>
		
			<!-- wrapper -->
			<div class="wrapper">
			
					
				<span class="ubermenu-zindex">
					<?php //ubermenu( 'main' , array( 'theme_location' => 'header-menu' ) ); ?>
				</span>
