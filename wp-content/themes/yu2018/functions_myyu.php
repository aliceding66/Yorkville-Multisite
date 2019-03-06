<?php

// [get_moodle_api]
// 

function get_moodle_api_function( ){
	
	global $wpdb;
	
	
	if($_GET['action'] != "updateIsOnlineAtYorkville"){
		//echo "Unauthorized";
		$test='Unauthorized';
		var_dump($test);
		return;
		die;
		exit;
	}
	var_dump( strpos( $_GET['email'],'@') );
	if( strpos($_GET['email'],'@') === false){
		
		/*
	    this piece of code would work well for an EXISTING user, but some times the user will not exist, 
		so we will store a token anyway based on that email
		
		$query_current_email = "SELECT * FROM wp_usermeta WHERE metakey='ysis_data' AND user_id=".get_current_user_id(); 
	
		$current_email = $wpdb->get_results($query_current_ysis);
		
		if (isset($current_email[0]->meta_value)){
			$verified_ysis = json_decode($current_email[0]->meta_value);
			$verified_email = $verified_ysis["Email"];
			if (strtolower($verified_email) == strtolower($_GET['email'])) {}
			else {
				//echo "Unauthorized";
				$test='Unauthorized';
				var_dump($test);
				return;
				die;
				exit;
			}
		}
		else {
			//echo "Unauthorized";
			$test='Unauthorized';
			var_dump($test);
			return;
			die;
			exit;
			
		}
		
		*/
	
		//echo "Unauthorized";
		$test='Unauthorized-InvalidEmail';
		var_dump($test);
		return;
		die;
		exit;
	
	}
	
	if (($_GET['status'] != "true") && ($_GET['status'] != "false")) {
		//echo "Unauthorized";
		$test='Unauthorized';
		var_dump($test);
		return;
		die;
		exit;
	}
	
	$current_user_id = get_current_user_id();
	var_dump($current_user_id);
	$query_current_ysis = "SELECT * FROM wp_usermeta WHERE meta_key='ysis_data' AND user_id=".get_current_user_id(); 
	var_dump($query_current_ysis);
	$current_ysis = $wpdb->get_results($query_current_ysis);
	var_dump($current_ysis[0]->meta_value);

	
	// setup the isOnlineAtYorkvilleu value
	if (isset(current_ysis[0])){
		update_user_meta($current_user_id,'isOnlineAtYorkvilleu', 'true');
		$status_moodleapi = 'success';
		var_dump($status_moodleapi);
	}
	else {
		update_user_meta($current_user_id,'isOnlineAtYorkvilleu', 'false');
		$status_moodleapi = 'false';
		var_dump($status_moodleapi);
	}

	
	
	update_user_meta( get_current_user_id(),'isOnlineAtYorkvilleu', $_GET['status']);
	$status_moodleapi = 'success';
	var_dump($status_moodleapi);
	
	$isOnlineAtYorkvilleu = get_user_meta( $current_user_id, "isOnlineAtYorkvilleu", true ); 
	var_dump("isOnlineAtYorkvilleu=".$isOnlineAtYorkvilleu);


}

add_shortcode( 'get_moodle_api', 'get_moodle_api_function' );

// return true if isOnlineAtYorkvilleu exists in user_meta table
function isOnlineAtYorkvilleu() {
	
	$current_user_id = get_current_user_id();
	
	$is_online_YU = get_user_meta($current_user_id, 'isOnlineAtYorkvilleu');
	
	if ($is_online_YU === 'true') {
		return true;
	}
	
	return false;
}

// ==================
// MyYU TAGGED POSTS
// ==================
//[myyu_tagged_posts]

