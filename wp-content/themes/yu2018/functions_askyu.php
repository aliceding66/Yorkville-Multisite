<?php

// askyu_search_function
// ---------------
function askyu_search_function( $atts ) {

?>

	<div class="grid-container">
		<div class="grid-x">
			<div class="cell small-12 large-8 large-offset-2 padding-top">
				
				
				<form id="askyu_form" class="header-search-form">
					<input id="askyu_search_query" placeholder="I need help with..." type="text" name="q" />
					<input value="AskYU" type="submit" />
				</form>
				
				<hr />
				
				
				<div id="askyu_search" style="display:none;">
					
					<div id="askyu_search_loader">
						<center>
							<div class="loader_icon">
								<div class="ldsblue-css ng-scope">
									<div class="ldsblue-spinner" style="100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
									<h3>SEARCHING </h3>
								</div>
							</div>
						</center>
					</div>
				
				</div>
				
				
			</div>
		</div>
	</div>
	
	<div class="grid-container">
		<div class="grid-x">
			<div class="cell small-12 large-12">
				
				<div id="askyu_search_results" style="display:none;">
					<div class="content">
						No results found.
					</div>
				</div>
				
				<div id="askyu_submit_case" style="display:none;">
					<h2>Can't find an Answer?</h2>
					<a href="/submit?question=">Submit a Question to AskYU</a>
				</div>
				
			</div>
		</div>
	</div>


	<!-- AJAX SEARCH -->
	<script>

		$( document ).ready(function() {

			var appbar_search = "<?php echo $_GET['search']; ?>";

			if(appbar_search){
				$("#askyu_search_query").val(appbar_search);

				$("#askyu_search").show();
				$("#askyu_search_loader").show();

				setTimeout(function(){
					$('#askyu_form').submit();
				},1000);
			}

			$('#askyu_form').submit(function(event) {

				event.preventDefault(); // to stop the form from submitting, we're doing ajax magic now

				$("#askyu_search").show();
				$("#askyu_search_loader").show();

				$.ajax({
					url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
					type:'POST',
					data: "action=askyu_search&query="+ $("#askyu_search_query").val() +"&ignore=<?php echo $_GET['ignore']; ?>",
					success: function(html){

						$("#content").append(html);    // This will be the div where our content will be loaded
						$("#askyu_search_loader").hide();
						$("#askyu_search_results").show();

						// Returns a 0?
						$("#askyu_search_results .content").html(html);    // This will be the div where our content will be loaded

					}
				});

				//document.cookie = "username=John Doe; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/"; 

			});
		});

	</script>

<?php
}
add_shortcode( 'askyu_search', 'askyu_search_function' );


