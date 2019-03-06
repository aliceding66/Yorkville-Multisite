<?php get_header(); ?>
<div id="fb-root"></div>
<!-- Facebook Feed code -->
<script type="text/javascript">
(function (d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) { return; }
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
fjs.parentNode.insertBefore(js, fjs);
} (document, 'script', 'facebook-jssdk'));
</script>
<div class="carousel home">

<a id="slideArrowLeft" onclick="slideLeft();return false;" href=""></a>
<a id="slideArrowRight" onclick="slideRight();return false;" href=""></a>

<ul class="carouselList">            
<?php 
  $postids = array();
  $my_query = new WP_Query('posts_per_page=10&cat=5&orderby=id&order=ASC&post_status=publish');
  if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
  $postids[]= $post->ID;
  $imgs = get_the_post_thumbnail($post->ID); 
  $slider_url = get_post_meta($post->ID, 'slider_url', true); 
?>
<li class="carouselItem" id="">
<a class="carouselLink" href="<?php echo site_url(); ?><?php echo $slider_url; ?>" Title='<?php the_title(); ?>'/><?php echo $imgs ?></a>
</li>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
</ul>

<div class="calloutContainer">
<a id="ctl00_ctl00_mainContent_ctl00_btnRequestInfo" class="requestInfo home" href="<?php echo site_url(); ?>/contact-us/request-information/"></a>
<a onclick="window.open('http://application.yorkvilleu.ca/(S(htmzcr55iycbqy453q5udt45))/ORG/RCC/Application/YU_Login.aspx');return false;" id="ctl00_ctl00_mainContent_ctl00_btnApplyNow" class="applyNow home" href="javascript:__doPostBack('ctl00$ctl00$mainContent$ctl00$btnApplyNow','')"></a>
</div> 
</div>

    <div class="twoColumn firstColumn home">
        <div class="about home">
            <img class="about title home" src="<?php echo get_template_directory_uri(); ?>/images/homeabout.png" alt="About the School" title="About the School" />
            <div class="aboutContent home">
               <?php the_content(); ?>
				<p><a title="About" class="aboutContent more" href="<?php echo site_url(); ?>/about/">MORE</a></p>
            </div>
            <div class="takeTour home">
                <a id="ctl00_ctl00_mainContent_lnkTakeaTour" title="Student Stories" href="<?php echo site_url(); ?>/discover-yorkville-university/"><img src="<?php echo get_template_directory_uri(); ?>/images/takeatour.png" alt="Student Stories" title="Student Stories" /></a>
            </div>
        </div>
         <div class="upcomingEvents home" >
            <p class="eventsFacebookTitle">BLOG POSTS</p>
           <?php
			$args = array( 'posts_per_page' => '3', 'orderby'=> post_date, 'category' => '6' );
			$myposts = get_posts( $args );
			foreach ( $myposts as $post ) : setup_postdata( $post ); 
			$home_feed = get_post_meta($post->ID, 'home_feed', true); if($home_feed[0] == 'on'){ ?> 
           <p class="upcomingEvent home"><img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>">
           <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
           </p>
           <?php } endforeach; wp_reset_postdata();?>
            <p class="viewCalendar home"><a href="<?php echo site_url(); ?>/news/blog/" title="MORE">MORE</a></p>
        </div>

        <div class="facebookFeed home">
            <p class="eventsFacebookTitle home">PRESS RELEASES</p>
			<?php 
			$args = array( 'posts_per_page' => '3', 'category_name' => 'press-releases', 'order'=>'DESC', 'orderby'=>'ID' );
			$myposts = get_posts( $args );
			//echo 'andy';
			//var_dump($myposts);
			foreach ( $myposts as $post ) : setup_postdata( $post ); 
				$home_feed = get_post_meta($post->ID, 'home_feed', true); 
				//if($home_feed){ ?> 
				<p class="upcomingEvent home">
					<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</p>
				<?php //} ?>
			<?php 
			endforeach; 
			wp_reset_postdata();
			?>
		   
            <p class="viewCalendar home"><a href="<?php echo site_url(); ?>/news/press-releases/" title="MORE">MORE</a></p>
            
        </div>
    </div>

    <div class="twoColumn secondColumn home">
        <img class="programs title home" src="<?php echo get_template_directory_uri(); ?>/images/programs.png" alt="Programs" title="Programs" />        
        <?php 
			$program_1_img = get_post_meta($post->ID, 'program_1_img', true);
			$program_2_img = get_post_meta($post->ID, 'program_2_img', true);  
			$program_3_img = get_post_meta($post->ID, 'program_3_img', true);  
			$program_4_img = get_post_meta($post->ID, 'program_4_img', true);
			$program_5_img = get_post_meta($post->ID, 'program_5_img', true);
			$program_1_url = get_post_meta($post->ID, 'program_1_url', true);
			$program_2_url = get_post_meta($post->ID, 'program_2_url', true);  
			$program_3_url = get_post_meta($post->ID, 'program_3_url', true);  
			$program_4_url = get_post_meta($post->ID, 'program_4_url', true);
			$program_5_url = get_post_meta($post->ID, 'program_5_url', true);  
			$program_1_title = get_post_meta($post->ID, 'program_1_title', true);
			$program_2_title = get_post_meta($post->ID, 'program_2_title', true);  
			$program_3_title = get_post_meta($post->ID, 'program_3_title', true);  
			$program_4_title = get_post_meta($post->ID, 'program_4_title', true); 
			$program_5_title = get_post_meta($post->ID, 'program_5_title', true); 
		?>