function myyu_featured_news_function( $attributes ){

$current_user = wp_get_current_user();

$isOnlineAtYorkvilleu = get_user_meta( $current_user->ID, "isOnlineAtYorkvilleu", true ); 


	?>
	
		
			<div class="grid-container">
				<div class="grid-x grid-padding-x grid-margin-y home-queries ">
				
					<?php
					
					$post_attributes = shortcode_atts( array(
						'count' => '9',
					), $attributes );
					
					$posts = get_posts(array(
						'posts_per_page' => $post_attributes['count'],
						'category' => get_category_by_slug("Featured")->term_id,
						'orderby' => 'date',
					));
					
				
					foreach($posts as $post){
					
						$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
						if(get_the_post_thumbnail_url($post->ID,array(256,256))){
							$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
						}
						
						$meta = get_post_meta($post->ID);
						
						$social_type = $meta['social_type'][0];
						$link_url = $meta['link_url'][0];
						
						$user_link_source = $link_url;
						if(!$link_url){
							$user_link_source = get_permalink( $post->ID );
						}
					
						?>
						
							<div class="cell small-12 medium-6 large-4 myyu_featured_article">
								<a href="<?php echo $user_link_source; ?>" target="_blank">
								
									<div style="background:url('<?php echo $img_source; ?>') no-repeat center; background-size:cover;" class="feature_image" >
									
									
										
										<div class="feature_title">
											
											<?php if($social_type){ ?>
											
												<?php if($social_type == "none"){ ?>
													
												<?php } ?>
									
												<?php if($social_type == "blog"){ ?>
													<div class="feature_type">
														<i class="fas fa-rss-square"></i> Blog
													</div>
												<?php } ?>
												
												<?php if($social_type == "event"){ ?>
													<div class="feature_type">
														<i class="far fa-calendar-alt"></i> Event
													</div>
												<?php } ?>
												
												<?php if($social_type == "link"){ ?>
													<div class="feature_type">
														<i class="fas fa-external-link-alt"></i> Link
													</div>
												<?php } ?>
												
												<?php if($social_type == "tip"){ ?>
													<div class="feature_type">
														<i class="far fa-lightbulb"></i> Tip
													</div>
												<?php } ?>
												
												<?php if($social_type == "facebook"){ ?>
													<div class="feature_type">
														<i class="fab fa-facebook"></i> Facebook
													</div>
												<?php } ?>
												
												<?php if($social_type == "linkedin"){ ?>
													<div class="feature_type">
														<i class="fab fa-linkedin"></i> LinkedIn
													</div>
												<?php } ?>
												
												<?php if($social_type == "twitter"){ ?>
													<div class="feature_type">
														<i class="fab fa-twitter-square"></i> Twitter
													</div>
												<?php } ?>
												
												<?php if($social_type == "youtube"){ ?>
													<div class="feature_type">
														<i class="fab fa-youtube"></i> YouTube
													</div>
												<?php } ?>
												
												<?php if($social_type == "instagram"){ ?>
													<div class="feature_type">
														<i class="fab fa-instagram"></i> Instagram
													</div>
												<?php } ?>
												
											<?php } ?>
										
											<?php echo $post->post_title; ?>
										</div>
										
									</div>
								
								</a>
							</div>
							
								<!--
								<div class="post post-event">
									<div class="grid-x grid-margin-y grid-padding-x">
										<div class="cell small-12 large-4">
											<div class="event-image-wrapper">
												<a href="<?php echo get_permalink( $post->ID ); ?>">
													<img src="<?php echo $img_source; ?>" class="img-responsive"> 
													
													<div class="event-date">
														<p><?php echo $meta['event_month'][0]; ?></p>
														<p><?php echo $meta['event_day'][0]; ?></p>
													</div>
												</a>
											</div>
										</div>
										<div class="cell small-12 large-8">
											<div class="event-details">
												<a class="post-title underline" href="events-single.php">
													<?php echo $post->post_title; ?>
												</a>
												<?php if($event_cost){ ?> <p><i class="fa fa-usd" aria-hidden="true"></i> <?php echo $meta['event_cost'][0]; ?></p> <?php } ?>
												<p><?php echo($post->post_excerpt); ?></p>
												<?php if($event_time){ ?> <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $meta['event_time'][0]; ?></p> <?php } ?>
												<?php if($event_address){ ?> <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $meta['event_address'][0]; ?></p> <?php } ?>
											</div>
										</div>
									</div>
								</div>
								-->
					
						<?php
						}
						wp_reset_postdata();
						?>
				
				</div>
			</div>
			
		
	<?php
	
}
add_shortcode( 'myyu_featured_news', 'myyu_featured_news_function' );