// SEARCH RESULTS
function askyu_search(){
	
	global $wpdb;

	$queryArray = explode(" ", $_POST['query']); // split the search words by space
	$posts_found = 0;
	
	// EMPTY SEARCH
	if($_POST['query'] == ""){
		?>
			<div class="post">
				<div class="grid-x grid-padding-x grid-margin-y">
					<div class="cell small-12 large-12">
						<center>
							<h2 style="color:red;">Please enter something to Search for</h2>
						</center>
					</div>
				</div>
			</div>	
		<?php
		die;
	}
	
	// EMPTY SEARCH
	if(strlen($_POST['query']) <= 2){
		?>
			<div class="post">
				<div class="grid-x grid-padding-x grid-margin-y">
					<div class="cell small-12 large-12">
						<center>
							<h2 style="color:red;">Your question is too short, please add more detail</h2>
						</center>
					</div>
				</div>
			</div>	
		<?php
		die;
	}
	?>

	<div class="post">
		<div class="grid-x grid-padding-x grid-margin-y">
			<div class="cell small-12 large-4">
				<a href="<?php echo get_post_permalink( $post->ID ); ?>">
					<?php 
						if( has_post_thumbnail() != ""){
							the_post_thumbnail('full', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']);
						}else{
							?> <img src="<?php echo $img_source; ?>" class="img-responsive"> <?php
						}
					?>
				</a>
			</div>
			<div class="cell small-12 large-12">
				<center>
					<a class="askyu_proceed_to_search" href="/submit?question="><h2>Can't find the Answer you're looking for?</h2></a>
					<p></p>
					<a class="button primary askyu_proceed_to_search" href="/submit?question=">Submit your Question to AskYU</a>
				</center>
			</div>
		</div>
	</div>	
	<hr />

	<?php

	
	$sites = get_sites(); // to find the posts from all sites
	$askyu_site_id = false;
	
	// -----------------
	// LOG QUERY AS CUSTOM POST TYPE
	// -----------------
	if($_POST['ignore'] != true){
		foreach($sites as $site){
			if( $site->domain=="askyu.yorkvilleu.ca" || $site->domain=="askyu.yorkvilleu.dev"){
				
				switch_to_blog($site->blog_id);
				$askyu_site_id = $site->blog_id;
				
				$askyu_search_post = wp_insert_post( array(
				  'post_title'    => wp_strip_all_tags( $_POST['query'] ),
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_type'	  => 'askyu_searches'
				) );
				
			}
		}
	}
		
	// -----------------
	// POST TITLE SEARCH
	// -----------------
	foreach($sites as $site){

		wp_reset_query();
		wp_reset_postdata();
		$post = null;
		switch_to_blog($site->blog_id);
		
		if($site->blog_id == 1){
			$site_sql = "wp_posts";
		}else{
			$site_sql = "wp_".$site->blog_id."_posts";
		}

		/*
		for ($i=0; $i< count($queryArray); $i++) {
			$filter .= 'post_title LIKE "%'.$queryArray[$i].'%" OR ';
		}
		$filter = rtrim ($filter, " OR");
		*/
		
		$sql_search_posts = 'post_type = "post" AND post_status = "publish" AND post_title LIKE "%'. $_POST['query'].'%" ';
		$sql_search_pages = 'post_type = "page" AND post_status = "publish" AND post_title LIKE "%'. $_POST['query'].'%" ';
		
		$query = 'SELECT ID FROM '.$site_sql.' WHERE '.$sql_search_posts.' OR '.$sql_search_pages.' LIMIT 10';
		
		$results =  $wpdb->get_results($query, ARRAY_N);
		//var_dump($results);
		switch_to_blog($site->blog_id); 
		$post_ids = [];

		foreach($results as $key => $array){
			
			// Build array for results
			array_push($post_ids, $array[0]);
			
			// ------------------
			// Log for AskYU Searches
			switch_to_blog($askyu_site_id);
			$add_meta = add_post_meta($askyu_search_post, 'askyu_search_found_post', $site->blog_id.":".$array[0], false);
			
			switch_to_blog($site->blog_id); 
			// Make sure to switch back
			// ------------------
		}
		
		

		// Display Results
		foreach($post_ids as $post_id){
			//var_dump(intval($post_id));
			$post = get_post(intval($post_id));
			//VAR_DUMP($post);
			//check if it is restricted, if it is, then continue
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			// get current user id
			
			$current_page_user_id = get_current_user_id();
			//var_dump($current_page_user_id);

			// get user meta meta_value where meta_key='ysis_data' and userid = $current_page_user_id

			$current_user_ysis = get_user_meta($current_page_user_id, 'ysis_data');
	
			//var_dump($current_user_ysis);
			
			
			if(empty($current_user_ysis)){
				
						// get page/post id
						
						$current_url_post_id = intval($post_id);
						
						// get site id

						$current_site_id =  get_current_blog_id();
				
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						//var_dump($current_jurisdiction);
				
				if (!isset($current_jurisdiction[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_brand[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_baseprogram[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_campus[0]->name)){
				}
				else {
					continue;
				}
			}
			else{


				// JSON decode ysis_data
		
				$current_user_ysis = JSON_decode($current_user_ysis[0]);
				//var_dump($current_user_ysis);
				if (isset($current_user_ysis->YSIS_COURSE)){
			
					if (isset($current_user_ysis->YSIS_COURSE[0])){
			
						// get YSIS_COURSE field

						$current_user_ysis_course = $current_user_ysis->YSIS_COURSE;
						//var_dump($current_user_ysis_course);
				
						// get site id

						$current_site_id =  get_current_blog_id();
						//var_dump($current_site_id);
			
						// get page/post id
						$current_url_post_id = intval($post_id);
						//var_dump($current_url_post_id);
			

						//var_dump($user_jurisdiction);

						// get page/post jurisdiction tag

						switch_to_blog($current_site_id);
						
						global $wpdb;
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						//var_dump($current_jurisdiction);
						//var_dump($current_brand);
						//var_dump($current_baseprogram);
						//var_dump($current_campus);
						
						//var_dump(isset($current_jurisdiction->errors));
						restore_current_blog();
	
						if (!isset($current_jurisdiction[0]->name)){$jurisdiction_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{

							$jurisdiction_pointer = 0;
							//var_dump($current_jurisdiction);

							foreach ($current_jurisdiction as $current_single_jurisdiction){
								
								

								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
									//var_dump($current_user_ysis_single_course);
						
									// get user jurisdiction

									if ($current_single_jurisdiction->name == $current_user_ysis_single_course->Juridiction) {
	
										$jurisdiction_pointer = 1;
							
										break 2; 

									}
								}
							}
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu.ca
					
							//var_dump($jurisdiction_pointer);

							if ($jurisdiction_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								

							}
						}
				
						if (!isset($current_brand[0]->name)){$brand_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							$brand_pointer = 0;		

							foreach ($current_brand as $current_single_brand){

								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
						
									// get user jurisdiction

									if ($current_single_brand->name == $current_user_ysis_single_course->Brand) {
	
										$brand_pointer = 1;
							
										break 2; 

									}
								}
							}
		
					
							// if they are not the same brand, redirect to yorkvilleu.ca
					
							//var_dump($brand_pointer);

							if ($brand_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								

							}				
						}
						
						if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							

							}				
						}
						
						if (!isset($current_campus[0]->name)){$delivery_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							
	
							}		
						}
					}
					else {
						// get page/post id
						$current_url_post_id = intval($post_id);
						
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						if (!isset($current_jurisdiction[0]->name)){
							$jurisdiction_pointer = 1;
						}
						else{
							continue;
						}
						
						if (!isset($current_brand[0]->name)){
							$brand_pointer = 1;
						}
						else{
							continue;
						}
						// get page/post id

						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						
						if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							

							}				
						}
						
						if (!isset($current_campus[0]->name)){$delivery_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							
	
							}		
						}
						
					}
				}
				else {
					// get page/post id
						$current_url_post_id = intval($post_id);
					$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
					$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
					$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
					$current_brand =  $wpdb->get_results($current_brand_query);
						
					if (!isset($current_jurisdiction[0]->name)){
							$jurisdiction_pointer = 1;
					}
					else{
							continue;
					}
						
					if (!isset($current_brand[0]->name)){
							$brand_pointer = 1;
					}
					else{
							continue;
					}
					
					$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
					$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
					$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
					$current_campus =  $wpdb->get_results($current_campus_query);
						
						
					if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
					else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							

							}				
						}
						
						if (!isset($current_campus[0]->name)){$delivery_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							
	
							}		
						}
						
				}
				//var_dump($jurisdiction_pointer);
				//var_dump($brand_pointer);
				//var_dump($baseprogram_pointer);
				//var_dump($delivery_pointer);
				//var_dump(isset($post->ID));
				
				if (($jurisdiction_pointer==0) && ($brand_pointer==0) && ($baseprogram_pointer==0) && ($delivery_pointer==0)) {}
				else if (($jurisdiction_pointer==1) && ($brand_pointer==1) && ($baseprogram_pointer==1) && ($delivery_pointer==1)){}
				else {continue;}
			}

			
			if (!isset($post->ID )){continue;}
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$posts_found += 1;
			
			$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
			if(get_the_post_thumbnail_url($post->ID,array(256,256))){
				$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
			}

			?>
		
			<div class="post">
				<div class="grid-x grid-padding-x grid-margin-y">
					<div class="cell small-12 large-4">
						<a href="<?php echo get_post_permalink( $post->ID ); ?>">
							<?php 
								if( has_post_thumbnail() != ""){
									the_post_thumbnail('full', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']);
								}else{
									?> <img src="<?php echo $img_source; ?>" class="img-responsive"> <?php
								}
							?>
						</a>
					</div>
					<div class="cell small-12 large-8">
						<a class="post-title underline" href="<?php echo get_post_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>
						<p class="post-meta"><span>from <?php echo get_bloginfo($site->blog_id) ?></span></p>
						<p>
							<?php
								$remove_shortcode = preg_replace('/[\[{\(].*[\]}\)]/U',"",$post->post_content); // 'ABC '
								echo strip_tags(strip_tags(substr($remove_shortcode,0,400)),"[]");
							?> [...]
						</p>
						<a class="button primary" href="<?php echo get_post_permalink( $post->ID ); ?>">View Article</a>
					</div>
				</div>
			</div>	


			<?php
		}//  End foreach $post
		
	}
	
	//var_dump($results);
	
	restore_current_blog();

	// -----------------
	// POST TAG SEARCH
	// -----------------
	foreach($sites as $site){

		switch_to_blog($site->blog_id);

		if($site->blog_id == 1){
			$site_sql = "wp_posts";
		}else{
			$site_sql = "wp_".$site->blog_id."_posts";
		}

		$sql = 'SELECT ID FROM '.$site_sql.' WHERE post_type = "post"';
		$results =  $wpdb->get_results($sql, ARRAY_N);

		// Show results
		if(count($results) >= 1){

			$post_ids = [];

			foreach($results as $key => $array){
				//var_dump($array);
				array_push($post_ids, intval($array[0]));
				
			}

			$search_tags = explode(" ", $_POST['query']);

			$posts = get_posts(array(
				'post__in' => $post_ids,
				'tag' => $search_tags,
			));


			// ===== start foreach $post for tag search =====
			foreach($posts as $post){
			$post_id = $post->ID;	
				
							//check if it is restricted, if it is, then continue
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			// get current user id
			
			$current_page_user_id = get_current_user_id();
			//var_dump($current_page_user_id);

			// get user meta meta_value where meta_key='ysis_data' and userid = $current_page_user_id

			$current_user_ysis = get_user_meta($current_page_user_id, 'ysis_data');
	
			//var_dump($current_user_ysis);
			
			
			if(empty($current_user_ysis)){
				
						// get page/post id
						
						$current_url_post_id = intval($post_id);
						
						// get site id

						$current_site_id =  get_current_blog_id();
				
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						//var_dump($current_jurisdiction);
				
				if (!isset($current_jurisdiction[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_brand[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_baseprogram[0]->name)){
				}
				else {
					continue;
				}
				
				if (!isset($current_campus[0]->name)){
				}
				else {
					continue;
				}
			}
			else{


				// JSON decode ysis_data
		
				$current_user_ysis = JSON_decode($current_user_ysis[0]);
				//var_dump($current_user_ysis);
				if (isset($current_user_ysis->YSIS_COURSE)){
			
					if (isset($current_user_ysis->YSIS_COURSE[0])){
			
						// get YSIS_COURSE field

						$current_user_ysis_course = $current_user_ysis->YSIS_COURSE;
						//var_dump($current_user_ysis_course);
				
						// get site id

						$current_site_id =  get_current_blog_id();
						//var_dump($current_site_id);
			
						// get page/post id
						$current_url_post_id = intval($post_id);
						//var_dump($current_url_post_id);
			

						//var_dump($user_jurisdiction);

						// get page/post jurisdiction tag

						switch_to_blog($current_site_id);
						
						global $wpdb;
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						//var_dump($current_campus);
						//var_dump(isset($current_jurisdiction->errors));
						restore_current_blog();
	
						if (!isset($current_jurisdiction[0]->name)){}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{

							$jurisdiction_pointer = 0;
							//var_dump($current_jurisdiction);

							foreach ($current_jurisdiction as $current_single_jurisdiction){
								
								

								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
									//var_dump($current_user_ysis_single_course);
						
									// get user jurisdiction

									if ($current_single_jurisdiction->name == $current_user_ysis_single_course->Juridiction) {
	
										$jurisdiction_pointer = 1;
							
										break 2; 

									}
								}
							}
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu.ca
					
							//var_dump($jurisdiction_pointer);

							if ($jurisdiction_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								continue;

							}
						}
				
						if (!isset($current_brand[0]->name)){}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							$brand_pointer = 0;		

							foreach ($current_brand as $current_single_brand){

								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
						
									// get user jurisdiction

									if ($current_single_brand->name == $current_user_ysis_single_course->Brand) {
	
										$brand_pointer = 1;
							
										break 2; 

									}
								}
							}
		
					
							// if they are not the same brand, redirect to yorkvilleu.ca
					
							//var_dump($brand_pointer);

							if ($brand_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								continue;

							}				
						}
						
						if (!isset($current_baseprogram[0]->name)){ }
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction

									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								continue;

							}				
						}
						
						if (!isset($current_campus[0]->name)){}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							//var_dump($current_user_ysis);
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus

									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

								continue;
	
							}		
						}
					}
					else {
						$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
						$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						$current_brand =  $wpdb->get_results($current_brand_query);
						
						if (!isset($current_jurisdiction[0]->name)){
							$jurisdiction_pointer = 1;
						}
						else{
							$jurisdiction_pointer = 0;
						}
						
						if (!isset($current_brand[0]->name)){
							$brand_pointer = 1;
						}
						else{
							$brand_pointer = 0;
						}
					
						if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							

							}				
						}
						
						if (!isset($current_campus[0]->name)){$delivery_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							
	
							}		
						}
						
					}
				}
				else {
					$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
					$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
					$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
					$current_brand =  $wpdb->get_results($current_brand_query);
						
					if (!isset($current_jurisdiction[0]->name)){
						$jurisdiction_pointer = 1;
					}
					else{
						$jurisdiction_pointer = 0;
					}
						
					if (!isset($current_brand[0]->name)){
						$brand_pointer = 1;
					}
					else{
						$brand_pointer = 0;
					}
					
					
					if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									if ($current_single_baseprogram->name == $current_user_ysis->ProgramBase) {
	
										$baseprogram_pointer = 1;
							
										break ; 

									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu.ca
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							

							}				
						}
						
						if (!isset($current_campus[0]->name)){$delivery_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							
							
							$delivery_pointer = 0;		

							foreach ($current_campus as $current_single_campus){

									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
									if ($current_single_campus->name == $current_user_ysis->Campus) {
	
										$delivery_pointer = 1;
							
										break ; 
	
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu.ca
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu.ca

							
	
							}		
						}
						
				}
			}
			
			if (!isset($post->ID )){continue;}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				
				//var_dump($post);
				$posts_found += 1;
				
				// ------------------
				// Log for AskYU Searches
				switch_to_blog($askyu_site_id);
				$add_meta = add_post_meta($askyu_search_post, 'askyu_search_found_post', $site->blog_id.":".$array[0], false);
				
				switch_to_blog($site->blog_id); 
				// Make sure to switch back
				// ------------------
				
				$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
				if(get_the_post_thumbnail_url($post->ID,array(256,256))){
					$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
				}

				?>
					<div class="post">
						<div class="grid-x grid-padding-x grid-margin-y">
							<div class="cell small-12 large-4">
								<a href="<?php echo get_post_permalink( $post->ID ); ?>">
									<?php 
										if( has_post_thumbnail() != ""){
											the_post_thumbnail('full', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']);
										}else{
											?> <img src="<?php echo $img_source; ?>" class="img-responsive"> <?php
										}
									?>
								</a>
							</div>
							<div class="cell small-12 large-8">
								<a class="post-title underline" href="<?php echo get_post_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>
								<p class="post-meta"><span>from <?php echo get_bloginfo($site->blog_id) ?></span></p>
								<p>
									<?php
										$remove_shortcode = preg_replace('/[\[{\(].*[\]}\)]/U',"",$post->post_content); // 'ABC '
										echo strip_tags(strip_tags(substr($remove_shortcode,0,400)),"[]");
									?> [...]
								</p>
								<a class="button primary" href="<?php echo get_post_permalink( $post->ID ); ?>">View Article</a>
							</div>
						</div>
					</div>	
				<?php
			}// End Foreach $post 
			
		}// End If
		
	}// End Foreach $site
	restore_current_blog();
	

	// EMPTY SEARCH
	if($posts_found == 0){
		?>
			<div class="post">
				<div class="grid-x grid-padding-x grid-margin-y">
					<div class="cell small-12 large-12">
						<center>
							<h2 style="color:red;">We couldn't find anything for your question, sorry!</h2>
							<h4>You can submit your question to AskYU for further assistance</h4>
						</center>
					</div>
				</div>
			</div>	
		<?php
	}
	
	die;
	
}
add_action('wp_ajax_askyu_search', 'askyu_search');
add_action('wp_ajax_nopriv_askyu_search', 'askyu_search');

