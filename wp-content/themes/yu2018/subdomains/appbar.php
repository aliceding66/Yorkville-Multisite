<?php
/*
Template Name: appbar.yorkvilleu.ca
*/

//require_once __DIR__ . '/../header.php'; 
//get_header(); 
require_once __DIR__ . '/../yorkville_dev_production_manager.php'; 

$source = "http://".$YORKVILLE['home']."/wp-content/themes/yu2018/appbar";

wp_head();
$APPBAR_USER = get_user_by( 'ID', $_GET['uid'] );
//var_dump(wp_get_current_user());

add_filter('show_admin_bar', '__return_false');


?>

<link rel="stylesheet" href="<?php echo $source; ?>assets/css/appbar.css">

<div id="YuAppBar" class="appbar" style="z-index:100 !important;">
	
		<!-- MyYU -->		
		<a href="//<?php echo $YORKVILLE['my']; ?>" >
		
			
			<!-- MY YU Desktop -->
			<div class="yu-btn yu-btn-small responsive_desktop" style="width:120px; height:80px; float:left; margin:0;" >
				<div class="highlight"></div>
				<div class="content">
					<h3><?php if($YORKVILLE['home'] == "yorkvilleu.dev"){?>My DEV<?php }else{ ?>MyYU<?php } ?></h3>
				</div>
			</div>
			
			<!-- Responsive
			<div class="yu-btn yu-btn-small responsive_mobile" style="width:100px;  height:80px; float:left; margin:0;" >
				<div class="highlight"></div>
				<div class="content">
					<h3>MyYU</h3>
				</div>
			</div>
			 -->
			
		</a>
	
		<!-- SEARCH Desktop -->
		<div class="responsive_desktop">
			<form action="http://askyu.yorkvilleu.dev/home" method="GET">
				<input type="text" placeholder="AskYU a Question..." name="search" class="askyu_seach_bar" style="display:inline; position:absolute;"/>
			</form>
		</div>
		
		<!-- Logo -->
		<center>
			<a href="http://yorkvilleu.dev">
				<img id="yorkville_brand_logo" class="responsive_desktop" src="/wp-content/themes/yu2018/img/YorkvilleU.png" style="position:absolute; left:37%;" />
			</a>
		</center>
	
		<!-- User Menu -->
		<?php if( $APPBAR_USER ){ ?>
			<a href="http://azure.yorkvilleu.ca/wp-login.php?redirect_to=http://azure.yorkvilleu.ca/my" id="appbar_userMenu" class="responsive_desktop" style="float:right;">
			<div class="yu-btn yu-btn-small" style="width:200px; height:80px; margin:0;">
				<div class="highlight"></div>
				<div class="content">
					<h3><?php echo $APPBAR_USER->data->display_name; ?></h3>
				</div>
			</div>
		</a>
		<?php }else{ ?>
			<a href="http://azure.yorkvilleu.ca/wp-login.php?redirect_to=http://azure.yorkvilleu.ca/my" id="appbar_userMenu" class="responsive_desktop" style="float:right;">
			<div class="yu-btn yu-btn-small" style="width:200px; height:80px; margin:0;">
				<div class="highlight"></div>
				<div class="content">
					<h3>LOG IN</h3>
				</div>
			</div>
		</a>
		<?php } ?>
		
		
		
		<!-- User Photo -->
		<?php if( $APPBAR_USER ){ ?>
			<img height=80 width=80 id="appbar_user" src="<?php echo get_avatar_url( $APPBAR_USER->data->user_email, 1 ); ?>" style="float:right;"/>
		<?php }else{ ?>
			<img id="appbar_user" src="<?php echo $source; ?>assets/img/users/user.png" style="float:right;"/>
		<?php } ?>
		<!-- Help
		<a href="#" id="appbar_help" class="responsive_desktop"  onClick="introJs().start();" style="float:right;">
			<div class="yu-btn yu-btn-small" style="width:100px; height:80px;  margin:0;">
				<div class="highlight"></div>
				<div class="content">
					<h3>HELP</h3>
				</div>
			</div>
		</a>
		 -->	
		
	
</div>