// ==================
// MyYU TAGGED POSTS
// ==================
//[myyu_tagged_posts]

function myyu_tagged_posts_function( $atts ){

	global $wpdb;
	$post_counter = 0;
	
	$myyu_post_ids = [];
	
	
	$sites = get_sites();
	foreach($sites as $site){

		switch_to_blog($site->blog_id);

		if($site->blog_id == 1){
			$site_sql = "wp_posts";
		}else{
			$site_sql = "wp_".$site->blog_id."_posts";
		}

		$sql = 'SELECT ID FROM '.$site_sql.' WHERE post_type = "post"';
		$results =  $wpdb->get_results($sql, ARRAY_N);

		if(count($results) >= 1){

			$post_ids = [];

			foreach($results as $key => $array){
				array_push($post_ids, $array[0]);
			}
			$posts = get_posts(array(
				'post__in' => $post_ids,
				//'tag' => "myyu",
				'category' => get_category_by_slug("News")->term_id,
			));
			
			if($posts){
				foreach($posts as $post){
					
					$meta = get_post_meta($post->ID);
					if( $event_cost = $meta['myyu_news'][0] ){
						
						// We need to build a big crazy array of all the posts that were found with the MyYU Tag
						// We will cycle through this again later
						array_push($myyu_post_ids, array(
							"ID" => $post->ID, 
							"site" => $site->blog_id, 
							"post_date" => $post->post_date, 
							"post_title" => $post->post_title
						));
						
					}
					
				}
			}

		}
		restore_current_blog();
	}
	
	// Sort the found posts by the post date
	// This is very difficult to do in Multisites...
	function date_compare($a, $b){
		$t1 = strtotime($a['post_date']);
		$t2 = strtotime($b['post_date']);
		return $t1 - $t2;
	}    
	usort($myyu_post_ids, 'date_compare');
	
	$myyu_post_ids = array_reverse($myyu_post_ids);
	//var_dump($myyu_post_ids);
	
	$top_posts = [];
	$top_posts_images = [];
	$post_limit = 3;
	$post_limit_count = 0;
	foreach($myyu_post_ids as $post){
		
		$post_limit_count += 1;
		if($post_limit_count <= $post_limit){
	
			switch_to_blog( $post['site'] );
			
			// Post Data
			array_push($top_posts, get_post($post['ID']));
			
			// Post Thumbnail
			$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
			if(get_the_post_thumbnail_url($post['ID'],array(256,256))){
				$img_source = get_the_post_thumbnail_url($post['ID'],array(256,256));
			}
			array_push($top_posts_images, $img_source);
			
			restore_current_blog();
		
		}
		
	}
	
	// We finally have the required posts, setup for display
	?>
	
		<div class="grid-x grid-padding-x grid-padding-y" style="margin-bottom:20px;">
			
			<?php
			
			?>
			<div class="cell small-12 large-8 post-alt" style="margin:0; padding:4px;" >
				<a class="overlay" href="<?php echo get_permalink( $top_posts[0]->ID ); ?>">
					<img src="<?php echo $top_posts_images[0]; ?>" alt="Image for the blog post.">
					<div>
						<p><?php echo $top_posts[0]->post_title; ?></p>
						<!--
						<p class="post-meta">
							<span>Posted on</span> Nov. 22 in <span>Category</span>
						</p>
						-->
					</div>
				</a>
			</div>
			
			<div class="cell small-12 large-4" style="margin:0; padding:4px;" >
				
				<div class="grid-x grid-padding-y">
					
						<div class="cell small-12 post-alt" style="margin-bottom:0; padding-bottom:4px;" >
							<a class="overlay" href="<?php echo get_permalink( $top_posts[1]->ID ); ?>">
								<img src="<?php echo $top_posts_images[1]; ?>" alt="Image for the blog post.">
								<div>
									<p><?php echo $top_posts[1]->post_title; ?></p>
									<!--
									<p class="post-meta">
										<span>Posted on</span> Nov. 22 in <span>Category</span>
									</p>
									-->
								</div>
							</a>
						</div>

						<div class="cell small-12 post-alt" style="margin:0; padding:4px 0;" >
							<a class="overlay" href="<?php echo get_permalink( $top_posts[2]->ID ); ?>">
								<img src="<?php echo $top_posts_images[2]; ?>" alt="Image for the blog post.">
								<div>
									<p><?php echo $top_posts[2]->post_title; ?></p>
									<!--
									<p class="post-meta">
										<span>Posted on</span> Nov. 22 in <span>Category</span>
									</p>
									-->
								</div>
							</a>
						</div>
					
				</div>

			</div>
			
			<div class="cell small-12" style="margin-bottom:60px;">
				<center>
					<a class="button primary" href="/events">View All News</a>
				</center>
			</div>
			
		</div>
		
	<?php
	
}

