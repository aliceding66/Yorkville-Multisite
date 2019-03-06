<?php get_header(); ?>
<?php get_template_part( 'menu', 'top' );?>
<div id="page-wrap">

<?php
$children = get_pages('child_of='.$post->ID);
//if( count( $children ) != 0 ) { 

$post_slug=$post->post_name;

?>


<style>
.menu-bottom a{ display:none;}

.menu-bottom li.menu-item-<?php echo $post_slug ?>.current-menu-item>ul.sub-menu>li>a{ display:block !important;}
.menu-bottom ul>li.current-page-ancestor>ul li.current-page-ancestor>ul>li>a{ display:block !important;}

.menu-bottom ul>li.current-menu-parent.menu-item-about>ul>li>a{ display:block !important;}
.menu-bottom ul>li.current-menu-parent.menu-item-admissions>ul>li>a{ display:block !important;}

</style>
<div class="menu-bottom programs">

<?php  
$text = "Master of Arts in Counselling Psychology";
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'mobile-programs',//change ul id
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 0,
			'theme_location'  => 'mobile-programs' 
			
		);
		wp_nav_menu( $defaults); ?>
</div>
<?php //} ?>


<?php get_footer(); ?>