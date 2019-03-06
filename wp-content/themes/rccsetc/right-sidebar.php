<div class="thirdColumn threeColumn">
            

<div class="calloutContainer">


    
    <a id="ctl00_ctl00_mainContent_ctl00_btnRequestInfo" class="requestInfo" href="<?php echo site_url(); ?>/contact-us/request-information/"></a>

    <a onclick="window.open(&#39;http://application.rccit.ca/ORG/RCC/Application/SETC_Login.aspx&#39;);return false;" id="ctl00_ctl00_mainContent_ctl00_btnApplyNow" class="applyNow" href="javascript:__doPostBack('ctl00$ctl00$mainContent$ctl00$btnApplyNow','')"></a>
</div>
            

<div class="upcomingEvents">

    
    <p class="eventsFacebookTitle">UPCOMING EVENTS</p>

 <?php 
   $today = date("Y-m-d", current_time( 'timestamp', 0 ));
	
	$args = array(
        'cat' => '15',  
		'meta_key' => 'date_picker_event',
		'posts_per_page' => 3,
        'meta_query' => array(
            array(
                'key' => 'date_picker_event',
                'value' => $today,
                'compare' => '>'
           )
        ),
		'orderby' => 'meta_value',
		'order' => 'ASC'
    );
	
  $wp_query   = NULL;
  $wp_query  = new WP_Query($args);
  
  if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
  $my_query_posts = $wp_query->found_posts;
  
  
?>

<p class="upcomingEvent interior"><img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>" /><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?><br /><?php $event_date = get_post_meta($post->ID, 'date_picker_event', true);  $newDate = date("d F Y h:i A", strtotime($event_date)); echo $newDate; ?></a></p>

<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>

    <p class="viewCalendar">
        <a href="<?php echo site_url(); ?>/news-events/events-calendar/" title="View Calendar">VIEW CALENDAR</a>
    </p>

    
    
</div>
  
              
            
            <div class="columnThreeSideImage"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/images/thirdcolumnbottomgradient.jpg">
        </div>  