// =====================
// AskYU Search Tracker
// =====================
function askyu_searches_tracker_function() {
	add_menu_page( 'AskYU Searches', 'AskYU Searches', 'read', '/wp-content/themes/yu2018/functions_askyu.php', 'askyu_search_tracker', 'dashicons-search', 6  );
	
}
add_action( 'admin_menu', 'askyu_searches_tracker_function' );

function askyu_search_tracker(){

	global $wpdb; 

	$posts = get_posts(array(
		'post_type'	  => 'askyu_searches',
		'orderby'     => 'post_date',
		'limit' => 50,
		'posts_per_page' => 50,
	));
	
	
	?>
	
	<style>
	table {
		border-collapse: collapse;
	}

	table, th, td {
		border: 1px solid #ccc;
	}
	</style>
	
	<h2>AskYU Searches</h2>
	
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="">
					<a>
						<span>Search Term</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Result Posts
				</th>
				<th>
					<a>
						<span>
							Date
						</span>
						<span class="sorting-indicator">
						</span>
					</a>
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		<?php
			
		$terms = $_GET['terms'];
		
			foreach($posts as $post){
		
				?>
				<tr class="" id="" style="">
				
					<th class="check-column" scope="row">
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<h1>
						
							<a href="<?php echo '/home/?ignore=true&search='.$post->post_title; ?>" target="_blank">
								<?php echo $post->post_title; ?> 
							</a>
						</h1>
					</td>
					<td class="author column-author" >
						<?php 
							$metas = get_post_meta($post->ID, "askyu_search_found_post");
							if($metas){
								foreach($metas as $meta){
									
									$site_post = explode(":", $meta);
									
									switch_to_blog($site_post[0]);
									$search_post = get_post($site_post[1]);
									?>
										<div style="border:1px solid #779eff; padding:4px;">
											<strong><?php echo $search_post->post_title; ?></strong>
											<br />
											<i><?php echo get_blog_details($site_post[0])->domain; ?></i>
											<br />
											<a href="<?php echo get_post_permalink( $search_post->ID ); ?>" target="_blank">
											View
											</a>
											<a href="<?php echo get_edit_post_link( $search_post->ID ); ?>" target="_blank">
											Edit
											</a>
										</div>
									<?php
									$search_post_tags = wp_get_post_tags( $site_post[1], $args );
									?>
										<div style="border:1px dashed #7384ae; padding:4px; margin-bottom:10px;">
											<?php
											foreach($search_post_tags as $tag){
												?>
													<?php echo $tag->name; ?>, 
												<?php
											}
											?>
										</div>
									<?php
									restore_current_blog();
	
								}
							}
						?>
					</td>
					<td class="date column-date">
						<?php echo $post->post_date; ?>
					</td>
				</tr>
			<?php }
			
		?>
		
	
		</tbody>
	</table>
	
	<?php
	
}
