<?php 
	if( $_GET['show_template_file'] == 1){
		global $template; 
		echo "<h1>".basename($template)."</h1>";
	} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if(is_home()) bloginfo('name'); else wp_title(''); ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<meta http-equiv="pragma" content="no-cache" /> 
<meta http-equiv="content-style-type" content="text/css" /> 
<meta http-equiv="content-script-type" content="text/javascript" /> 
<meta name="ientry_id" content="3d271a5482"> 
<meta name="viewport" content="width=981, initial-scale=1, minimumscale=0.5" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/global_root.css" />
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/root.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen">
<!--[if IE 7]
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>ie7_global_root.css" />
<link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>ie7_root.css" />

<!-- MyYorkvilleu -->
<script type="text/javascript">
	(function() {
		var myyu = document.createElement("script");
		myyu.type = "text/javascript"; myyu.async = true;
		myyu.src = "http://azure.yorkvilleu.ca/appbar_dev/init.js";
		document.getElementsByTagName("head")[0].appendChild(myyu);
	})();
</script>
<!-- MyYorkvilleu -->


<![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript">
              //<![CDATA[
function MOvermenuElem(layout,sender,image,menuid,leftImage,rightImage,overStyle, browser, uniqueId){
skm_mousedOverMenu('ctl00_ctl00_headerTopNavigation_menuElem',sender, document.getElementById(menuid), layout, image, leftImage, rightImage, overStyle, browser, uniqueId,false);
}
function CSubmenuElem(URL){
skm_closeSubMenus(document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem')); try { location.href=URL; } catch (ex) {}
}
//]]>
</script>
<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({ publisher: '34719432-65fa-4a5c-9df1-aaf053ba9a04' });</script>
<?php wp_head(); ?>
</head>
<body class="LTR Safari ENUS" >
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
<?php $menuid = get_slug_for_menu_custume()->post_name; $uri = $_SERVER["REQUEST_URI"];$uri_array = explode("/",$uri);$uri_first = $uri_array[2]; ?>
<div class="header" style="display:none !important;"><div class="mainLogo"><a href="<?php echo site_url(); ?>/" title="Home"><img src="<?php echo get_template_directory_uri(); ?>/images/mainlogon.jpg" alt="Yorkville University" />   </a></div>
<div class="headerTopRightContent">For more Information call <span class="home tollFree"><label id="ctl00_ctl00_TopHeader_lblTollFree">1-866-838-6542</label></span>
<span class="followUs">Follow us on:  
<a id="ctl00_ctl00_TopHeader_twitterLink" href="https://twitter.com/#!/YorkvilleU" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="Twitter" /></a>
<a id="ctl00_ctl00_TopHeader_facebookLink" href="https://www.facebook.com/YorkvilleUniversity" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="Facebook" /></a>
<a id="ctl00_ctl00_TopHeader_googlePlusLink" rel="publisher" href="https://plus.google.com/103371777696708605338/posts" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/googleplus.png" alt="Google Plus" /></a>
<a id="ctl00_ctl00_TopHeader_youtubeLink" href="http://www.youtube.com/user/YorkvilleUniversity" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" alt="Youtube" /></a>
<a id="ctl00_ctl00_TopHeader_youtubeLink" href="http://linkd.in/1yNxnr7" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/ln.png" alt="Linkedin" /></a></span><br /><br />
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo site_url(); ?>/search_gcse"><a href="http://bookstore.yorkvilleu.ca/index.asp" target="_blank" rel="nofollow">Book Store</a> | <a id="ctl00_ctl00_TopHeader_campusLink" href="http://campus.yorkvilleu.ca/login/index.php" target="_blank" rel="nofollow">Campus Login</a>
<div id="ctl00_ctl00_TopHeader_SearchBox_pnlSearch" class="searchBox" onkeypress="javascript:return WebForm_FireDefaultButton(event, 'ctl00_ctl00_TopHeader_SearchBox_btnImageButton')">
<input autocomplete="off" type="text" maxlength="1000"  name="q" title="search" id="gsc-i-id1" lang="en" dir="ltr" spellcheck="false" >
<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/search.png" title="search"  alt="Search" style="border-width:0px;" id="ctl00_ctl00_TopHeader_SearchBox_btnImageButton" >
</form>	</div></div></div>
<div class="mainContent"><div class="mainInner"><div id="ctl00_ctl00_headerTopNavigation_menuElem_table">
<?php get_template_part( 'amenu', 'header' );?>
<table class="MainCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem" border="0" style="z-index:1000;">
		<tr>
			<td class="navigation home current" id="ctl00_ctl00_headerTopNavigation_menuElem-000" onclick="CSubmenuElem('<?php echo site_url(); ?>/');" onmousedown="this.className='MainCMSMenuHighlightedMenuItemMouseDown';" onmouseup="this.className='MainCMSMenuHighlightedMenuItemMouseUp';" onmouseover="MOvermenuElem(false, this,'','ctl00_ctl00_headerTopNavigation_menuElem','','','','','');this.className='navigation home';" onmouseout="skm_mousedOutMenu('ctl00_ctl00_headerTopNavigation_menuElem', this, '','navigation home ','','','','','');" style="cursor:pointer;"><a href="<?php echo site_url(); ?>/" class="hiddenTopNavLink">Home</a></td>
            <td class=" <?php if($menuid == 'about' || $uri_first == 'about') {echo 'top';} ?> navigation about" id="ctl00_ctl00_headerTopNavigation_menuElem-001" onclick="CSubmenuElem('<?php echo site_url(); ?>/about/');" onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-001-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-001-subMenu').style.display = 'none';" style="cursor:pointer;"><a href="<?php echo site_url(); ?>/about/" class="hiddenTopNavLink">About</a></td>
            <td class=" <?php if($menuid == 'programs' || $uri_first == 'programs') {echo 'top';} ?> navigation programs" id="ctl00_ctl00_headerTopNavigation_menuElem-002" onclick="CSubmenuElem('<?php echo site_url(); ?>/programs/');" onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu').style.display = 'none';" style="cursor:pointer;"><a href="<?php echo site_url(); ?>/programs/" class="hiddenTopNavLink">Programs</a></td>
            <td class=" <?php if($menuid == 'admissions' || $uri_first == 'admissions') {echo 'top';} ?> navigation admissions" id="ctl00_ctl00_headerTopNavigation_menuElem-003" onclick="CSubmenuElem('<?php echo site_url(); ?>/admissions/');"  onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-003-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-003-subMenu').style.display = 'none';"  style="cursor:pointer;"><a href="<?php echo site_url(); ?>/admissions/" class="hiddenTopNavLink">Admissions</a></td>
            <td class=" <?php if(($menuid == 'resources' && $uri_first != 'programs') || $uri_first == 'resources') {echo 'top';} ?> navigation resources" id="ctl00_ctl00_headerTopNavigation_menuElem-005" onclick="CSubmenuElem('<?php echo site_url(); ?>/resources/');"  onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu').style.display = 'none';"  style="cursor:pointer;"><a href="<?php echo site_url(); ?>/resources/" class="hiddenTopNavLink">Resources</a></td>
            <td class=" <?php if($menuid == 'partner-schools' || $uri_first == 'partner-schools') {echo 'top';} ?> navigation internationalStudents" id="ctl00_ctl00_headerTopNavigation_menuElem-004" onclick="CSubmenuElem('<?php echo site_url(); ?>/news/blog/');"  onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu').style.display = 'none';"  style="cursor:pointer;"><a href="<?php echo site_url(); ?>/news/blog/" class="hiddenTopNavLink">Student Stories</a></td>
            
            <td class=" <?php if($uri_first == 'news' || $uri_first == 'news') {echo 'top';} ?> navigation newsEvents" id="ctl00_ctl00_headerTopNavigation_menuElem-006" onclick="CSubmenuElem('<?php echo site_url(); ?>/news/');"  onmouseover="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-006-subMenu').style.display = 'block';"  onmouseout="document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-006-subMenu').style.display = 'none';"  style="cursor:pointer;"><a href="<?php echo site_url(); ?>/news/" class="hiddenTopNavLink">News</a></td>
			<td class=" <?php if($menuid == 'contact-us' || $uri_first == 'contact-us') {echo 'top';} ?> navigation contactUs" id="ctl00_ctl00_headerTopNavigation_menuElem-007" onclick="CSubmenuElem('<?php echo site_url(); ?>/contact-us/');" onmousedown="this.className='MainCMSMenuItemMouseDown';" onmouseup="this.className='MainCMSMenuItemMouseUp';" onmouseover="this.className='<?php if($menuid == 'contact-us' || $uri_first == 'contact-us') {echo 'top';} ?> navigation contactUs';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-007-subMenu').style.display = 'block';" onmouseout="skm_mousedOutMenu('ctl00_ctl00_headerTopNavigation_menuElem', this, '','<?php if($menuid == 'contact-us' || $uri_first == 'contact-us') {echo 'top';} ?> navigation contactUs','','','','','<?php echo get_template_directory_uri(); ?>/images/subMenuIndicator.png');document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-007-subMenu').style.display = 'none';" style="cursor:pointer;"><a href="<?php echo site_url(); ?>/contact-us/" class="hiddenTopNavLink">Contact Us</a></td>
            
		</tr>
	</table>
</div>
