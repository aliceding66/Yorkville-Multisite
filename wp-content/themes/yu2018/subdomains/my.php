<?php
/*
Template Name: my.yorkvilleu.ca
*/

//quire_once __DIR__ . '/../yorkville_dev_production_manager.php';
require_once __DIR__ . '/../header.php';
//get_header();


?>

	<img class="img-responsive" src="/wp-content/themes/yu2018/subdomains/my/img/welcome-mat.jpg"  style="z-index:100; position:relative;" />

	<div class="col-md-8">
		<section id="Icons"  data-intro="These icons are how you will navigate Yorkville University during your studies.">

			<div class="grid">

				<div class="grid-sizer"></div>

				<div class="grid-item" >
					<a href="//<?php echo $YORKVILLE['courses']; ?>" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-courses-18w.png" data-intro="Your courses, assignments and exams may be accessed with this button">
					</a>
				</div>
				<div class="grid-item" >
					<a href="//campus.yorkvilleu.ca" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-courses-17f.png" data-intro="Your courses, assignments and exams may be accessed with this button">
					</a>
				</div>
				<div class="grid-item" >
					<a href="http://myprogram.yorkvilleu.ca/" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-my-program.png" data-intro="Specific information about you and your program can be found here.">
					</a>
				</div>
				<div class="grid-item" >
					<a href="http://library.yorkvilleu.ca" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-library.png" data-intro="The Library site supports your studies. Find open and fee based databases to aid you in research.">
					</a>
				</div>
				<div class="grid-item" >
					<a href="http://success.yorkvilleu.ca/" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-learning-success.png" data-intro="Need a hand writing an essay, or finishing a hard math problem? Check out the LSC for academic tips.">
					</a>
				</div>
				<div class="grid-item" >
					<a href="http://askyu.azure.yorkvilleu.ca/" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-askyu.png" data-intro="You may ask any question about Yorkville University here.">
					</a>
				</div>
				<div class="grid-item">
					<a class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-stores.png"  id="BTN_MODAL_STORES" data-intro="We offer stunning apparel that you may purchase, click this button to see all stores.">
					</a>
				</div>
				<div class="grid-item" >
					<a href="http://alumni.yorkvilleu.ca" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/my/img/btn-alumni.png" data-intro="YorkvilleU Alumni connect here to stay in touch after their studies.">
					</a>
				</div>

			</div>

		</section>
	</div>

	<div class="col-md-4" style="background-image:url(/wp-content/themes/yu2018/img/wallpaper-blue.jpg) !important;  display: flex; min-height: 80vh; flex-grow: 1;">

		<div class="col-xs-12">

			<div class="row">
				<div class="col-xs-12">
					<a href="http://askyu.azure.yorkvilleu.ca/results/"><img src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-askyu.png" class="img-responsive"></a>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h4>News from YorkvilleU</h4>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">

					<a href="http://facebook.com" class="btn btn-social-icon btn-facebook">
					<i class="fa fa-facebook"></i></a>
					<a class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>
					<a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
					<a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>

				</div>
			</div>

			<hr />

			<?php

				global $wpdb;

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
							//var_dump($array);
							array_push($post_ids, $array[0]);
						}
						//var_dump($post_ids);
						$posts = get_posts(array(
							'post__in' => $post_ids,
							'tag' => "myyu",
						));
						
						//var_dump($posts);


						foreach($posts as $post){
							$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
							if(get_the_post_thumbnail_url($post->ID,array(256,256))){
								$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
							}

							?>
							<a href="<?php echo get_permalink( $post->ID ); ?>" class="row" style="margin-top:4px;">
								<div class="col-xs-2">
									<img src="<?php echo $img_source; ?>" class="img-responsive" />
								</div>
								<p class="col-xs-10" style="color:white;">
									<h4 style="font-size:16px;"><b><?php echo $post->post_title; ?></b> from <?php echo get_bloginfo($site->blog_id) ?></h4>
								</p>
							</a>
							<?php
						}



					}
					restore_current_blog();
				}

				?>



			<div class="row" style="margin-top:10px;">
				<center>
					<a href="/news" class="btn btn-lg btn-warning">Read All News</a>
				</center>
			</div>

		</div>
	</div>


<?php wp_footer(); ?>
