<?php
/*
WP Post Template: Events Calendar
*/
?>
<?php if( get_field('event_url') ) : 
$event_url = get_field('event_url');
?>

<?php wp_redirect( $event_url, 301 ); exit; ?>
<?php endif; ?>
  <?php get_header(); ?>
<?php breadcrumbs(); ?>
   <?php if (have_posts()) : while (have_posts()) : the_post();
  ?>
  
  <div class="twoColumn firstColumn">

    <div class="eventDetails">
        <ul class="title">
            <li class="pageTitle">Event calendar</li>
            <li><a href="<?php echo site_url(); ?>/news-events/events-calendar/" title="Back to calendar" class="calendar">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtocalendar.png" alt="">
            </a></li>
            
            <li><span class="st_sharethis" displaytext="ShareThis"></span></li>
        </ul>       
        
        <div class="firstColumn">
            
<div>
	<h1> <?php the_title(); ?> </h1>
	
<?php the_content(); ?>
</div>  
        </div>
        <div class="secondColumn">
            <div class="registrationForm">
<div id="ctl00_ctl00_mainContent_columnOneContent_EventManager_pnlControl">
	
    <div class="EventManagerRegistration">
        <span id="ctl00_ctl00_mainContent_columnOneContent_EventManager_lblRegTitle" class="EventManagerRegTitle">Registration</span><br>
        
        

        <div id="ctl00_ctl00_mainContent_columnOneContent_EventManager_pnlReg">
        <div class="newsletter newsletter-subscription">
	    <?php  
							$date_picker_event = get_post_meta($post->ID, 'date_picker_event', true); 
							
							$today = date("Y-m-d", current_time( 'timestamp', 0 ));
					
			  				if($today < $date_picker_event){
				  				$iframe_event = get_post_meta($post->ID, 'iframe_event', true);  if ($iframe_event){echo $iframe_event;}
			  				} else {
				  				$event_end = get_post_meta($post->ID, 'event_end', true);  if ($event_end){echo $event_end;}else{ echo "Sorry, registration is now closed.";}
			  				}
							?>
        
            				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header') ) : ?>
        					<?php endif; ?>
        </div>
	</div>

    </div>

</div>
</div>
           
        </div>
        </div>
  
    <a href="#" target="_top" class="eventDetails toTop">
        <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
    </a>

    </div>
  
  
  
  
 
  


  <?php endwhile; ?>

<?php endif; ?>

<?php get_template_part( 'right', 'sidebar' );?>
</div>
<?php get_footer();?>

