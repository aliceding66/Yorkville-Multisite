<?php 
$menuid = get_slug_for_menu_custume()->post_name; 
$uri = $_SERVER["REQUEST_URI"];
$uri_array = explode("/",$uri);
$uri_first = $uri_array[2];
?>
<!-- ---------------- BEGIN About MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-001-subMenu" border="0" style="display: none; z-index: 1002; position: absolute; margin-left: 75px; top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-001').className='top navigation about';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-001').className='navigation about <?php if($menuid == 'about' || $uri_first == 'about') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $about_menu = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'about-menu',
			'menu'=>'About Menu',
			
		);
		wp_nav_menu( $about_menu); v?>
			</td>
        <tr>
	</table>
<!-- ---------------- END About MENU ----------------- -->	


<!-- ---------------- BEGIN Programs MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-002-subMenu" border="0" style="display: none; z-index: 1006; position: absolute; margin-left: 164px; top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-002').className='top navigation programs';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-002').className='navigation programs <?php if($menuid == 'programs' || $uri_first == 'programs') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $programs = array(
			
			'menu_class'      =>'about-menu programsmenu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'programs', 'menu'=>'Programs'
			
		);
		wp_nav_menu( $programs); ?>
			</td>
        <tr>
	</table>
<!-- ---------------- END Programs MENU ----------------- -->


<!-- ---------------- BEGIN Admissions MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-003-subMenu" border="0" style="display: none; z-index: 1020; position: absolute; margin-left: 282px; top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-003').className='top navigation admissions';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-003').className='navigation admissions <?php if($menuid == 'admissions' || $uri_first == 'admissions') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $admissions = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'admissions', 'menu'=>'Admissions' 
			
		);
		wp_nav_menu( $admissions); ?>
			</td>
        <tr>
	</table>
<!-- ---------------- END Admissions MENU ----------------- -->

<!-- ---------------- BEGIN Resources MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-005-subMenu" border="0" style="display: none; z-index: 1032; position: absolute; margin-left: 408px;top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-005').className='top navigation resources';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-005').className='navigation resources <?php if(($menuid == 'resources' && $uri_first != 'programs') || $uri_first == 'resources') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $resources = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'resources' , 'menu'=>'Resources'
			
		);
		wp_nav_menu( $resources); ?>
			</td>
        <tr>
	</table>
		
<!-- ---------------- END Resources MENU ----------------- -->


<!-- ---------------- BEGIN International Students MENU ----------------- -->
	<!--<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-004-subMenu" border="0" style="display: none; z-index: 1022; position: absolute; margin-left: 530px;top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-004').className='top navigation internationalStudents';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-004').className='navigation internationalStudents <?php if($menuid == 'partner-schools' || $uri_first == 'partner-schools') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $international_students = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'partner-schools' , 'menu'=>'Partner Schools'
			
		);
		wp_nav_menu( $international_students); ?>
			</td>
        <tr>
	</table>
-->
<!-- ---------------- END International Students MENU ----------------- -->


<!-- ---------------- BEGIN News & events MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-006-subMenu" border="0" style="display: none; z-index: 1038; position: absolute; margin-left: 759px; top: 137px;"  onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-006').className='top navigation newsEvents';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-006').className='navigation newsEvents <?php if($uri_first == 'News' || $uri_first == 'news') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $news_events = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'news' , 'menu'=>'News'
			
		);
		wp_nav_menu( $news_events); ?>
			</td>
        <tr>
	</table>
<!-- ---------------- END News & events MENU ----------------- -->	
    
	
	
<!-- ---------------- BEGIN CONTACT US MENU ----------------- -->
	<table class="SubCMSMenu" cellspacing="0" cellpadding="0" id="ctl00_ctl00_headerTopNavigation_menuElem-007-subMenu" border="0" style="display: none; z-index: 1040; position: absolute; margin-left: 841px;top: 137px;" onmouseover="this.style.display = 'block';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-007').className='top navigation contactUs';" onmouseout="this.style.display = 'none';document.getElementById('ctl00_ctl00_headerTopNavigation_menuElem-007').className='navigation contactUs <?php if($menuid == 'contact-us' || $uri_first == 'contact-us') {echo 'top';} ?>';">
		<tr >
			<td>
			<?php  
        $contact_us = array(
			
			'menu_class'      =>'about-menu',// change ul class
			'menu_id'         =>'about-menu',//change ul id
			'depth'           => 0,
			'walker'  => new ik_walker(),
			'theme_location'  => 'contact-us' , 'menu'=>'Contact Us'
			
		);
		wp_nav_menu( $contact_us); ?>
			</td>
        <tr>
	</table>
<!-- ---------------- END CONTACT US MENU ----------------- -->	
