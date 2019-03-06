<?php


// ==================
// Alumni TAGGED POSTS
// ==================
//[alumni_tagged_posts]

function alumni_tagged_posts_function( $atts ){

	global $wpdb;
	$post_counter = 0;
	
	$alumni_post_ids = [];
	
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
			$blog_name = get_blog_details()->blogname;
			
			if(($blog_name == 'YorkvilleU.ca') || ($blog_name == 'Alumni')){ // ONLY show the posts from 'YorkvilleU.ca' & 'Alumni' 

				foreach($results as $key => $array){
					array_push($post_ids, $array[0]);
				}
				$posts = get_posts(array(
					'post__in' => $post_ids,
					'category' => get_category_by_slug("News & Events")->term_id,
				));
				
				if($posts){
					foreach($posts as $post){
						
						// We need to build a big crazy array of all the posts that were found with the MyYU Tag
						// We will cycle through this again later
						array_push($alumni_post_ids, array(
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
	usort($alumni_post_ids, 'date_compare');
	
	$alumni_post_ids = array_reverse($alumni_post_ids);

	$top_posts = [];
	$top_posts_images = [];
	$post_limit = 3;
	$post_limit_count = 0;
	foreach($alumni_post_ids as $post){
		
		$post_limit_count += 1;
		if($post_limit_count <= $post_limit){
	
			switch_to_blog($post['site']);
			
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
					<a class="button primary" href="/news">View All News</a>
				</center>
			</div>
			
		</div>
		
	<?php
}

add_shortcode( 'alumni_tagged_posts', 'alumni_tagged_posts_function' );
		
//[alumni]
function alumni_func( $atts ){

return;
?>
	<div class="mobile_swipe_notify">(Tap And Hold for Profile)</div>
<?php


$attributes = shortcode_atts([
	'page' => 'default',
], $atts, $tag);

if($attributes["page"]=="directory"){
	?>
	<style>
		.btx-layout--wide .btx-container, .btx-layout--frame .btx-container {max-width:100%;}
	</style>
	<p>Here are just some of our diverse and talented alumni! <a href="http://alumni.yorkvilleu.ca/submit-profile/">Submit Your Profile</a> to find former classmates, share your social  media presence, and easily network with your fellow graduates.</p>

	<div class="well">
		<form action="/alumni-directory">
			<select name="search_program">
				<option value="">All Programs</option>
				<option value="MACP" <?php if($_GET['search_program']=="MACP"){ echo 'selected'; } ?>>MACP</option>
				<option value="MEd"  <?php if($_GET['search_program']=="MEd"){ echo 'selected'; } ?>>MEd</option>
				<option value="BBA"  <?php if($_GET['search_program']=="BBA"){ echo 'selected'; } ?>>BBA</option>
				<option value="BID"  <?php if($_GET['search_program']=="BID"){ echo 'selected'; } ?>>BID</option>
				<option value="BTEC"  <?php if($_GET['search_program']=="BTEC"){ echo 'selected'; } ?>>BTEC</option>
			</select>
			 <select name="search_year">
                                <option value="">All Years</option>
                                <option value="2010" <?php if($_GET['search_year']=="2010"){ echo 'selected'; } ?>>2010</option>
                                <option value="2011" <?php if($_GET['search_year']=="2011"){ echo 'selected'; } ?>>2011</option>
                                <option value="2012" <?php if($_GET['search_year']=="2012"){ echo 'selected'; } ?>>2012</option>
				<option value="2013" <?php if($_GET['search_year']=="2013"){ echo 'selected'; } ?>>2013</option>
                                <option value="2014" <?php if($_GET['search_year']=="2014"){ echo 'selected'; } ?>>2014</option>
                                <option value="2015" <?php if($_GET['search_year']=="2015"){ echo 'selected'; } ?>>2015</option>
				<option value="2016" <?php if($_GET['search_year']=="2016"){ echo 'selected'; } ?>>2016</option>
                                <option value="2017" <?php if($_GET['search_year']=="2017"){ echo 'selected'; } ?>>2017</option>
                        </select>
			<input type="submit" value="Search Alumni Directory" />
		</form>
	</div>


	<?php
}
    
    $form_id = '1';
    if($attributes["page"]=="directory"){
	if($_GET['search_program']){
	        $search['field_filters'][] = array( 'key' => '5', 'value' => $_GET['search_program'] );
	}
	if($_GET['search_year']){
		$search['field_filters'][] = array( 'key' => '6', 'value' => $_GET['search_year'] );
	}
    }

    $paging  = array( 'offset' => 0, 'page_size' => 9 );
    if($attributes["page"]=="directory"){ 
	     $paging  = array( 'offset' => 0, 'page_size' => 200 );
    }
    $sorting = array();
    $entries = GFAPI::get_entries( $form_id, $search, $sorting, $paging );
    
    foreach($entries as $entry){
        if($entry['is_starred']){
        ?>
        <div class="alumni_list">
			<div style="background:url('<?php echo $entry['7']; ?>');" class="alumni_photo" >
				<div class="hover_data">
					<h3><?php echo $entry['1']; ?> <?php echo $entry['2']; ?></h3>
					<h4><?php echo $entry['3']; ?> @ <?php echo $entry['4']; ?></h4>
					<h4>Graduated <?php echo $entry['6']; ?> in <?php echo $entry['5']; ?></h4>
					
					<div class="social">
						
						<?php if( $entry['8'] ){ ?>
						<a href="<?php echo $entry['8']; ?>" target="_blank">
							<img src="/wp-content/plugins/alumni/icons/btn_website.png" />
						</a>
						<?php } ?>
						
						<?php if( $entry['11'] ){ ?>
						<a href="<?php echo $entry['11']; ?>" target="_blank">
							<img src="/wp-content/plugins/alumni/icons/btn_portfolio.png" />
						</a>
						<?php } ?>
						
						<?php if( $entry['10'] ){ ?>
						<a href="<?php echo $entry['10']; ?>" target="_blank">
							<img src="/wp-content/plugins/alumni/icons/btn_facebook.png" />
						</a>
						<?php } ?>
						
						<?php if( $entry['9'] ){ ?>
						<a href="<?php echo $entry['9']; ?>" target="_blank">
							<img src="/wp-content/plugins/alumni/icons/btn_twitter.png" />
						</a>
						<?php } ?>
						
						<?php if( $entry['12'] ){ ?>
						<a href="<?php echo $entry['12']; ?>" target="_blank">
							<img src="/wp-content/plugins/alumni/icons/btn_linkedin.png" />
						</a>
						<?php } ?>
						
					</div>
				</div>
            </div>
        </div>
        <?php
        }
	
    }
}

add_shortcode( 'alumni', 'alumni_func' );



//[alumni]
function alumni_directory_function( $atts ){
	
	?>
		<a name="alumni/"></a>
		<div class="search-form-wrapper alumni">
			<div class="grid-container">
				<form class="search-form" action="/alumni-directory" method="get" >
					<label for="search-year">Filter by:</label>
					<select id="search-year" name="search-year">
					
						<option value="" <?php if($_GET['search-year'] == ""){ echo 'selected="selected"'; } ?> >Year</option>
						
						<option value="2020" <?php if($_GET['search-year'] == "2020"){ echo 'selected="selected"'; } ?>>2020</option>
						<option value="2019" <?php if($_GET['search-year'] == "2019"){ echo 'selected="selected"'; } ?>>2019</option>
						<option value="2018" <?php if($_GET['search-year'] == "2018"){ echo 'selected="selected"'; } ?>>2018</option>
						<option value="2017" <?php if($_GET['search-year'] == "2017"){ echo 'selected="selected"'; } ?>>2017</option>
						<option value="2016" <?php if($_GET['search-year'] == "2016"){ echo 'selected="selected"'; } ?>>2016</option>
						<option value="2015" <?php if($_GET['search-year'] == "2015"){ echo 'selected="selected"'; } ?>>2015</option>
						<option value="2014" <?php if($_GET['search-year'] == "2014"){ echo 'selected="selected"'; } ?>>2014</option>
						<option value="2013" <?php if($_GET['search-year'] == "2013"){ echo 'selected="selected"'; } ?>>2013</option>
						<option value="2012" <?php if($_GET['search-year'] == "2012"){ echo 'selected="selected"'; } ?>>2012</option>
						<option value="2011" <?php if($_GET['search-year'] == "2011"){ echo 'selected="selected"'; } ?>>2011</option>
						<option value="2010" <?php if($_GET['search-year'] == "2010"){ echo 'selected="selected"'; } ?>>2010</option>
					</select>
					<label class="screen-reader-text" for="search-programs">Filter by:</label>
					<select id="search-programs" name="programs">
						<option value = "" <?php if($_GET['programs'] == ""){ echo 'selected="selected"'; } ?>>Program</option>
						<option value="MACP" <?php if($_GET['programs'] == "MACP"){ echo 'selected="selected"'; } ?>>MACP</option>
						<option value="MEd" <?php if($_GET['programs'] == "MEd"){ echo 'selected="selected"'; } ?>>MEd</option>
						<option value="BBA" <?php if($_GET['programs'] == "BBA"){ echo 'selected="selected"'; } ?>>BBA</option>
						<option value="BID" <?php if($_GET['programs'] == "BID"){ echo 'selected="selected"'; } ?>>BID</option>
						<option value="BTEC" <?php if($_GET['programs'] == "BTEC"){ echo 'selected="selected"'; } ?>>BTEC</option>
					</select>
					<input class="button secondary" value="Search" type="submit">
				</form>
			</div>
		</div>
		

		<section class="section-padding"> 
			<div class="grid-container">
				<div class="grid-x grid-padding-x">
					<div class="cell small-12 large-12">
						<div class="grid-x grid-padding-x grid-padding-y">
	
							<?php	

							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

							
							$number_of_result_found = 0;
							
							
								$posts = get_posts(array(
									'post__in' => $post_ids,
									
									'category' => get_category_by_slug("Alumni Directory")->term_id,
									'posts_per_page' => 12,
									'post_date' => DESC,
									'paged' => $paged,
									
									'meta_query' => array(
									//'relation' => 'AND',
									array(
											'key' => 'grad_year',
											'value' => $_GET['search-year'],
											'compare' => 'LIKE'),
									array(
											'key' => 'grad_program',
											'value' => $_GET['programs'],
											'compare' => 'LIKE')
									)
								));
								

								foreach($posts as $post){
									
									$meta = get_post_meta($post->ID);
									$display_this_post = false;		

									if(($_GET['search-year'] == "") && ($_GET['programs'] == "")){
									
										$display_this_post = true;
									}

									// iF SEARCHING YEAR AND PROGRAM 
																		
									if(($_GET['search-year'] != "") && ($_GET['programs'] != "")){
										if(($_GET['search-year'] == $meta['grad_year'][0]) && ($_GET['programs'] == $meta['grad_program'][0])){
											
											$display_this_post = true;

										}							
									}
									else{
										
										// IF SEARCHING YEAR ONLY
										if($_GET['search-year'] != ""){
											if($_GET['search-year'] == $meta['grad_year'][0] ){
												
												$display_this_post = true;
												
											}
										}
									
										// IF SEARCHING PROGRAM ONLY
										if($_GET['programs'] != ""){
											if($_GET['programs'] == $meta['grad_program'][0]){
												
												$display_this_post = true;

												
											}
										}
									}
										
									if($display_this_post == true){
										
										$number_of_result_found += 1;
										
										
										
										// Post Thumbnail
										$img_source = "/wp-content/themes/yu2018/img/user_square.png";
										if(get_the_post_thumbnail_url($post->ID,array(256,256))){
											$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
										}
										?>
										
											<div class="cell small-12 large-3" style="padding:4px;">
												<div class="post post-alumni" >
													<div style="background: url(<?php echo $img_source ?>) no-repeat center; background-size:cover;
														   background-repeat: no-repeat; background-size:cover; height:285px; width:100%;">
													 </div>
																				
													<p class="name"><?php echo $post->post_title; ?></p>
													
													<?php if( $meta['grad_program'][0] != "" ){ ?>
														<p><?php echo $meta['grad_program'][0] ?> | <?php echo $meta['grad_year'][0] ?></p>
													<?php } ?>
													
													<?php if( $meta['title'][0] != "" ){ ?>
														<p class="job"><?php echo $meta['title'][0] ?></p>
													<?php } ?>
													
													<?php if( $meta['twitter_link'][0] != "" ){ ?>
														<a class="twitter" href="<?php echo $meta['twitter_link'][0]; ?>" style="text-decoration:none;">
															<span class="screen-reader-text">Link to Twitter account</span>
															<i class="fab fa-twitter" aria-hidden="true"></i>
														</a>
													<?php } ?>
													
													<?php if( $meta['facebook_link'][0] != "" ){ ?>
														<a class="fabcebook" href="<?php echo $meta['facebook_link'][0]; ?>" style="text-decoration:none;">
															<span class="screen-reader-text">Link to Facebook account</span>
															<i class="fab fa-facebook" aria-hidden="true"></i>
														</a>
													<?php } ?>
													
													<?php if( $meta['linkedin_link'][0] != "" ){ ?>
														<a class="linkedin" href="<?php echo $meta['linkedin_link'][0]; ?>" style="text-decoration:none;">
															<span class="screen-reader-text">Link to LinkedIn account</span>
															<i class="fab fa-linkedin" aria-hidden="true"></i>
														</a>
													<?php } ?>
														
												</div>
											</div>
									<?php

									} 										
								}			

									$alumni_directory_posts =  new WP_Query(array(
										'category_name' => 'alumni-directory',
										'posts_per_page' => 12, 
										'meta_query' => array(
									//'relation' => 'AND',
									array(
											'key' => 'grad_year',
											'value' => $_GET['search-year'],
											'compare' => 'LIKE'),
									array(
											'key' => 'grad_program',
											'value' => $_GET['programs'],
											'compare' => 'LIKE')
									),
										 'base'               => '%_%',
										 'format'             => '?page=%#%#work', // the '%#%' will be replaced with the page number
										 'total'              => 1,
										 'current'            => 0,
										 'show_all'           => False,

									
									));
						
								if($number_of_result_found == 0){ 
								
							
								 	echo "<h3>No Result Found</h3>";

									
								}	
								
							?>
						
						</div>	
					</div> 
					
					
					<form class="page-numbers" action="/alumni-directory" method="get">
					
						<?php 
							global $wp_query;
							$big = 999999999; // need an unlikely integer

							$pages =  paginate_links(array(
							
								'base' => str_replace( $big, '%#%#alumni', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'class' => 'button',
								'total' => $alumni_directory_posts->max_num_pages,
								'type' => 'list',
							)); 
							echo $pages;
							
						?>
					
					</form>
					
				</div>
			</div>
			
			<center>
				<a href="/alumni-director/submit" class="button">
					Submit your Alumni profile
				</a>
			</center>
			
		</section>
				
<?php

  
}

add_shortcode( 'alumni_directory', 'alumni_directory_function' );


