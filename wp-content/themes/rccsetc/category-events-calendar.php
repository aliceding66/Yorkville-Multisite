<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

                <!-- Page Content -->         
     
         <div class="event firstColumn">
			<div class="title interior">
            	<h1><?php echo single_cat_title(); ?></h1>
            	<span class="st_sharethis" displaytext="ShareThis"></span>
        	</div>
               
            
<?php echo category_description(); ?>
<a href="<?php echo site_url(); ?>/news-events/" title="News &amp; Events" class="backToNews">Back to News &amp; Events<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt="Back to News &amp; Events" title="Back to News &amp; Events"> </a>
<br /><br />
<?php 
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $posts_per_page = "100";

  $today = date("Y-m-d", current_time( 'timestamp', 0 ));

  // THIS LOGIC MUST BE RE-CHECKED, IT APPEARS BROKEN
  $args = array(
        'cat' => '15',  
		'meta_key' => 'date_picker_event',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'date_picker_event',
                'value' => $today,
                'compare' => '<'
           )
        ),
		'orderby' => 'meta_value',
		'order' => 'ASC'
    );

  $wp_query  = new WP_Query($args);

// Fixed by Andy
$wp_query = new WP_Query( array(
  'post_status' => array( 'publish' ),
  'meta_key' => 'show_event_on_website',
  'meta_value' => 'yes',
 ));
  
  if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
  $my_query_posts = $wp_query->found_posts;
  
  $event_url = get_post_meta($post->ID, 'event_url', true);
?>

<ul class="BlogPDateWhole" style="clear:both"> 
    <li class="post_date_calendar" ><?php $event_date = get_post_meta($post->ID, 'date_picker_event', true);  $newDate = date("d F Y h:i A", strtotime($event_date)); echo $event_date ?> </li>
	<li class="post_name_calendar"> <?php the_title(); ?></li>
	<li class="readBlog"> <a href="<?php if($event_url){echo $event_url;}else{ echo get_permalink();} ?>" target="_blank">RSVP</a></li>
</ul>

<?php endwhile; ?>
<?php //if(function_exists('wp_paginate') && $my_query_posts > $posts_per_page) { wp_paginate($wp_query);}?>
<?php endif; ?>
<?php wp_reset_query(); ?>

<style>
.BlogPDateWhole{ border-bottom:1px solid #ddd; margin:0px; padding:0; font-size:14px}
.BlogPDateWhole .readBlog {margin-top:5px;margin-bottom:5px;}
.BlogPDateWhole li{  padding:10px 10px 10px 0;margin-top:2px;margin-top:1px;}
.post_date_calendar{  color: #0397d6; }
</style>
<a href="<?php echo site_url(); ?>/news-events/" title="News &amp; Events" class="backToNews">Back to News &amp; Events<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt="Back to News &amp; Events" title="Back to News &amp; Events"> </a>

<a href="#" target="_top" class="toTop"><img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top"></a>
</div>
       

    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>