<?php  if($program_1_img && $program_1_url && $program_1_title){?>
<p class="programItem">
	<a href="<?php  echo $program_1_url ?>" title="<?php  echo $program_1_title ?>">
	<img src="<?php  echo $program_1_img ?>" alt="<?php  echo $program_1_title ?>" title="<?php  echo $program_1_title ?>">
	</a>
	<a href="<?php  echo $program_1_url ?>" class="programItemLink" title="<?php  echo $program_1_title ?>">
	<?php  echo $program_1_title ?>
	</a>
</p>
<?php } ?>

<?php  if($program_2_img && $program_2_url && $program_2_title){?>
<p class="programItem">
	<a href="<?php  echo $program_2_url ?>" title="<?php  echo $program_2_title ?>">
	<img src="<?php  echo $program_2_img ?>" alt="<?php  echo $program_2_title ?>" title="<?php  echo $program_2_title ?>">
	</a>
	<a href="<?php  echo $program_2_url ?>" class="programItemLink" title="<?php  echo $program_2_title ?>">
	<?php  echo $program_2_title ?>
	</a>
</p>
<?php } ?>

<?php  if($program_3_img && $program_3_url && $program_3_title){?>
<p class="programItem">
	<a href="<?php  echo $program_3_url ?>" title="<?php  echo $program_3_title ?>">
	<img src="<?php  echo $program_3_img ?>" alt="<?php  echo $program_3_title ?>" title="<?php  echo $program_3_title ?>">
	</a>
	<a href="<?php  echo $program_3_url ?>" class="programItemLink" title="<?php  echo $program_3_title ?>">
	<?php  echo $program_3_title ?>
	</a>
</p>
<?php } ?>

<?php  if($program_4_img && $program_4_url && $program_4_title){?>
<p class="programItem">
	<a href="<?php  echo $program_4_url ?>" title="<?php  echo $program_4_title ?>">
	<img src="<?php  echo $program_4_img ?>" alt="<?php  echo $program_4_title ?>" title="<?php  echo $program_4_title ?>">
	</a>
	<a href="<?php  echo $program_4_url ?>" class="programItemLink" title="<?php  echo $program_4_title ?>">
	<?php  echo $program_4_title ?>
	</a>
</p>
<?php } ?>

<?php  if($program_5_img && $program_5_url && $program_5_title){?>
<p class="programItem">
	<a href="<?php  echo $program_5_url ?>" title="<?php  echo $program_5_title ?>">
	<img src="<?php  echo $program_5_img ?>" alt="<?php  echo $program_5_title ?>" title="<?php  echo $program_5_title ?>">
	</a>
	<a href="<?php  echo $program_5_url ?>" class="programItemLink" title="<?php  echo $program_5_title ?>">
	<?php  echo $program_5_title ?>
	</a>
</p>
<?php } ?>
</div>
<div style="clear: both;"></div>
</div>
</div>
<?php  get_footer();?>
