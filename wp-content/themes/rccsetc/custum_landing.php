<?php
/*
Template Name: Landing Page
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="format-detection" content="telephone=no">
<style>
	@media screen and ( max-width: 395px ) { iframe { height: 840px; } }
.form-container legend span {
    background: none repeat scroll 0 0 #C1272D;
    padding: 0 11px;
}

.form-container legend {
    background: url("<?php echo get_template_directory_uri(); ?>/landing/bg-legend.png") repeat-x scroll 50% 50% rgba(0, 0, 0, 0);
    color: #FFFFFF;
    font-family: Verdana,Geneva,sans-serif;
    font-size: 2em;
    text-transform: uppercase;
}

.form-container p {
    color: #FFFFFF;
    font-size: 1.4em;
    margin-bottom: 1.5em;
}

/*This will remove the sliding animations */
.left { left: 0px !important; }
.right { right: 0px !important; }
.bottom { bottom: 0px !important; }
.rotate { top: 0px !important; }

.btn-login p { width: 270px !important; }
</style>
    <!-- Define Charset -->
    <meta charset="utf-8"/>

    <!-- Page Title -->
    <title><?php wp_title(); ?> | <?php bloginfo('name'); ?></title>

    <!-- Responsive Metatag -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page Description and Author -->
<?php wp_head();?>

    

    <!-- Stylesheet
	===================================================================================================	 -->
	
   <!-- HTML5 shim, for IE6-8 support of HTML5 elements --><!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!-- styles for IE --><!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/landing/ie.css" type="text/css" media="screen"/><![endif]-->
	
	<!-- Bootstrap -->
	<link href="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-min.css" rel="stylesheet" media="screen">
	<link href="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-responsive-min.css" rel="stylesheet" media="screen">
    <link href="<?php echo get_template_directory_uri(); ?>/landing/helpers.css" rel="stylesheet" media="screen">
 
	<!-- Grid galery -->
	<noscript><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/landing/fallback.css" /></noscript>	
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/landing/fallback.css" /><![endif]-->
		
    <!-- styles radios checkboxes -->    
	<!--[if IE 7]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/landing/jstyling-ie7Fixes.css" type="text/css" media="screen" /><![endif]-->

	<!-- Custom Template Styles -->
    <link href="<?php echo get_template_directory_uri(); ?>/landing/style.css" rel="stylesheet" media="screen">

	<!-- Media Queries -->
    <link href="<?php echo get_template_directory_uri(); ?>/landing/media-queries.css" rel="stylesheet" media="screen">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/landing/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon-114x114.png">

<?php wp_head(); ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3587288-10']);
  _gaq.push(['_setDomainName', 'rccit.ca']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
</script>
</head>


<body>

	
 <?php the_content(); ?>
    
    
    
	    
	<!-- ======================= JQuery libs =========================== -->
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery-1-8-2-min.js"></script>
        
        <!-- Bootstrap.js-->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-select-min.js" type="text/javascript"></script>
        
        <!-- Gallery -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/modernizr-custom-26633.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery-gridrotator.js"></script>
        
        <!-- Slider -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/responsiveslides-min.js"></script>
        
        <!-- Controls styles -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery.jstyling-min.js"></script>
        
        <!-- Video Responsive-->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/jquery-fitvids-min.js" type="text/javascript"></script>
        
        <!-- easing plugin ( optional ) -->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/easing.js" type="text/javascript"></script>
        
        <!-- UItoTop plugin -->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/jquery-ui-totop-min.js" type="text/javascript"></script>
        
        <!--  Waypoints -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/waypoints-min.js"></script>
        
        <!-- Template custom script  -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery-func.js"></script>
	<!-- ======================= End JQuery libs ======================= -->
	    
    
    

       
</body>
</html>