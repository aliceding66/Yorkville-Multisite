<?php
$children = get_pages('child_of='.$post->ID);
//if( count( $children ) != 0 ) { 

$post_slug=$post->post_name;
$post_parent = $post->post_parent;
$post_parent_id = get_post($post_parent);
$post_parent_slug=$post_parent_id->post_name;


?>


<style>


.menu-bottom a{ display:none;}
.menu-item-3048 li a, .menu-item-3049 li a{display:none!important;}
.menu-bottom li.menu-item-<?php echo $post_slug ?>.current-menu-item.menu-item-has-children>a{ display:none !important;}
.menu-bottom li.current-menu-parent.menu-item-has-children>a{ display:none !important;}

<?php if($post_slug == "request-information"){ ?>
.menu-bottom li.menu-item-2969>ul>li>a{display:none!important;}
<?php } ?>
<!--
<?php if($post_parent_slug == "scholarships"){ ?>
.menu-item-3079 li a{display:block!important;}
<?php } ?>
<?php if($post_slug != "financial-aid" && $post_parent_slug != "financial-aid"){ ?>
.menu-bottom li.current-menu-parent.menu-item-3025>ul>li>a{display:block!important;}
<?php } ?>
<?php if($post_parent_slug == "financial-aid"){ ?>
.menu-bottom li.menu-item-3050>ul>li>a{display:block!important;}
<?php } ?>
<?php if($post_slug == "tuition-fees-financial-aid" && $post_parent_slug == "faculty-of-education"){ ?>
.menu-bottom .menu-item-faculty-of-education>ul>li>a{display:block!important;}
<?php } ?>
-->
<?php if($post_slug == "general"){ ?>
#menu-item-4094, #menu-item-4093, #menu-item-4092, #menu-item-4091{display:none!important;}
<?php } ?>
<?php if($post_slug == "specialization-in-accounting"){ ?>
#menu-item-4090, #menu-item-4093, #menu-item-4092, #menu-item-4091{display:none!important;}
<?php } ?>
<?php if($post_slug == "specialization-in-energy-management"){ ?>
#menu-item-4094, #menu-item-4090, #menu-item-4092, #menu-item-4091{display:none!important;}
<?php } ?>
<?php if($post_slug == "specialization-in-project-management"){ ?>
#menu-item-4094, #menu-item-4093, #menu-item-4090, #menu-item-4091{display:none!important;}
<?php } ?>
<?php if($post_slug == "specialization-in-supply-chain-management"){ ?>
#menu-item-4094, #menu-item-4093, #menu-item-4092, #menu-item-4090{display:none!important;}
<?php } ?>

.menu-bottom li.menu-item-<?php echo $post_slug ?>.current-menu-item>ul.sub-menu>li>a{ display:block;}
.menu-bottom ul>li.current-page-ancestor>ul li.current-page-ancestor.current-menu-item>ul>li>a{ display:block ;}

.menu-bottom ul>li.current-page-ancestor>ul>li>ul>li.current-page-ancestor.current-menu-parent.menu-item-has-children>ul>li>a{ display:block ;}


.menu-bottom ul>li.current-menu-parent.menu-item-about>ul>li>a{ display:block;}
.menu-bottom ul>li.current-menu-parent.menu-item-admissions>ul>li>a{ display:block;}

</style>
<div class="menu-bottom">

<?php  
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'mobile-programs',//change ul id
			'link_before'     => '<span>',
			'link_after'      => '</span>',
			'depth'           => 0,
			'theme_location'  => 'mobile-programs' 
			
		);
		wp_nav_menu( $defaults); ?>
</div>
<?php //} ?>