add_shortcode( 'myyu_tagged_posts', 'myyu_tagged_posts_function' );




// ==================
// MyYU TAGGED POSTS
// ==================
//[myyu_tagged_events]

function myyu_tagged_events_function( $atts ){
	
	?>
	
	<section class="padding-top">
			<div class="grid-container">
				<div class="grid-x grid-padding-x grid-margin-y home-queries">
				
					<?php
					
					$posts = get_posts(array(
						'posts_per_page' => 4,
						'category' => get_category_by_slug("Events")->term_id,
						'orderby' => 'date',
					));
					
				
					foreach($posts as $post){
					
						$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
						if(get_the_post_thumbnail_url($post->ID,array(256,256))){
							$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
						}
						
						$meta = get_post_meta($post->ID);
						
						$event_cost = $meta['event_cost'][0];
						$event_time = $meta['event_time'][0];
						$event_address = $meta['event_address'][0];
					
						?>
						
							<div class="cell small-12 large-6">
								
								<div class="post post-event">
									<div class="grid-x grid-margin-y grid-padding-x">
										<div class="cell small-12 large-4">
											<div class="event-image-wrapper">
												<a href="<?php echo get_permalink( $post->ID ); ?>">
													<img src="<?php echo $img_source; ?>" class="img-responsive"> 
													
													<div class="event-date">
														<p><?php echo $meta['event_month'][0]; ?></p>
														<p><?php echo $meta['event_day'][0]; ?></p>
													</div>
												</a>
											</div>
										</div>
										<div class="cell small-12 large-8">
											<div class="event-details">
												<a class="post-title underline" href="events-single.php">
													<?php echo $post->post_title; ?>
												</a>
												<?php if($event_cost){ ?> <p><i class="fa fa-usd" aria-hidden="true"></i> <?php echo $meta['event_cost'][0]; ?></p> <?php } ?>
												<p><?php echo($post->post_excerpt); ?></p>
												<?php if($event_time){ ?> <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $meta['event_time'][0]; ?></p> <?php } ?>
												<?php if($event_address){ ?> <p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $meta['event_address'][0]; ?></p> <?php } ?>
												<a class="button secondary" href="<?php echo get_permalink( $post->ID ); ?>">Event Details</a>
											</div>
										</div>
									</div>
								</div>
							</div>
					
						<?php
						}
						wp_reset_postdata();
						?>
				
					<div class="cell small-12" style="margin-bottom:60px;">
						<center>
							<a class="button primary" href="/events">View All Events</a>
						</center>
					</div>

				</div>
			</div>
		</section>
		
	<?php
	
}

add_shortcode( 'myyu_tagged_events', 'myyu_tagged_events_function' );