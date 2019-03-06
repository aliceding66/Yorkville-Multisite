<?php get_header(); ?>


<?php setPostViews(get_the_ID(),get_current_blog_id(),get_the_author());

		global $wpdb;
		
		if ( is_user_logged_in() ) {
			$temp_user = 'Student/Faculty';
		}
		
		else  {
			$temp_user= 'Guest';
		}
		//var_dump($temp_user);
		
		$query_update_more = "INSERT INTO wp_posttrack (hittime, usertype, siteid, postid, useragent,clientip,clienthostip,querystring) VALUES ('".current_time('mysql')."','".$temp_user."', ".get_current_blog_id().", ".get_the_ID().", '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['REMOTE_HOST']."', '".$_SERVER['QUERY_STRING']."')";
	//var_dump($query_update_more);
		
		
		$wpdb->query($query_update_more);
		//$user_track = $wpdb->insert('wp_posttrack',array('hittime'=> current_time('mysql'), 'usertype' => $temp_user, 'siteid'=>get_current_blog_id(),'postid' => get_the_ID(), 'useragent' => $_SERVER['HTTP_USER_AGENT'], 'clientip' => $_SERVER['REMOTE_ADDR'], 'clienthostip' => $_SERVER['REMOTE_HOST'], 'querystring' => $_SERVER['QUERY_STRING']));


		?>

<?php if (have_posts()){
	

	while (have_posts()) : the_post(); ?>
	
		<?php 
		
			// Default featured image
			$img_source = get_the_post_thumbnail_url($post->ID,"full");
			if($img_source){
				?>
			
				<section class="hero text-center hide-for-small-only" style="background-image: url(<?php echo $img_source; ?>); ">
					<div class="grid-container">
						<h1><?php echo do_shortcode('[acf field="welcome_title"]'); ?></h1>
						<h2><?php echo do_shortcode('[acf field="welcome_sub"]'); ?></h2>
					</div>
				</section>
			
				<?php 
			}
			
			// Specifically check for a mobile featured image
			$mobile_header = explode(',',do_shortcode('[acf field="mobile_header"]')); 
			if($mobile_header[6] != ""){
				?>
					<section class="hero text-center hide-for-medium" style="background-image: url(<?php echo $mobile_header[6]; ?>); "></section>			
				<?php 
			}?>
			
		
		<section class="breadcrumb">
			<div class="grid-container">
				<div class="grid-x">
					<table class="cell small-12" style="border-collapse：initial;">
						<tr>
							<td>
								<?php custom_breadcrumbs(); ?>
							</td>
							<td>
								<?php get_search_form(); ?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</section>
		
		<section class="">
			<div class="grid-container">

				<h1 class="section-header underline"><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
				
			</div>
		</section>
		


	<?php endwhile; ?>


<?php } ?>




<?php get_footer(); ?>
