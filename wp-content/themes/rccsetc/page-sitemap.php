<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 



                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                      
      <div class="firstColumn oneColumn">
        <div class="title interior"> 
          <h1><?php the_title(); ?></h1>
        </div>

<div class="sitemapli">
	<ul class="CMSSiteMapList li_cont1" style="float: left; width: 400px;">
		<li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/" title="Home" class="CMSSiteMapLink">Home</a></li>
		<li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/about/" title="About" class="CMSSiteMapLink">About</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'about-menu'); wp_nav_menu( $defaults); ?>
		</li>
        <li class="CMSSiteMapListItem programli"><a href="<?php echo site_url(); ?>/programs/" title="Programs" class="CMSSiteMapLink">Programs</a>
        	<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'programs'); wp_nav_menu( $defaults); ?>
        </li>
       
	</ul> 
    <ul class="CMSSiteMapList li_cont1">
     <li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/admissions/" title="Admissions" class="CMSSiteMapLink">Admissions</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'admissions'); wp_nav_menu( $defaults); ?>
		</li>
  		<li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/international-students/" title="International Students" class="CMSSiteMapLink">International Students</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'international-students'); wp_nav_menu( $defaults); ?>
		</li>
        <li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/resources/" title="Resources" class="CMSSiteMapLink">Resources</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'resources'); wp_nav_menu( $defaults); ?>
		</li>
    	<li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/news-events/" title="News & Events" class="CMSSiteMapLink">News & Events</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'news-events'); wp_nav_menu( $defaults); ?>
		</li>
        <li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/contact-us/" title="Contact Us" class="CMSSiteMapLink">Contact Us</a>
			<?php  $defaults = array('menu_class' =>'CMSSiteMapList', 'container'=>' ', 'menu_id'=>' ', 'depth'=>0, 'theme_location'=>'contact-us'); wp_nav_menu( $defaults); ?>
		</li>
        <li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/privacy-statement/" title="Privacy Statement" class="CMSSiteMapLink">Privacy Statement</a></li>
        <li class="CMSSiteMapListItem"><a href="<?php echo site_url(); ?>/copyright-notice/" title="Copyright Notice" class="CMSSiteMapLink">Copyright Notice</a></li>
    	<?php the_content(); ?>
     </ul> 
        
		
</div>                  

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>       
       
     <?php endwhile;?>
    <?php endif;?>
    
<div style="clear: both;"></div>

            </div>
         
        </div>
       
       
<?php  get_footer();?>