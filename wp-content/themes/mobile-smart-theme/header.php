<!DOCTYPE html>
<html>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php if(is_home()) bloginfo('name'); else wp_title(''); ?></title>

<meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
  

  <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/slider.css" />
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  	<link rel="stylesheet" href="../flexslider.css" type="text/css" media="screen" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-4XTX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-4XTX');</script>
<!-- End Google Tag Manager -->

  <script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '487474764720789']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=487474764720789&amp;ev=PixelInitialized" /></noscript>   
<div class="header">
	<div class="header-center">
		<a href="http://m.yorkvilleu.ca/" title="Home" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/images/logon.png" /></a>
    	<a href="http://m.yorkvilleu.ca/contact-us/request-information/" class="request">REQUEST INFORMATION</a>
    	<div class="clear"></div>
	</div>
</div>
