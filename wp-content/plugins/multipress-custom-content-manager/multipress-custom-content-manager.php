<?php

/*

Plugin Name: My Content Manager

Plugin URI: https://www.YorkvilleU.ca/

Description: Multisite Post Types Customization

Version: 1.0

Author: www.YorkvilleU.ca

Author URI: https://www.YorkvilleU.ca/

License: MIT

*/





// ADMIN: Network Plugins Menu Link

// =========================




//function check_permission($term_id, $tt_id, $taxonomy) {
//   $term = get_term($term_id, $taxonomy);
   
//   $custom_user = wp_get_current_user();
//   $user_role = $custom_user->roles;
   
 //  var_dump($custom_user);
//}
//add_action( 'edit_term_taxonomy', 'check_permission', 10, 3 );


add_action('admin_menu', 'admin_menu_add_posttags_page');

function admin_menu_add_posttags_page() {



	//create new top-level menu

	add_menu_page('Multi-Post-Tags', 'My Content Manager','edit_posts', 'multi_posttags', 'multipress_plugin_settings_page' , plugins_url('/images/posttags.png', __FILE__), 4 );
	
    //add_submenu_page('multi_posttags', 'Brands', 'Brands','editor', 'brandsinfo', 'brandsinfo_settings_page');
	//add_submenu_page('multi_posttags', 'Jurisdictions', 'Jurisdictions','editor','jurisdictionsinfo','jurisdictionsinfo_page');
	//add_submenu_page('multi_posttags', 'Delivery Modes','Delivery Modes', 'editor', 'deliverymodeinfo','deliverymodeinfo_page');
	//add_submenu_page('multi_posttags', 'Base Programs', 'Base Programs','editor','baseprograminfo','baseprograminfo_page');
	//add_submenu_page('multi_posttags', 'Review Frequencies','Review Frequencies', 'editor', 'reviewfrequenciesinfo','reviewfrequenciesinfo_page');
	//add_submenu_page('multi_posttags', 'Owners','Owners', 'editor', 'ownersinfo','ownersinfo_settings_page');
    
	add_submenu_page('multi_posttags', 'More Info', 'More Info','edit_posts', 'multipressmorepostinfo', 'multipress_moreinfo_settings_page');
    add_submenu_page('multi_posttags', 'Statistics', 'Statistics','edit_posts','multipressstatisticsinfo','multipress_statisticsinfo_page');
	add_submenu_page('multi_posttags', 'User Management','User Management','edit_posts', 'multipressusermanage','multipress_usermanage_page');
}

function multipress_moreinfo_settings_page(){
	?>
	<?php 
	
	global $wpdb;
	$uploads = wp_upload_dir();
	$file = fopen($uploads[path].'/network-posts-more.csv',"w");
	$single_post = array('Post Title', 'Post Link','Post/Page','Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hits');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<form action="#" method="post">
		
		<input type="hidden" name="page" value="network_posts" />
	
		Viewing Post/Page:
		<select name="blog_id">
			<option value="0">All</option>
			
			<?php
			// List all sites in a drop down
			$sites = get_sites();
			foreach($sites as $site){
				?>
					<option value="<?php echo $site->blog_id; ?>"><?php echo $site->domain; ?></option>
				<?php
			}
			?>
			
		</select>
		
		<!--<input type="text" name="terms" placeholder="Search..." value="<?php echo $_GET['terms']; ?>" />-->
		
		<input type="submit" name="submit" value="Search" />
		
	</form>
	
	<?php
	if (isset($_POST['submit'])){
		$selected_val = $_POST['blog_id'];
		//var_dump($selected_val);
		
		
	}
	else{
	}
	?>

					
	<h2 style="color:red;">
		<span id="network_search_results_shortcut"></span>
		<?php echo '<a href="'.$uploads[url].'/network-posts-more.csv'.'">'; ?><button class="btn" style="background-color: DodgerBlue;color:white;"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>

	
	
	<?php
				
	$query_current_visit_count	= "SELECT COUNT(*) as visitnumber FROM wp_posttrack WHERE DATE(hittime) = CURDATE()";
	$current_visit_count = $wpdb->get_results($query_current_visit_count);
	echo "&nbsp;&nbsp;&nbsp;".$current_visit_count[0]->visitnumber." Total Visit Today";
	
	?>
	
	</h2>
	
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>HitTime</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					User Type
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Site 
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post
				</th>
				<th scope="col" id="useragent" class="manage-column column-author">
					User Agent
				</th>
				<th scope="col" id="clientip" class="manage-column column-author">
					Client IP
				</th>
				<th scope="col" id="clienthost" class="manage-column column-author">
					Client Host IP
				</th>
				<th scope="col" id="querystring" class="manage-column column-author">
					Query String
				</th>
				
			</tr>
		</thead>
		<tbody id="the-list">
		
		
		<?php
		
		$file2 = fopen(wp_upload_dir()->url.'network-posts-more.csv',"w");
	$single_post_2 = array('HitTime', 'User Type','Site', 'Post','User Agent', 'Client IP', 'Client Host IP','Query String');
				//var_dump($single_post);
	fputcsv($file2,$single_post_2);
		
		    $query_all_pagepost = "SELECT * FROM wp_posttrack ORDER BY hittime DESC LIMIT 2000";
			$all_pagepost = $wpdb->get_results($query_all_pagepost);
			
		if (isset($selected_val)){}
		else {$selected_val = '0';}
		
			foreach($all_pagepost as $all_pageposts){
					
			if ($selected_val == '0') {}
			else {
				if ($all_pageposts->siteid == $selected_val) {}
				else {continue;}
			}
			
			
		
		?>
		
		
				<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $post->post_title; ?>
						</label>
						
					</th>
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
								<?php echo $all_pageposts->hittime; ?> 
							</a>
						</strong>
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php echo $all_pageposts->usertype; ?> 
					</td>
					<td class="author column-author" data-colname="Author">
						<?php global $wpdb;
	
	$sites = get_sites();
	foreach($sites as $site){
			// Get the new draft post ID
			if ($site->blog_id == $all_pageposts->siteid) {
				$current_site_domain = $site->domain;
				//var_dump($current_site_id);
			}
	}
	
	echo $current_site_domain; ?> 
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php 

	
						switch_to_blog($all_pageposts->siteid);
						echo '<a href="'.get_permalink($all_pageposts->postid).'">'.get_the_title($all_pageposts->postid).'</a>'; ?> 
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php echo $all_pageposts->useragent; ?> 
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php echo $all_pageposts->clientip; ?> 
					</td>
					<td class="author column-author" data-colname="Author">
						<?php echo $all_pageposts->clienthostip; ?> 
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php echo $all_pageposts->querystring; ?> 
					</td>
					
					
				<?php

$single_post_2 = array(strval($all_pageposts->hittime), strval($all_pageposts->usertype),strval($current_site_domain), strval($all_pageposts->postid), strval($all_pageposts->useragent), strval($all_pageposts->clientip), strval($all_pageposts->clienthostip), strval($all_pageposts->querystring));
			//var_dump($single_post);
			fputcsv($file2,$single_post_2);
			
			}
			
		?>
		
	</table>

	<?php
	return;
}

function multipress_statisticsinfo_page(){
	global $wpdb;

	$t=date('d-m-Y');
	$dayName = strtolower(date("D",strtotime($t)));
	$dayNum = strtolower(date("d",strtotime($t)));
	$dataPoints = array();
	
	for ($i = 1; $i<= intval($dayNum); $i++){
		//var_dump($i);
		$query_current_visit_count	= "SELECT COUNT(*) as visitnumber FROM wp_posttrack WHERE DATE(hittime) = CURDATE() - INTERVAL ".strval(intval($dayNum)-$i).' DAY';
		//var_dump($query_current_visit_count);
		$current_visit_count = $wpdb->get_results($query_current_visit_count);  
		 
		array_push($dataPoints, array("y"=>$current_visit_count[0]->visitnumber,"label"=>date('F')." ".strval($i)));
	}
	
	


$dataPoints_site=array();
$query_total_view_today = "SELECT COUNT(hittime) AS counthit FROM wp_posttrack WHERE DATE(hittime) = CURDATE() ORDER BY siteid";

$total_view_today = $wpdb->get_results($query_total_view_today); 
$totalviews= intval($total_view_today[0]->counthit);

$sites = get_sites();
foreach($sites as $site){
$query_view_by_sites = "SELECT COUNT(hittime) as hitcount,siteid FROM wp_posttrack WHERE DATE(hittime) = CURDATE() AND siteid = ".$site->blog_id." GROUP BY siteid";
$view_by_sites= $wpdb->get_results($query_view_by_sites);  
//var_dump($query_view_by_sites);
//var_dump($view_by_sites);

	if (isset($view_by_sites[0]->hitcount)) {
		//var_dump($view_by_sites[0]->hitcount/$totalviews*100);
		array_push($dataPoints_site, array("label"=>$site->domain,"symbol"=>$site->domain,"y"=>$view_by_sites[0]->hitcount/$totalviews*100));
	}
	else {
		array_push($dataPoints_site, array("label"=>$site->domain,"symbol"=>$site->domain,"y"=>0));
	}
}


$query_current_ip	= "SELECT clientip FROM wp_posttrack ORDER BY hittime DESC LIMIT 50";
$current_ip = $wpdb->get_results($query_current_ip);  
$dataPointspie = array();
$ontario = 0;
$newbrun = 0;
$vanc = 0;
$otherpro = 0;
foreach ($current_ip as $ips){
	$ipaddress = "http://ipinfo.io/".preg_replace('/\s+/', '', $ips->clientip);
	//var_dump($ipaddress);
	
	$details = json_decode(file_get_contents($ipaddress));
	//var_dump($details->region);
	if ($details->region == "Ontario"){
		$ontario++;
	}
	elseif ($details->region = "New Brunswick"){
		$newbrun++;
	}
	elseif ($details->region = "British Columbia"){
		$vanc++;
	}
	else {
		$otherpro++;
	}
}

	
 $dataPointspie = array(
	array("label"=> "Ontario", "y"=> $ontario),
	array("label"=> "New Brunswick", "y"=> $newbrun),
	array("label"=> "British Columbia", "y"=> $vanc),
	array("label"=> "Other Provinces", "y"=> $otherpro)
);


 
?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "WordPress Site Page Hit/View Over a Month"
	},
	axisY: {
		title: "Number of Page Hits/Views"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "WordPress Total View by Province For first 50 ips"
	},
	subtitles: [{
		text: "Ontario, New Brunswick, British Columbia, etc."
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		yValueFormatString: "#,##0",
		dataPoints: <?php echo json_encode($dataPointspie, JSON_NUMERIC_CHECK); ?>
	}]
});

var chart3 = new CanvasJS.Chart("chartContainer3", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Total Views by Site Today"
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		dataPoints: <?php echo json_encode($dataPoints_site, JSON_NUMERIC_CHECK); ?>
	}]
});


chart.render();
 chart2.render();
 chart3.render();
}
</script>

<div id="chartContainer" style="height: 370px; width: 90%;margin-top:50px;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div id="chartContainer3" style="height: 370px; width: 90%;margin-top:50px;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div id="chartContainer2" style="height: 370px; width: 90%;margin-top:50px;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php
	return;
}

function multipress_usermanage_page(){
	?>
	<?php 
	
	global $wpdb;
	
	$file = fopen($uploads[path].'network-posts-users.csv',"w");
	$single_post = array('Post Title', 'Post Link','Post/Page','Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hits');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<h2 style="color:red;">
		<span id="network_search_results_shortcut"></span>
		<a href="<?php echo $uploads[path].'network-posts-users.csv'; ?>"><button class="btn" style="background-color: DodgerBlue;color:white;">><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>
	</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="author" class="manage-column column-author">
					User Name
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Failed Login Attempts
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Date of Registration
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Date of Last Login
				</th>
				
			</tr>
		</thead>
		<tbody id="the-list">
		<?php
		
	$file_user = fopen(wp_upload_dir()->url.'network-posts-users.csv',"w");
	$single_user=array('User Name', 'Failed Login Attempts','Date of Registration', 'Date of Last Login');
				//var_dump($single_post);
	fputcsv($file_user,$single_user);
		
	$query_all_users = "SELECT * FROM wp_users ORDER BY user_login";
	$all_users = $wpdb->get_results($query_all_users);
	//var_dump($all_users);		

	foreach($all_users as $all_user){
					
		$query_all_usertrack = "SELECT * FROM wp_usertrack where username='".$all_user->user_login."'";
		$all_usertrack = $wpdb->get_results($query_all_usertrack);
		
		if (isset($all_usertrack[0]->failed_attempts)) {
						$te = $all_usertrack[0]->failed_attempts; }
						else {$te =0;}
						
		if (isset($all_usertrack[0]->last_login_date)){
						$la =  $all_usertrack[0]->last_login_date; }
						else{$la =  'Not applicable at this Moment';}
		$single_post_user  = array(strval($all_user->user_login), strval($te), strval($all_user ->user_registered),strval($la));
				//var_dump($single_post);
		fputcsv($file_user ,$single_post_user);
		?>
				<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $post->post_title; ?>
						</label>
						
					</th>
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
								<?php 
								
								//echo get_avatar($all_user->ID);
								echo $all_user->user_login; ?> 
						</a>
							
							</a>
						</strong>
					</td>
					<td class="author column-author" data-colname="Author">
						<?php  
						if (isset($all_usertrack[0]->failed_attempts)) {
						echo $all_usertrack[0]->failed_attempts; }
						else {echo 0;}?> 
					</td>
					
					<td class="author column-author" data-colname="Author">
						<?php echo $all_user ->user_registered; ?> 
					</td>
					<td class="author column-author" data-colname="Author">
						<?php 
						if (isset($all_usertrack[0]->last_login_date)){
						echo $all_usertrack[0]->last_login_date; }
						else{echo 'Not applicable at this Moment';}?> 
					</td>
				</tr>
	<?php
	}
	?>
	</table>
	<?php
	return;
}


function brandsinfo_settings_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_brands = 0;
	
	?>
		
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="brands" class="manage-column column-author">
					Brands
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="post_pate" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="lastauthor" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_brand_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'brand'";
		$current_brand_count = $wpdb->get_results($query_current_brand_count);
		//var_dump($current_brand_count);
		foreach ($current_brand_count as $count_brand){
			$sum_brands = $sum_brands+intval($count_brand->COUNT);
		}
		
		$query_current_brand_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'brand'";
		$current_brand_post_id = $wpdb->get_results($query_current_brand_post_id);
		//var_dump($current_brand_post_id);
		
		
		
		foreach ($current_brand_post_id as $current_post_retrieve){
			$current_brand_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_brand_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_brand_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_brand_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_brand_post->guid; ?>" target="_blank">
								<?php echo $current_brand_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_brand_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_brand_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
					
					<td class="author column-author" data-colname="Author">
					
						<?php 
						//var_dump($current_post_retrieve->object_id);
						$query_current_post_brands = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='brand' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_brand);
						$current_post_brands = $wpdb->get_results($query_current_post_brands);
						//var_dump($current_post_brands);
						foreach ($current_post_brands as $current_post_brand){
							$query_current_brand_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_brand->term_id;
							$current_brand_name = $wpdb->get_results($query_current_brand_name);
							echo $current_brand_name[0]->name."<br />"; 
						}
						?>
						
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					
					
					<td class="author column-author" data-colname="Author">
						<?php echo $current_brand_post->post_type; ?>
				        <br />
						<?php 
						if ($current_brand_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_brand_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_brand_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_brand_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								//echo '<span><br /><div>('.$author.')</div></span>';
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								//echo '<span><br /><div>'.$author.'</div></span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span><br /><div>'.$author.'</div></span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_brand_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_brand_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_brand_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
		
		}
		
		?>


		<?php
		
		$query_current_brand_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'brand'";
		$current_brand_list = $wpdb->get_results($query_current_brand_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_brands);
}

function jurisdictionsinfo_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_jurisdictions = 0;
	
	?>

	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="jurisdictions" class="manage-column column-author">
					Jurisdictions
				</th>
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_jurisdiction_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'jurisdiction'";
		$current_jurisdiction_count = $wpdb->get_results($query_current_jurisdiction_count);
		//var_dump($current_jurisdiction_count);
		foreach ($current_jurisdiction_count as $count_jurisdiction){
			$sum_jurisdictions = $sum_jurisdictions+intval($count_jurisdiction->COUNT);
		}
		
		$query_current_jurisdiction_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'jurisdiction'";
		$current_jurisdiction_post_id = $wpdb->get_results($query_current_jurisdiction_post_id);
		//var_dump($current_jurisdiction_post_id);
		
		
		foreach ($current_jurisdiction_post_id as $current_post_retrieve){
			$current_jurisdiction_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_jurisdiction_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_jurisdiction_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_jurisdiction_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_jurisdiction_post->guid; ?>" target="_blank">
								<?php echo $current_jurisdiction_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_jurisdiction_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_jurisdiction_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
		
					<td class="author column-author" data-colname="Author">
						
						<?php 
						//var_dump($current_post_retrieve->object_id);
						$query_current_post_jurisdictions = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='jurisdiction' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_jurisdiction);
						$current_post_jurisdictions = $wpdb->get_results($query_current_post_jurisdictions);
						//var_dump($current_post_jurisdictions);
						foreach ($current_post_jurisdictions as $current_post_jurisdiction){
							$query_current_jurisdiction_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_jurisdiction->term_id;
							$current_jurisdiction_name = $wpdb->get_results($query_current_jurisdiction_name);
							echo $current_jurisdiction_name[0]->name."<br />"; 
						}
						?>
						
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					<td class="author column-author" data-colname="Author">
						<?php echo $current_jurisdiction_post->post_type; ?>
				        <br />
						<?php 
						if ($current_jurisdiction_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_jurisdiction_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_jurisdiction_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_jurisdiction_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span>'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_jurisdiction_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_jurisdiction_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_jurisdiction_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
		
		}
		
		?>


		<?php
		
		$query_current_jurisdiction_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'jurisdiction'";
		$current_jurisdiction_list = $wpdb->get_results($query_current_jurisdiction_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_jurisdictions);
}
function deliverymodeinfo_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_deliverys = 0;
	
	?>
		
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="deliverymode" class="manage-column column-author">
					Delivery Mode
				</th>
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_delivery_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'delivery'";
		$current_delivery_count = $wpdb->get_results($query_current_delivery_count);
		//var_dump($current_delivery_count);
		foreach ($current_delivery_count as $count_delivery){
			$sum_deliverys = $sum_deliverys+intval($count_delivery->COUNT);
		}
		
		$query_current_delivery_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'delivery'";
		$current_delivery_post_id = $wpdb->get_results($query_current_delivery_post_id);
		//var_dump($current_delivery_post_id);
		
		
		foreach ($current_delivery_post_id as $current_post_retrieve){
			$current_delivery_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_delivery_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_delivery_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_delivery_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_delivery_post->guid; ?>" target="_blank">
								<?php echo $current_delivery_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_delivery_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_delivery_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
		
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_deliverys = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='delivery' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_delivery);
						$current_post_deliverys = $wpdb->get_results($query_current_post_deliverys);
						//var_dump($current_post_deliverys);
						foreach ($current_post_deliverys as $current_post_delivery){
							$query_current_delivery_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_delivery->term_id;
							$current_delivery_name = $wpdb->get_results($query_current_delivery_name);
							echo $current_delivery_name[0]->name."<br />"; 
						}
						?>
						
					</td>
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					<td class="author column-author" data-colname="Author">
						<?php echo $current_delivery_post->post_type; ?>
				        <br />
						<?php 
						if ($current_delivery_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_delivery_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					    
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_delivery_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span>'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_delivery_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_delivery_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_delivery_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
		
		}
		
		?>


		<?php
		
		$query_current_delivery_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'delivery'";
		$current_delivery_list = $wpdb->get_results($query_current_delivery_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_deliverys);
}
function baseprograminfo_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_baseprograms = 0;
	
	?>
		
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="base_programs" class="manage-column column-author">
					Base Programs
				</th>
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_baseprogram_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'baseprogram'";
		$current_baseprogram_count = $wpdb->get_results($query_current_baseprogram_count);
		//var_dump($current_baseprogram_count);
		foreach ($current_baseprogram_count as $count_baseprogram){
			$sum_baseprograms = $sum_baseprograms+intval($count_baseprogram->COUNT);
		}
		
		$query_current_baseprogram_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'baseprogram'";
		$current_baseprogram_post_id = $wpdb->get_results($query_current_baseprogram_post_id);
		//var_dump($current_baseprogram_post_id);
		
		
		foreach ($current_baseprogram_post_id as $current_post_retrieve){
			$current_baseprogram_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_baseprogram_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_baseprogram_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_baseprogram_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_baseprogram_post->guid; ?>" target="_blank">
								<?php echo $current_baseprogram_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_baseprogram_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_baseprogram_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
		
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_baseprograms = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='baseprogram' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_baseprograms);
						$current_post_baseprograms = $wpdb->get_results($query_current_post_baseprograms);
						//var_dump($current_post_baseprograms);
						foreach ($current_post_baseprograms as $current_post_baseprogram){
							$query_current_baseprogram_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_baseprogram->term_id;
							$current_baseprogram_name = $wpdb->get_results($query_current_baseprogram_name);
							echo $current_baseprogram_name[0]->name."<br />"; 
						} 
						?>
						
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					<td class="author column-author" data-colname="Author">
						<?php echo $current_baseprogram_post->post_type; ?>
				        <br />
						<?php 
						if ($current_baseprogram_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_baseprogram_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_baseprogram_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_baseprogram_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span>'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_baseprogram_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_baseprogram_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_baseprogram_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
		
		}
		
		?>


		<?php
		
		$query_current_baseprogram_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'baseprogram'";
		$current_baseprogram_list = $wpdb->get_results($query_current_baseprogram_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_baseprograms);
}
function reviewfrequenciesinfo_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_reviewfrequencys = 0;
	
	?>
		
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="review_frequencies_plugin" class="manage-column column-author">
					Review Frequencies
				</th>
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_reviewfrequency_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'reviewfrequency'";
		$current_reviewfrequency_count = $wpdb->get_results($query_current_reviewfrequency_count);
		//var_dump($current_reviewfrequency_count);
		foreach ($current_reviewfrequency_count as $count_reviewfrequency){
			$sum_reviewfrequencys = $sum_reviewfrequencys+intval($count_reviewfrequency->COUNT);
		}
		
		$query_current_reviewfrequency_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'reviewfrequency'";
		$current_reviewfrequency_post_id = $wpdb->get_results($query_current_reviewfrequency_post_id);
		//var_dump($current_reviewfrequency_post_id);
		
		
		foreach ($current_reviewfrequency_post_id as $current_post_retrieve){
			$current_reviewfrequency_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_reviewfrequency_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_reviewfrequency_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_reviewfrequency_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_reviewfrequency_post->guid; ?>" target="_blank">
								<?php echo $current_reviewfrequency_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_reviewfrequency_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_reviewfrequency_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
					
					<td>
						<?php
						$query_current_post_reviewfrequencies = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='reviewfrequency' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_reviewfrequencies);
						$current_post_reviewfrequencies = $wpdb->get_results($query_current_post_reviewfrequencies);
						//var_dump($current_post_reviewfrequencies);
						foreach ($current_post_reviewfrequencies as $current_post_reviewfrequency){
							$query_current_reviewfrequency_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_reviewfrequency->term_id;
							$current_reviewfrequency_name = $wpdb->get_results($query_current_reviewfrequency_name);
							echo $current_reviewfrequency_name[0]->name."<br />"; 
						}
						?>
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					<td class="author column-author" data-colname="Author">
						<?php echo $current_reviewfrequency_post->post_type; ?>
				        <br />
						<?php 
						if ($current_reviewfrequency_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_reviewfrequency_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_reviewfrequency_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_reviewfrequency_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span>'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_reviewfrequency_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_reviewfrequency_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_reviewfrequency_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
		
		}
		
		?>


		<?php
		
		$query_current_reviewfrequency_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'reviewfrequency'";
		$current_reviewfrequency_list = $wpdb->get_results($query_current_reviewfrequency_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_reviewfrequencys);
}

function ownersinfo_settings_page(){
	global $wpdb;
	
	$all_multisites = get_sites();
	
	$sum_owners = 0;
	
	?>
		
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="post_owners" class="manage-column column-author">
					Owners
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="post_pate" class="manage-column column-author">
					Post / Page
				</th>
				<th scope="col" id="lastauthor" class="manage-column column-author">
					Last Edited Author
				</th>
				<th scope="col" id="date2" class="manage-column column-date sortable asc">
					<!--<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc">-->
						<span>
							Last Modified Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
		
		<?php
	
	foreach($all_multisites as $all_multisite){
		//var_dump($all_multisite->domain);
		
		switch_to_blog($all_multisite->id);
		
		$query_current_owners_count	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'postowners'";
		$current_owner_count = $wpdb->get_results($query_current_owners_count);
		//var_dump($current_brand_count);
		foreach ($current_owner_count as $count_owner){
			$sum_owners = $sum_owners+intval($count_owner->COUNT);
		}
		
		$query_current_owner_post_id = "SELECT distinct object_id FROM wp_".$all_multisite->id."_term_relationships JOIN wp_".$all_multisite->id."_term_taxonomy WHERE wp_".$all_multisite->id."_term_relationships.term_taxonomy_id = wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id AND wp_".$all_multisite->id."_term_taxonomy.taxonomy = 'postowners'";
		$current_owner_post_id = $wpdb->get_results($query_current_owner_post_id);
		//var_dump($current_owner_post_id);
		
		
		
		foreach ($current_owner_post_id as $current_post_retrieve){
			$current_owner_post = get_post($current_post_retrieve->object_id);
			//var_dump($current_owner_post);
			if (is_null($current_owner_post)) {}
			else {
				//var_dump($current_owner_post);
	
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $current_owner_post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $current_owner_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $current_owner_post->guid; ?>" target="_blank">
								<?php echo $current_owner_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$current_owner_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$current_owner_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
					
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_postowners = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='postowners' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_retrieve->object_id;
						//var_dump($query_current_post_postowners);
						$current_post_postowners = $wpdb->get_results($query_current_post_postowners);
						//var_dump($current_post_postowners);
						foreach ($current_post_postowners as $current_post_postowner){
							$query_current_postowner_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_postowner->term_id;
							$current_postowner_name = $wpdb->get_results($query_current_postowner_name);
							echo $current_postowner_name[0]->name."<br />"; 
						}
						?>
						
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>"><?php echo $all_multisite->domain; ?></a>
					</td>
					
					
					<td class="author column-author" data-colname="Author">
						<?php echo $current_owner_post->post_type; ?>
				        <br />
						<?php 
						if ($current_owner_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($current_owner_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $current_delivery_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$current_owner_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $current_owner_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img width="50" height="50" />';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<span>'.get_avatar($author_id).'</span>';
								echo '<img id="header-avatar" src="'.get_avatar_url($author_id).'" style="float:none;" />'; 
								restore_current_blog();
							}
							
							//echo '<span>'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $current_owner_post->post_status; ?>
						<br>
						<abbr title=""><?php echo $current_owner_post->post_modified; ?></abbr>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo $current_owner_post->comment_count;
					   ?>
					   
					</td>
					
				</tr>

			
			<?php
			}
		}
		
		?>
		<?php
		
		$query_current_owner_list	= "SELECT COUNT FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'postowners'";
		$current_owner_list = $wpdb->get_results($query_current_owner_list);
				
		//
		restore_current_blog();
	}
	
	?>
	
		</tbody>
	</table>
	
	<?php
	//var_dump($sum_owners);
}


function multipress_plugin_settings_page() {

	?>

	<?php
	global $wpdb;
	$uploads = wp_upload_dir();
	  
	$file = fopen($uploads[path].'/network-posts.csv','w');
	$single_post = array('Post Title', 'Post Link','Post/Page','Post Categories', 'Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hit/Views', 'Comments', 'Brands','Jurisdictions','Based Program', 'Delivery Modes','Review Frequencies','Owners');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	
	<br />
	<button id="view_mine" onclick="LoadMine()" style="background:yellow;">View Mine</button>

	<?php
	//var_dump($uploads);
	$current_user_check = wp_get_current_user();
	$current_user_role_check = wp_get_current_user()->roles;
	if (is_super_admin(intval($current_user_check->ID)))  { 
		echo "<button id=\"view_all\" onclick=\"LoadAll()\">View All</button>";
		echo "<span id=\"network_search_results_shortcut\"></span>";
		echo '<a href="'.$uploads[url].'/network-posts.csv'.'"><button class="btn" style="background-color: DodgerBlue;color:white;"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>';
						
	}
	else if ($current_user_role_check[0] == 'administrator') { 
		echo "<button id=\"view_all\" onclick=\"LoadAll()\">View All</button>";
		echo "<span id=\"network_search_results_shortcut\"></span>";
		echo '<a href="'.$uploads[url].'/network-posts.csv'.'"><button class="btn" style="background-color: DodgerBlue;color:white;"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>';
	}
	
	echo '<br /><br />';
	echo 'Page &nbsp;<span id="page_number">1</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo 'Page Pagination: &nbsp;';
	
	echo '<span id="page_pagination"></span>';
	echo '<span id="all_page_pagination"></span>';
		
	?>
	
	<script type="text/javascript">
	function changeallpag(str) {
		var all_posts = document.getElementsByClassName("loadall");
		var arrayLength = all_posts.length;
		var page_number = parseInt(str);
		var post_per_page = 10;
		
		for (var i = 0; i < arrayLength; i++) {
			if ((i >= (page_number-1)*post_per_page) && (i < page_number *post_per_page)){
				all_posts[i].style.display = "table-row";

			}	
			else {
				all_posts[i].style.display = "none";
			}
            //alert((page_number-1)*post_per_page);
		    //alert(page_number *post_per_page);
		}
		
		document.getElementById("all_page_button_".concat(document.getElementById("page_number").innerHTML)).style.backgroundColor = "transparent";
		document.getElementById("all_page_button_".concat(str.toString())).style.backgroundColor = "yellow";
			
		document.getElementById("page_number").innerHTML = str.toString();	

	}	

	</script>
	
	<script type="text/javascript">
	function changepag(str) {
		var all_posts = document.getElementsByClassName("loadall");
		var arrayLength = all_posts.length;
		var page_number = parseInt(str);
		var post_per_page = 10;
		var my_post_count = 0;
		
		for (var i = 0; i < arrayLength; i++) {
			
			if (all_posts[i].style.backgroundColor == "transparent"){
				 my_post_count =  my_post_count + 1;
				 
				 if ((my_post_count >= (page_number-1)*post_per_page) && (my_post_count < page_number *post_per_page)){
					all_posts[i].style.display = "table-row";
				}	
				else {
					all_posts[i].style.display = "none";
				}
			}
			
			
            //alert((page_number-1)*post_per_page);
		    //alert(page_number *post_per_page);
		}	

		document.getElementById("page_button_".concat(document.getElementById("page_number").innerHTML)).style.backgroundColor = "transparent";
		document.getElementById("page_button_".concat(str.toString())).style.backgroundColor = "yellow";
		
		document.getElementById("page_number").innerHTML = str;	

	}	

	</script>
	
	<script type="text/javascript">
	function LoadAll() {
		document.getElementById("view_all").style.backgroundColor = "yellow";
		document.getElementById("view_mine").style.backgroundColor = "transparent";
		var allposts = document.getElementsByClassName("loadall");
		var post_per_page = 10;
		var arrayLength = allposts.length;
		
		
		for (var i = 0; i < arrayLength; i++) {
            if (i < post_per_page) {
				if (allposts[i].style.display == "none"){
					allposts[i].style.display = "table-row";
				}	

			}	
			else {
				allposts[i].style.display = "none";
			}
		}
		
		var post_per_page = 10;
		var shortcut = document.getElementById("all_page_pagination");
		var str1 = "";
		for (ii = 1; ii<=Math.ceil(arrayLength/post_per_page);ii++){
			str1 = str1.concat('<button style="background:transparent;" id="all_page_button_').concat(ii.toString()).concat('" type="button" onclick="changeallpag(').concat(ii.toString()).concat(')">').concat(ii.toString()).concat('</button>&nbsp;');
		}
		shortcut.innerHTML = str1;
		document.getElementById("all_page_button_1").style.backgroundColor = "yellow";	
		document.getElementById("page_number").innerHTML = '1';	
		document.getElementById("page_pagination").style.display = "none";
		document.getElementById("all_page_pagination").style.display = "block";	
	}	

	</script>
	
	<script type="text/javascript">
	function LoadMine() {
		document.getElementById("view_all").style.backgroundColor = "transparent";
		document.getElementById("view_mine").style.backgroundColor = "yellow";
		var myposts = document.getElementsByClassName("loadall");
		var MyarrayLength = myposts.length;
		for (var i = 0; i < MyarrayLength; i++) {
			if (myposts[i].style.backgroundColor == "transparent"){
				myposts[i].style.display = "table-row";
			}
			else {
				myposts[i].style.display = "none";
			}
		}
		
		document.getElementById("all_page_pagination").style.display = "none";
		document.getElementById("page_pagination").style.display = "block";
		
		document.getElementById("page_number").innerHTML = '1';	
	}	

	</script>
	
	<?php
			
		//$terms = $_GET['searchterms'];
		$results = 0;
		
		//var_dump($selected_term);
		
		
		$sites = get_sites();
		
		if (isset($selected_val)){}
		else {$selected_val = '0';}
		
		$totalmiltiposts = 0;
		
		//csv functions
		foreach($sites as $csvsite){
			
			if ($selected_val == '0') {}
			else {
				if ($csvsite->blog_id == $selected_val) {}
				else {continue;}
			}
			switch_to_blog($csvsite->id);
			$csvargs = array(
			    
				'posts_per_page' => 10000,
				'offset' => 0,
				'category'         => '',
				'category_name'    => '',
				'orderby'          => 'date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => array( 'post', 'page' ),
				'post_mime_type'   => '',
				'post_parent'      => '',
				'author'	   => '',
				'author_name'	   => '',
				'post_status'      => 'publish',
				'suppress_filters' => true,
				's'				   => $terms
			);
			
			$csvposts = get_posts( $csvargs );
			
			
			foreach ($csvposts as $line)
			{
				$author = "Unknown";
				$author_id = 0;
				switch_to_blog($csvsite->id);
				$users = get_users( array( 'search' => $line->post_author ) );
				foreach($users as $user){
					$author = $user->data->user_nicename;
					$author_id = $user->id;
				}
				
				
				if (!isset($selected_term)){}
				elseif (empty($selected_term)){}
				elseif (strpos(strtolower($post->post_title),strtolower($selected_term)) !== false){}
				elseif (strpos(strtolower($site->domain),strtolower($selected_term)) !== false){}
				elseif (strpos(strtolower($author),strtolower($selected_term)) !== false){}
				else {continue;}
				
			    //var_dump($site->domain);
				//var_dump($author);
				
				$query_current_post_access	= "SELECT accessnumber,lastedit,totalhit FROM wp_postinfo WHERE postid=".$line->ID." AND siteid=".$site->blog_id;
				$current_post_access = $wpdb->get_results($query_current_post_access);
				if (isset($current_post_access[0]->accessnumber)) {
					//$access_number = (string)$current_post_access[0]->accessnumber;
					$totalhits = (string)$current_post_access[0]->totalhit;
					$last_author = (string)$current_post_access[0]->lastedit;
				}
				else {
					//$access_number = '0';
					$totalhits = '0';
					$last_author = $author;
				}
				$access_number = wp_get_post_revisions( $line->ID );
				//var_dump($access_number);
				$access_number = count( $access_number );
				$post_comments = wp_count_comments($line->ID);
				if ($line->post_type=='post'){
							switch_to_blog($csvsite->id);
							$line_cates = get_the_category($line->ID); 
							//var_dump($post_cates);
							foreach ($line_cates as $line_cate) {
								$this_post_cat= $line_cate->name.", ";
							}
							restore_current_blog();
						}
				else {
					$this_post_cat =  "n/a";
				}
				
				$current_brands_name = '  ';
				$query_current_post_brands = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='brand' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_brands);
				$current_post_brands = $wpdb->get_results($query_current_post_brands);
				//var_dump($current_post_brands);
				if (empty($current_post_brands[0])) {$current_brands_name = 'N/A  ';}
				foreach ($current_post_brands as $current_post_brand){
					$query_current_brand_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_brand->term_id;
					$current_brand_name = $wpdb->get_results($query_current_brand_name);
					//var_dump($current_brand_name);
					if (isset($current_brand_name[0]->name)){$current_brands_name = $current_brands_name.$current_brand_name[0]->name.', '; }
					else {echo $current_brands_name = 'N/A  ';}
							
				}	
				$current_brands_name = substr($current_brands_name,0, strlen($current_brands_name)-2);
				
				$current_jurisdictions_name = '  ';
				$query_current_post_jurisdictions = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='jurisdiction' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_jurisdictions);
				$current_post_jurisdictions = $wpdb->get_results($query_current_post_jurisdictions);
				//var_dump($current_post_jurisdictions);
				if (empty($current_post_jurisdictions[0])) {$current_jurisdictions_name='N/A  ';}
				foreach ($current_post_jurisdictions as $current_post_jurisdiction){
					$query_current_jurisdiction_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_jurisdiction->term_id;
					$current_jurisdiction_name = $wpdb->get_results($query_current_jurisdiction_name);
					//var_dump($current_jurisdiction_name);
					if (isset($current_jurisdiction_name[0]->name)){$current_jurisdictions_name = $current_jurisdictions_name.$current_jurisdiction_name[0]->name.', '; }
					else {$current_jurisdictions_name='N/A  ';}
							
				}	
				$current_jurisdictions_name = substr($current_jurisdictions_name,0, strlen($current_jurisdictions_name)-2);
				
				$current_deliverys_name = '  ';
				$query_current_post_deliverys = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='delivery' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_deliverys);
				$current_post_deliverys = $wpdb->get_results($query_current_post_deliverys);
				//var_dump($current_post_deliverys);
				if (empty($current_post_deliverys[0])) {$current_deliverys_name = 'N/A  ';}
				foreach ($current_post_deliverys as $current_post_delivery){
					$query_current_delivery_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_delivery->term_id;
					$current_delivery_name = $wpdb->get_results($query_current_delivery_name);
					//var_dump($current_delivery_name);
					if (isset($current_delivery_name[0]->name)){$current_deliverys_name = $current_deliverys_name.$current_delivery_name[0]->name.', '; }
					else {$current_deliverys_name = 'N/A  ';}
							
				}
				$current_deliverys_name = substr($current_deliverys_name,0, strlen($current_deliverys_name)-2);
				
				$current_programs_name = '  ';
				$query_current_post_baseprograms = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='baseprogram' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_baseprograms);
				$current_post_baseprograms = $wpdb->get_results($query_current_post_baseprograms);
				//var_dump($current_post_baseprograms);
				if (empty($current_post_baseprograms[0])) {$current_programs_name = 'N/A  ';}
				foreach ($current_post_baseprograms as $current_post_baseprogram){
					$query_current_baseprogram_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_baseprogram->term_id;
					$current_baseprogram_name = $wpdb->get_results($query_current_baseprogram_name);
					//var_dump($current_baseprogram_name);
					if (isset($current_baseprogram_name[0]->name)){$current_programs_name = $current_programs_name.$current_baseprogram_name[0]->name.', '; }
					else {$current_programs_name = 'N/A  ';}
							
				}	
				$current_programs_name = substr($current_programs_name,0, strlen($current_programs_name)-2);
				
				$current_frequencies_name = '  ';				
				$query_current_post_reviewfrequency = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='reviewfrequency' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_reviewfrequency);
				$current_post_reviewfrequencies = $wpdb->get_results($query_current_post_reviewfrequency);
				//var_dump($current_post_reviewfrequencies);
				if (empty($current_post_reviewfrequencies[0])) {$current_frequencies_name = 'N/A  ';}
				foreach ($current_post_reviewfrequencies as $current_post_reviewfrequency){
					$query_current_reviewfrequency_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_reviewfrequency->term_id;
					$current_reviewfrequency_name = $wpdb->get_results($query_current_reviewfrequency_name);
					//var_dump($current_reviewfrequency_name);
					if (isset($current_reviewfrequency_name[0]->name)){$current_frequencies_name = $current_frequencies_name.$current_reviewfrequency_name[0]->name.', '; }
					else {$current_frequencies_name = 'N/A  ';}
							
				}	
				$current_frequencies_name = substr($current_frequencies_name,0, strlen($current_frequencies_name)-2);
				
				$current_postowners_name = '  ';		
				$query_current_post_postowners = "SELECT term_id FROM wp_".$csvsite->id."_term_taxonomy JOIN wp_".$csvsite->id."_term_relationships WHERE wp_".$csvsite->id."_term_taxonomy.term_taxonomy_id = wp_".$csvsite->id."_term_relationships.term_taxonomy_id AND taxonomy='postowners' AND wp_".$csvsite->id."_term_relationships.object_id = ".$line->ID;
				//var_dump($query_current_post_postowners);
				$current_post_postowners = $wpdb->get_results($query_current_post_postowners);
				//var_dump($current_post_postowners);
				if (empty($current_post_postowners[0])) {$current_postowners_name = 'N/A  ';}
				foreach ($current_post_postowners as $current_post_postowner){
					$query_current_postowner_name = "SELECT name FROM wp_".$csvsite->id."_terms WHERE term_id = ".$current_post_postowner->term_id;
					$current_postowner_name = $wpdb->get_results($query_current_postowner_name);
					//var_dump($current_postowner_name);
					if (isset($current_postowner_name[0]->name)){$current_postowners_name = $current_postowners_name.$current_postowner_name[0]->name.', '; }
					else {$current_postowners_name = 'N/A  ';}
							
				}
				$current_postowners_name = substr($current_postowners_name,0, strlen($current_postowners_name)-2);		
				
						

				$single_post = array(strval($line->post_title), strval($line->guid), strval($line->post_type),strval($this_post_cat),strval($csvsite->domain), strval($author), $line->post_date, strval($last_author),$line->post_modified,strval($access_number),strval($totalhits),strval(wp_count_comments($line->ID)->total_comments),strval($current_brands_name), strval($current_jurisdictions_name),strval($current_deliverys_name),strval($current_programs_name),strval($current_frequencies_name),strval($current_postowners_name));
				//var_dump($single_post);
				fputcsv($file,$single_post);
				restore_current_blog();
			}
		}
	?>
	<br /><br />
	
	<table class="wp-list-table widefat striped posts" style="overflow-x:scroll !important;">
		<thead>
			<tr>
				<td id="cb" class="manage-column column-cb check-column">
					<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
				</td>
				
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc">
						<span>Title</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website: Post(+categories) / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Original Author + Post Date
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Last Modified Author + Date
				</th>
				<th scope="col" id="title_brands" class="manage-column column-author">
					Brands & Jurisdictions
				<th scope="col" id="title_delivery" class="manage-column column-author">
					Delivery Modes
				</th>
				<th scope="col" id="title_Base" class="manage-column column-author">
					Base Programs
				</th>
				<th scope="col" id="title_Frequencies" class="manage-column column-author">
					Review Frequencies
				</th>
				<th scope="col" id="title_Owners" class="manage-column column-author">
					Owners
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Edit Times/Total Hits/Comments
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
    <?php 
	$sites = get_sites();
	
    $current_user = wp_get_current_user();
	$userole=$current_user->roles;
	
	global $all_post_id;
	global $admin_post;
	
	$all_post_id = 0;
	
	$admin_post = [];
	
	
	$post_page = 1;
	
	$my_post_page = 1;
	
	$number_per_page = 10;
	
	$my_post_count = 0;

	//var_dump($current_user->user_email);
	
	//var_dump(is_super_admin(intval($current_user->ID)));

	foreach($sites as $all_multisite){

		switch_to_blog($all_multisite->id);
		
		$args=array(
				'posts_per_page'=>-1, 
				'post_type' => array('post','page'),	
				'post_status' => 'publish',
				
		);
		$my_posts = get_posts( $args );
		//var_dump($my_posts);
		
		foreach ($my_posts as $currnet_post){
			
			
			$post_count = $post_count + 1;
			
			$current_post_id = $currnet_post->ID;
			 
			$query_current_postowners	= "SELECT wp_".$all_multisite->id."_terms.name FROM wp_".$all_multisite->id."_terms WHERE wp_".$all_multisite->id."_terms.term_id IN (SELECT wp_".$all_multisite->id."_term_taxonomy.term_id FROM wp_".$all_multisite->id."_term_taxonomy WHERE taxonomy = 'postowners' AND wp_".$all_multisite->id."_term_taxonomy.term_id IN (SELECT term_taxonomy_id FROM wp_".$all_multisite->id."_term_relationships WHERE object_id = ".$current_post_id."))";

			$current_postowners = $wpdb->get_results($query_current_postowners);
			
			//var_dump($current_postowners);
			 $postowner_pointer = 0;
			//var_dump(isset($current_postowners[0]->name));
			//var_dump($all_post_id);
			if (isset($current_postowners[0]->name)){
					
				foreach($current_postowners as $current_postowner){
				 
				 
					//var_dump($current_postowner->name);
					if ($current_postowner->name == $current_user->user_email){
						//var_dump($currnet_post->post_title);
						$all_post_id = $all_post_id + 1; 
						$postowner_pointer = 1;
						$my_post_count = $my_post_count + 1;
						$poststyle="    display: table-row;background:transparent;";
						array_push($admin_post,$all_post_id);
						//var_dump($all_post_id);
					}					
				}
				
				if ($postowner_pointer == 0) {
					if (is_super_admin(intval($current_user->ID)))  { 
						$all_post_id = $all_post_id + 1; 
						$postowner_pointer = 1; 
						$poststyle="display:none;";
						array_push($admin_post,$all_post_id);
					}
					else if ($userole[0] == 'administrator') { 
						$all_post_id = $all_post_id + 1; 
						$postowner_pointer = 1; 
						$poststyle="display:none;";
						array_push($admin_post,$all_post_id);
					}
				}
			}
			else {
				if (is_super_admin(intval($current_user->ID)))  {
					$all_post_id = $all_post_id + 1; 
					$postowner_pointer = 1; 
					$poststyle="display:none;";
					array_push($admin_post,$all_post_id);
					//var_dump($all_post_id);
				}
				else if ($userole[0] == 'administrator') { 
					$all_post_id = $all_post_id + 1;
					$postowner_pointer = 1; 
					$poststyle="display:none;";
					array_push($admin_post,$all_post_id);
					//var_dump($all_post_id);
				}
			}
			
	         
			 
			
			$query_current_post_reviewfrequency = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='reviewfrequency' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
			//var_dump($query_current_post_reviewfrequency);
			$current_post_reviewfrequencies = $wpdb->get_results($query_current_post_reviewfrequency);
			//var_dump($current_post_reviewfrequencies);
			if (empty($current_post_reviewfrequencies[0])) {$time_interval = 0;}
			foreach ($current_post_reviewfrequencies as $current_post_reviewfrequency){
				$query_current_reviewfrequency_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_reviewfrequency->term_id;
				$current_reviewfrequency_name = $wpdb->get_results($query_current_reviewfrequency_name);
							//var_dump($current_reviewfrequency_name);
				if (isset($current_reviewfrequency_name[0]->name)){
					if ($current_reviewfrequency_name[0]->name == "annually"){
						$time_interval = 31622400;
					}
					else if ($current_reviewfrequency_name[0]->name == "bi-annually"){
						$time_interval = 15811200;
					}
					else if ($current_reviewfrequency_name[0]->name == "monthly"){
						$time_interval = 2635200;
					}
					else if ($current_reviewfrequency_name[0]->name == "bi-monthly"){
						$time_interval = 1209600;
					}
					else if ($current_reviewfrequency_name[0]->name == "never"){
						$time_interval = 0;
					}
				}
				else {$time_interval = 0;}
							
			}

			if ($time_interval == 0){
				$rowcolor = "background-color:transparent;";
			}
			else {
				if ((time() - strtotime($currnet_post->post_modified)) < $time_interval/2) {
					$rowcolor = "background-color:green;";
				}
				else if ((time() - strtotime($currnet_post->post_modified)) >= $time_interval){
					$rowcolor = "background-color:red;";
				}
				else if ((time() - strtotime($currnet_post->post_modified)) > $time_interval/2){
					$rowcolor = "background-color:yellow;";
				}					
			}
			
			 
			
			 //var_dump($current_user->user_email);
			// var_dump($postowner_pointer);
			 
			if ($postowner_pointer == 0){continue;}
			 
			//var_dump($current_post_id);
			
			?>
			
			<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog loadall" id="<?php echo $all_post_id; ?>" style="<?php echo $poststyle;?>">
				
					<th class="check-column" scope="row" style="<?php echo $rowcolor;?>">
						
						<label class="screen-reader-text" for="cb-select-5551">
							<?php echo $currnet_post->post_title; ?>
						</label>
						
					</th>

					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $currnet_post->post_title; ?> (Edit)" class="row-title" href="<?php echo $currnet_post->guid; ?>" target="_blank">
								<?php echo $currnet_post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain.'/wp-admin/post.php?post='.$currnet_post->ID.'&action=edit'; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$all_multisite->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$currnet_post->ID.$all_multisite->blog_id ?>')" value="More">More</a>
							</span> 

						</div>
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $all_multisite->domain; ?>" id="<?php echo 'domain_'.$all_post_id; ?>"><?php echo $all_multisite->domain; ?></a>
				        <br />
						<?php echo $currnet_post->post_type; ?>
				        <br />
						<?php 
						if ($currnet_post->post_type=='post'){
							switch_to_blog($all_multisite->id);
							$post_cates = get_the_category($currnet_post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$all_multisite->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
							}
							restore_current_blog();
						}
						else {}
						?>
					</td>
					
					<td class="author column-author" data-colname="Author">
					
						<?php
						
						$author = "Unknown";
						$author_id = 0;
						switch_to_blog($all_multisite->id);
						$users = get_users( array( 'search' => $currnet_post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<div><a href="<?php echo 'http://'.$site->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
							if ($author_id == 0){
								//echo '<div><img id="avatar_o_'.$all_post_id.'" src="https://communicator.yorkvilleu.ca/wp-content/uploads/sites/16/2018/06/Unknown.png" width="50" height="50" /></div>';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<div><span id="avatar_o_'.$all_post_id.'">'.get_avatar($author_id).'</span></div>';
								//echo '<img id="header-avatar" src="'.esc_url(get_avatar($author_id)).'" />'; 
								restore_current_blog();
							}
							
							echo '<br /><div id="author_'.$all_post_id.'" style="word-wrap:normal;">'.$author.'</div>';
							?>
						</a>
						</div>
						<div><abbr title=""><?php echo $currnet_post->post_date; ?></abbr></div>
					</td>
					
					<td class="author column-author" data-colname="Author">
					
						
					
						<a href="<?php echo 'http://'.$all_multisite->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>" id="<?php echo 'author_'.$multipost_id; ?>">
							<?php
					   //var_dump($currnet_post);
					   //var_dump($all_multisite);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$currnet_post->ID." AND siteid=".$all_multisite->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   $author = $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($all_multisite->id);
							$users = get_users( array( 'search' => $currnet_post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								//echo '<div><img id="avatar_'.$all_post_id.'" src="https://communicator.yorkvilleu.ca/wp-content/uploads/sites/16/2018/06/Unknown.png" width="50" height="50" /></div>';
							}
							else { 
								switch_to_blog($all_multisite->id); 
								//echo '<div><span id="avatar_'.$all_post_id.'">'.get_avatar($author_id).'</span></div>';
								//echo '<img id="header-avatar" src="'.esc_url(get_avatar($author_id)).'" />'; 
								restore_current_blog();
							}
							
							echo '<div id="author2_'.$all_post_id.'" style="word-wrap:normal;">'.$author.'</div>';
							
					   ?>
					   
						</a>
						
						<abbr title="" id="<?php echo 'post_modified_'.$all_post_id; ?>"><?php echo $currnet_post->post_modified; ?></abbr>
					</td>
		
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_brands = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='brand' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_brands);
						$current_post_brands = $wpdb->get_results($query_current_post_brands);
						//var_dump($current_post_brands);
						if (empty($current_post_brands[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_brands as $current_post_brand){
							$query_current_brand_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_brand->term_id;
							$current_brand_name = $wpdb->get_results($query_current_brand_name);
							//var_dump($current_brand_name);
							if (isset($current_brand_name[0]->name)){echo $current_brand_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}	
						?>
						
					<br />/ <br />
						
						<?php 
						$query_current_post_jurisdictions = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='jurisdiction' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_jurisdictions);
						$current_post_jurisdictions = $wpdb->get_results($query_current_post_jurisdictions);
						//var_dump($current_post_jurisdictions);
						if (empty($current_post_jurisdictions[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_jurisdictions as $current_post_jurisdiction){
							$query_current_jurisdiction_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_jurisdiction->term_id;
							$current_jurisdiction_name = $wpdb->get_results($query_current_jurisdiction_name);
							//var_dump($current_jurisdiction_name);
							if (isset($current_jurisdiction_name[0]->name)){echo $current_jurisdiction_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}	
						?>
						
					</td>
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_deliverys = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='delivery' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_deliverys);
						$current_post_deliverys = $wpdb->get_results($query_current_post_deliverys);
						//var_dump($current_post_deliverys);
						if (empty($current_post_deliverys[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_deliverys as $current_post_delivery){
							$query_current_delivery_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_delivery->term_id;
							$current_delivery_name = $wpdb->get_results($query_current_delivery_name);
							//var_dump($current_delivery_name);
							if (isset($current_delivery_name[0]->name)){echo $current_delivery_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}	
						?>
						
					</td>
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_baseprograms = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='baseprogram' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_baseprograms);
						$current_post_baseprograms = $wpdb->get_results($query_current_post_baseprograms);
						//var_dump($current_post_baseprograms);
						if (empty($current_post_baseprograms[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_baseprograms as $current_post_baseprogram){
							$query_current_baseprogram_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_baseprogram->term_id;
							$current_baseprogram_name = $wpdb->get_results($query_current_baseprogram_name);
							//var_dump($current_baseprogram_name);
							if (isset($current_baseprogram_name[0]->name)){echo $current_baseprogram_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}	
						?>
						
					</td>
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_reviewfrequency = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='reviewfrequency' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_reviewfrequency);
						$current_post_reviewfrequencies = $wpdb->get_results($query_current_post_reviewfrequency);
						//var_dump($current_post_reviewfrequencies);
						if (empty($current_post_reviewfrequencies[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_reviewfrequencies as $current_post_reviewfrequency){
							$query_current_reviewfrequency_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_reviewfrequency->term_id;
							$current_reviewfrequency_name = $wpdb->get_results($query_current_reviewfrequency_name);
							//var_dump($current_reviewfrequency_name);
							if (isset($current_reviewfrequency_name[0]->name)){echo $current_reviewfrequency_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}	
						?>
						
					</td>
					<td class="author column-author" data-colname="Author">
						
						<?php 
						$query_current_post_postowners = "SELECT term_id FROM wp_".$all_multisite->id."_term_taxonomy JOIN wp_".$all_multisite->id."_term_relationships WHERE wp_".$all_multisite->id."_term_taxonomy.term_taxonomy_id = wp_".$all_multisite->id."_term_relationships.term_taxonomy_id AND taxonomy='postowners' AND wp_".$all_multisite->id."_term_relationships.object_id = ".$current_post_id;
						//var_dump($query_current_post_postowners);
						$current_post_postowners = $wpdb->get_results($query_current_post_postowners);
						//var_dump($current_post_postowners);
						if (empty($current_post_postowners[0])) {echo '<font style="color:#e1e4ea;">N/A</font>';}
						foreach ($current_post_postowners as $current_post_postowner){
							$query_current_postowner_name = "SELECT name FROM wp_".$all_multisite->id."_terms WHERE term_id = ".$current_post_postowner->term_id;
							$current_postowner_name = $wpdb->get_results($query_current_postowner_name);
							//var_dump($current_postowner_name);
							if (isset($current_postowner_name[0]->name)){echo $current_postowner_name[0]->name.'<br />'; }
							else {echo '<font style="color:#e1e4ea;">N/A</font>';}
							
						}
						
						?>
						
					</td>
					<td class="author column-author" data-colname="Author" id="<?php echo 'edited_'.$multipost_id; ?>">
					   <?php
					   switch_to_blog($all_multisite->id);
					   $q = wp_get_post_revisions( $currnet_post->ID );
					   echo count( $q );
					   restore_current_blog();
					   //var_dump($post);
					   //var_dump($site);
					      //$query_current_post_access	= "SELECT accessnumber FROM wp_postinfo WHERE postid=".$post->ID." AND siteid=".$site->blog_id;
						  //$current_post_access = $wpdb->get_results($query_current_post_access);
						  //if (isset($current_post_access[0]->accessnumber)) {
						//	   echo $current_post_access[0]->accessnumber;
						  //}
						  //else {
							//  echo 0;
						  //}
					   ?> /
					    <?php 
					   echo getPostViews($currnet_post->ID, $all_multisite->blog_id); ?> /
					   <?php 
					   echo wp_count_comments($currnet_post->ID)->total_comments;
					   ?>
					   
					</td>
					
				</tr>
			<?php
			restore_current_blog();

		}

	}

	echo "</tbody></table>";
    $my_button_number = ceil($my_post_count/$number_per_page);
	
	
	?>
	
	<script>
			var shortcut = document.getElementById("page_pagination");
			var str1 = "";
			for (ii = 1; ii<=<?php echo $my_button_number; ?>;ii++){
				str1 = str1.concat('<button style="background:transparent;" id="page_button_').concat(ii.toString()).concat('" type="button" onclick="changepag(').concat(ii.toString()).concat(')">').concat(ii.toString()).concat('</button>&nbsp;');
			}
			shortcut.innerHTML = str1;
			document.getElementById("page_button_1").style.backgroundColor = "yellow";	
			
			
			var all_posts = document.getElementsByClassName("loadall");
			var arrayLength = all_posts.length;
			var page_number = 1;
			var post_per_page = 10;
			var my_post_count = 0;
		
			for (var i = 0; i < arrayLength; i++) {
			
				if (all_posts[i].style.backgroundColor == "transparent"){
					my_post_count =  my_post_count + 1;
					
					if ((my_post_count >= (page_number-1)*post_per_page) && (my_post_count < page_number *post_per_page)){
						all_posts[i].style.display = "table-row";
					}	
					else {
						all_posts[i].style.display = "none";
					}
				}
			
				
				//alert((page_number-1)*post_per_page);
				//alert(page_number *post_per_page);
				
			}

			//alert(my_post_count);			
	</script>
	
	<?php
	

}


// add or delete jurisdiction,brand,delivery mode, base program.review frequencies at Post/Page edit

add_action( 'init', 'add_custom_taxonomies', 0 );

function add_custom_taxonomies() {

	$sites = get_sites();

	foreach($sites as $site){
		
		switch_to_blog($site->blog_id);
		
	    // Add new "Staff" taxonomy 

		register_taxonomy('staff', array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Staffs', 'taxonomy general name' ),

			'singular_name' => _x( 'Staff', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Staffs' ),
		
			'all_items' => __( 'All Staffs' ),

			'parent_item' => __( 'Parent Staff' ),

			'parent_item_colon' => __( 'Parent Staff:' ),

			'edit_item' => __( 'Edit Staff' ),

			'update_item' => __( 'Update Staff' ),

			'add_new_item' => __( 'Add New Staff' ),

			'new_item_name' => __( 'New Staff' ),

			'menu_name' => __( 'Staffs' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'brands', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),


		));
		
		// Add new "Brand" taxonomy 

		register_taxonomy('brand', array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Brands', 'taxonomy general name' ),

			'singular_name' => _x( 'Brand', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Brands' ),
		
			'all_items' => __( 'All Brands' ),

			'parent_item' => __( 'Parent Brand' ),

			'parent_item_colon' => __( 'Parent Brand:' ),

			'edit_item' => __( 'Edit Brand' ),

			'update_item' => __( 'Update Brand' ),

			'add_new_item' => __( 'Add New Brand' ),

			'new_item_name' => __( 'New Brand' ),

			'menu_name' => __( 'Brands' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'brands', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),


		));
		
	
		
		// Add new "Jurisdiction" taxonomy to Pages

		register_taxonomy('jurisdiction', array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Jurisdictions', 'taxonomy general name' ),

			'singular_name' => _x( 'Jurisdiction', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Jurisdictions' ),
		
			'all_items' => __( 'All Jurisdictions' ),

			'parent_item' => __( 'Parent Jurisdiction' ),

			'parent_item_colon' => __( 'Parent Jurisdiction:' ),

			'edit_item' => __( 'Edit Jurisdiction' ),

			'update_item' => __( 'Update Jurisdiction' ),

			'add_new_item' => __( 'Add New Jurisdiction' ),

			'new_item_name' => __( 'New Jurisdiction Name' ),

			'menu_name' => __( 'Jurisdictions' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'jurisdictions', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),


		));
		
		
		// Add new "Delivery Mode" taxonomy

		register_taxonomy('delivery', array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Delivery Modes', 'taxonomy general name' ),

			'singular_name' => _x( 'Delivery Mode', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Delivery Modes' ),
		
			'all_items' => __( 'All Delivery Modes' ),

			'parent_item' => __( 'Parent Delivery Mode' ),

			'parent_item_colon' => __( 'Parent Delivery Mode:' ),

			'edit_item' => __( 'Edit Delivery Mode' ),

			'update_item' => __( 'Update Delivery Mode' ),

			'add_new_item' => __( 'Add New Delivery Mode' ),

			'new_item_name' => __( 'New Delivery Mode Name' ),

			'menu_name' => __( 'Delivery Modes' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'deliverymodes', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),

		));
		
		
		// Add new "Base Program" taxonomy 

		register_taxonomy('baseprogram',array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Base Programs', 'taxonomy general name' ),

			'singular_name' => _x( 'Base Program', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Base Programs' ),
		
			'all_items' => __( 'All Base Programs' ),

			'parent_item' => __( 'Parent Base Program' ),

			'parent_item_colon' => __( 'Parent Base Program:' ),

			'edit_item' => __( 'Edit Base Program' ),

			'update_item' => __( 'Update Base Program' ),

			'add_new_item' => __( 'Add New Base Program' ),

			'new_item_name' => __( 'New Base Program' ),

			'menu_name' => __( 'Base Programs' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'owners', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),

		));
		
		
		// Add new "Review Frequency" taxonomy 
		
		register_taxonomy('reviewfrequency',array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => true,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Review Frequencies (Please ONLY check one)', 'taxonomy general name' ),

			'singular_name' => _x( 'Review Frequency', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Review Frequencies' ),
		
			'all_items' => __( 'All Review Frequencies' ),

			'parent_item' => __( 'Parent Review Frequency' ),

			'parent_item_colon' => __( 'Parent Review Frequency:' ),

			'edit_item' => __( 'Edit Review Frequency' ),

			'update_item' => __( 'Update Review Frequency' ),

			'add_new_item' => __( 'Add New Review Frequency' ),

			'new_item_name' => __( 'New Review Frequency' ),

			'menu_name' => __( 'Review Frequencies' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'reviewfrequencies', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),

		));		
		
		
		// Add new "Review Frequency" taxonomy 
		
		register_taxonomy('postowners',array('post','page'), array(

			// Hierarchical taxonomy (like categories)

			'hierarchical' => false,

			// This array of options controls the labels displayed in the WordPress Admin UI

			'labels' => array(

			'name' => _x( 'Owners (Please at least select ONE)', 'taxonomy general name' ),

			'singular_name' => _x( 'Review Owner', 'taxonomy singular name' ),

			'search_items' =>  __( 'Search Owners' ),
		
			'all_items' => __( 'All Owners' ),

			'parent_item' => __( 'Parent Owner' ),

			'parent_item_colon' => __( 'Parent Owner:' ),

			'edit_item' => __( 'Edit Owner' ),

			'update_item' => __( 'Update Owner' ),

			'add_new_item' => __( 'Add New Owner' ),

			'new_item_name' => __( 'New Owner' ),

			'menu_name' => __( 'Owners' ),

			),

			// Control the slugs used for this taxonomy

			'rewrite' => array(

				'slug' => 'owners', // This controls the base slug that will display before each term

				'with_front' => false, // Don't display the category base before "/locations/"

				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"

			),

		));		
		
		restore_current_blog();
		
	}
  
}


add_filter( 'cron_schedules', 'my_add_intervals' ); 
function my_add_intervals( $schedules ) {
	// Add a weekly interval.
	$schedules['twoweeks'] = array(
		'interval' => 1209600,
		'display'  => __( 'Once Weekly' ),
	);
	// Add a monthly interval.
	$schedules['monthly'] = array(
		'interval' => 2635200,
		'display'  => __( 'Once a month' ),
	);
	// Add a bi-annully interval.
	$schedules['sixmonths'] = array(
		'interval' => 15811200,
		'display'  => __( 'Once six months' ),
	);
	// Add an annually interval.
	$schedules['yearly'] = array(
		'interval' => 31622400,
		'display'  => __( 'Once a year' ),
	);
	return $schedules;
}


// add delivery mode after save post

 add_action('save_post', 'update_delivery_time',10,3);

function update_delivery_time(){
	$delivery_post_id = get_queried_object_id();
	$current_site_id =  get_current_blog_id();
	switch_to_blog($current_site_id);
	
	$current_delivery = get_the_terms($delivery_post_id, 'delivery');
	
	if (sizeof($current_delivery) > 1){
		die("Delivery Mode cannot be multiselected.");
	}
	else {
		if ($current_delivery[0]->name == 'bi-monthly'){
			wp_clear_scheduled_hook( 'my_new_delivery_{$current_site_id}_{$delivery_post_id}');
			add_action( 'my_new_delivery','email_post_owners',array($delivery_post_id,$current_site_id) );
			wp_schedule_single_event('twoweeks', 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			wp_schedule_single_event('monthly', 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			
		}
		elseif ($current_delivery[0]->name == 'monthly'){
			wp_clear_scheduled_hook( 'my_new_delivery_{$current_site_id}_{$delivery_post_id}');
			add_action( 'my_new_delivery','email_post_owners',array($delivery_post_id,$current_site_id) );
			wp_schedule_single_event('monthly', 'my_new_delivery_{$current_site_id}_{$delivery_post_id}');
			
		}
		elseif ($current_delivery[0]->name == 'bi-annually'){
			wp_clear_scheduled_hook( 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			add_action( 'my_new_delivery','email_post_owners',array($delivery_post_id,$current_site_id) );
			wp_schedule_single_event('sixmonths', 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			
		}
		elseif ($current_delivery[0]->name == 'annually'){
			wp_clear_scheduled_hook( 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			add_action( 'my_new_delivery','email_post_owners',array($delivery_post_id,$current_site_id) );
			wp_schedule_single_event( 'yearly', 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
			
		}
		elseif ($current_delivery[0]->name == 'never'){
			wp_clear_scheduled_hook( 'my_new_delivery_{$current_site_id}_{$delivery_post_id}' );
		}
	}
	
	restore_current_blog();
	
}

function email_post_owners($post_id, $site_id){
	// send owners email fuction here
	switch_to_blog($site_id);
	$to = get_the_terms($post_id, 'postowners');
	wp_mail($to, 'WordPress Post Update Reminder','Please update the following post:'.get_the_title( $id ).'('.get_permalink( $id ).')');
}


// check jurisdiction before post/page load

add_action('template_redirect', 'check_jurisdiction_and_others');



function check_jurisdiction_and_others(){


	global $wpdb;
	
	
	// get current user id
	
	$current_page_user_id = get_current_user_id();


	// get user meta meta_value where meta_key='ysis_data' and userid = $current_page_user_id

	$current_user_ysis = get_user_meta($current_page_user_id, 'ysis_data');
	
	//var_dump($current_user_ysis);
	if (strpos($_SERVER['QUERY_STRING'], 's=') !== false) {
	}
	else{
		if(empty($current_user_ysis)){
				
				// get page/post id
						
				$current_url_post_id = get_the_ID();
						
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
				

				$current_staff_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'staff')";
				$current_staff =  $wpdb->get_results($current_staff_query);
				
				//var_dump($current_jurisdiction);
				// if  staff terms (staff, studnet, faculty) are not set
				// {}
				//else {
				//	wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
				//	exit;
				//}
				
				if (!isset($current_jurisdiction[0]->name)){
				}
				else {
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
				
				if (!isset($current_brand[0]->name)){
				}
				else {
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
				
				if (!isset($current_baseprogram[0]->name)){
				}
				else {
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
				
				if (!isset($current_campus[0]->name)){
				}
				else {
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
				
				if (!isset($current_staff[0]->name)){
				}
				else {
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
		}
		else{


				// JSON decode ysis_data
		
				$current_user_ysis = JSON_decode($current_user_ysis[0]);
				//var_dump($current_user_ysis);
				if (isset($current_user_ysis->YSIS_COURSE)){
			
					if (isset($current_user_ysis->YSIS_COURSE[0])){
						
						// if only staff is selected
						// loop all the ysis courses
						// if roletitle = staff then {}
						// else wp_redirect;exit;
						
					    // if staff+faculty is slelected
						// loop all the ysis courses
						// if roletitle = staff or faculty then {}
					    // else wp_redirect;exit;
						
						// if staff+student is slelected
						// loop all the ysis courses
						// if roletitle = staff or student then {}
					    // else wp_redirect;exit;
						
						// if staff+faculty+student is selected
						// if not log in {wp_redirect;exit};
						
						// if nothing is selected
						// {}
			
						// get YSIS_COURSE field

						$current_user_ysis_course = $current_user_ysis->YSIS_COURSE;
						//var_dump($current_user_ysis_course);
				
						// get site id

						$current_site_id =  get_current_blog_id();
						//var_dump($current_site_id);
			
						// get page/post id
						$current_url_post_id = get_the_ID();
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
						
						$current_staff_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'staff')";
						$current_staff =  $wpdb->get_results($current_staff_query);
						//var_dump($current_jurisdiction);
						//var_dump($current_brand);
						//var_dump($current_baseprogram);
						//var_dump($current_campus);
						
						//var_dump(isset($current_jurisdiction->errors));
						restore_current_blog();
						
						$staff_pointer = 0;
						if (!isset($current_staff[0]->name)){$staff_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{

							$staff_pointer = 0;
							//var_dump($current_staff);

							foreach ($current_staff as $current_single_staff){
								
								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
									//var_dump($current_user_ysis_single_course);
						
									// get user jurisdiction

									if ($current_single_staff->name == $current_user_ysis_single_course->RoleTitle) {
	
										$staff_pointer = 1;
							
										break 2; 

									}
								}
							}
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu 404 page
					
							//var_dump($jurisdiction_pointer);

							if ($staff_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page
								

							}
						}
						
						
						
	
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
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu 404 page
					
							//var_dump($jurisdiction_pointer);

							if ($jurisdiction_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

								

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
		
					
							// if they are not the same brand, redirect to yorkvilleu 404 page
					
							//var_dump($brand_pointer);

							if ($brand_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

								

							}				
						}
						
						if (!isset($current_baseprogram[0]->name)){ $baseprogram_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{
							 
							$baseprogram_pointer = 0;		
							//var_dump($current_baseprogram);
							//var_dump($current_user_ysis_course);

							foreach ($current_baseprogram as $current_single_baseprogram){
								    //var_dump($current_user_ysis);
						
									// get user jurisdiction
									//var_dump($current_single_baseprogram->name);
									//var_dump($current_user_ysis->ProgramBase);
									foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
										if ($current_single_baseprogram->name == $current_user_ysis_single_course->ProgramBase) {
	
											$baseprogram_pointer = 1;
							
											break ; 

										}
									}
							}
						
					
							// if they are not the same base program, redirect to yorkvilleu 404 page
						
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
									foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									// get user campus
									//var_dump($current_single_campus->name);
									//var_dump($current_user_ysis->Campus);
										if ($current_single_campus->name == $current_user_ysis_single_course->Campus) {
	
											$delivery_pointer = 1;
								
											break ; 
										}
									}
							}

					
							// if they are not the same base program, redirect to yorkvilleu 404 page
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

							
	
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
						
						$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
						$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						$current_campus =  $wpdb->get_results($current_campus_query);
						
						$current_staff_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'staff')";
						$current_staff =  $wpdb->get_results($current_staff_query);
						
						
						if (!isset($current_staff[0]->name)){$staff_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{

							$staff_pointer = 0;
							//var_dump($current_staff);

							foreach ($current_staff as $current_single_staff){
								
								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
									//var_dump($current_user_ysis_single_course);
						
									// get user jurisdiction

									if ($current_single_baseprogram->name == $current_user_ysis->UserType) {
	
										$staff_pointer = 1;
							
										break ; 

									}
								}
							}
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu 404 page
					
							//var_dump($jurisdiction_pointer);

							if ($staff_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

								

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
						
					
							// if they are not the same base program, redirect to yorkvilleu 404 page
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

							

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

					
							// if they are not the same base program, redirect to yorkvilleu 404 page
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

							
	
							}		
						}
						
					}
				}
				else {
					$current_jurisdiction_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
					$current_jurisdiction =  $wpdb->get_results($current_jurisdiction_query);
						
					$current_brand_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
					$current_brand =  $wpdb->get_results($current_brand_query);
					
					$current_baseprogram_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
					$current_baseprogram =  $wpdb->get_results($current_baseprogram_query);
						
						
					$current_campus_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
					$current_campus =  $wpdb->get_results($current_campus_query);
					
					$current_staff_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'staff')";
					$current_staff =  $wpdb->get_results($current_staff_query);
					
					
					if (!isset($current_staff[0]->name)){$staff_pointer = 1;}
						// || (isset($current_brand->errors)) || (isset($current_baseprogram->errors)) || (isset($current_campus->errors))
						else{

							$staff_pointer = 0;
							//var_dump($current_staff);

							foreach ($current_staff as $current_single_staff){
								
								foreach ( $current_user_ysis_course as  $current_user_ysis_single_course){
									
									//var_dump($current_user_ysis_single_course);
						
									// get user jurisdiction

									if ($current_single_baseprogram->name == $current_user_ysis->UserType) {
	
										$staff_pointer = 1;
							
										break ; 

									}
								}
							}
					
				
							// if they are not the same jurisdiction, redirect to yorkvilleu.ca
					
							//var_dump($jurisdiction_pointer);

							if ($staff_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

								

							}
						}
					
						
						
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
						
					
							// if they are not the same base program, redirect to yorkvilleu 404 page
						
							//var_dump($baseprogram_pointer);

							if ($baseprogram_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

							

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

					
							// if they are not the same base program, redirect to yorkvilleu 404 page
					
							//var_dump($baseprogram_pointer);

							if ($delivery_pointer == 0){

								// change the permisison of this page to none and redirect to yorkvilleu 404 page

							
	
							}		
						}
						
				}
				
				$current_url_post_id = get_the_ID();
				//var_dump($jurisdiction_pointer);
				//var_dump($brand_pointer);
				//var_dump($baseprogram_pointer);
				//var_dump($delivery_pointer);
				//var_dump(isset($current_url_post_id));
				

				if (($jurisdiction_pointer==1) && ($brand_pointer==1) && ($baseprogram_pointer==1) && ($delivery_pointer==1) && ($staff_pointer == 1)){}
				else {
					//var_dump($jurisdiction_pointer);
					//var_dump($brand_pointer);
					//var_dump($baseprogram_pointer);
					//var_dump($delivery_pointer);
					//var_dump($staff_pointer);
					wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
					exit;
				}
			}
			if (!isset($current_url_post_id )){
				wp_redirect("https://askyu.yorkvilleu.ca/yorkville-404/");
				exit;
			}
	}

			
			
}


/* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );


function smashing_save_post_class_meta( $post_id, $post ) {

	// get site id
	$current_site_id =  get_current_blog_id();
	switch_to_blog($current_site_id);
	
	
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['smashing_post_class_nonce'] ) || !wp_verify_nonce( $_POST['smashing_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['smashing-post-class'] ) ? $_POST['smashing-post-class'] : '' );

	/* Get the meta key. */
	$meta_key = 'smashing_post_class';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	
	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	
	restore_current_blog();
}

function after_content($thecontent) {
    if ( (in_the_loop()) && ( is_single() || is_page() ) ) {
		// get page/post id
		$current_post_id = get_queried_object_id();
		$current_blog_id = get_current_blog_id();
		switch_to_blog($current_blog_id);
		
		$write = '<font size="3"><b>Last Updated:</b>&nbsp;'.get_the_modified_date();
		global $current_user;
		switch_to_blog(get_current_blog_id());
		$site = home_url();
	
		$current_url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		//var_dump($current_url);
		if ($curren_url == 'http://myprogram.yorkvilleu.ca/api/?key=YU2018ShhhhecretKEY4423'){
			return $thecontent;
		}
		if ($curren_url == 'https://myprogram.yorkvilleu.ca/api/?key=YU2018ShhhhecretKEY4423'){
			return $thecontent;
		}
		// Get the new draft post ID
		if ($site == 'http://communicator.yorkvilleu.test') {
				
				if ( is_user_logged_in() ){
					//var_dump($current_user);
					if ( in_array( 'message_sender', $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'editor',  $current_user->roles ) ) {
							return $thecontent.$write;
					}
					else if ( in_array( 'administrator',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_participant',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_keymaster',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
				}
			return 'Sorry !! you do not have permission to access this page.';
				//return  in_array( 'message_sender', $current_user->roles ) ;
		}
		if ($site == 'http://communicator.yorkvilleu.ca') {
			if ( is_user_logged_in()){
					if ( in_array( 'message_sender',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'editor',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'administrator',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'author',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_participant',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_keymaster',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
			}
			//return  in_array( 'message_sender', $current_user->roles ) ;
			return 'Sorry !! you do not have permission to access this page.';
		}
		
		if ($site == 'https://communicator.yorkvilleu.ca') {
			if ( is_user_logged_in()){
					if ( in_array( 'message_sender',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'editor',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'administrator',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'author',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_participant',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
					else if ( in_array( 'bbp_keymaster',  $current_user->roles ) ) {
						return $thecontent.$write;
					}
			}
			//return  in_array( 'message_sender', $current_user->roles ) ;
			return 'Sorry !! you do not have permission to access this page.';
		}
		//$owner_terms = get_the_terms($current_post_id, 'postowners');
		//var_dump($owner_terms);
		
        //if (isset($owner_terms)){
			
		//	if (empty($owner_terms)) {}
		//	else if ($owner_terms == '') {}
		//	else{
		//		foreach ($owner_terms as $owner_term){
		//			$write = $write.$owner_term->name.', ';
		//		}
		//		$write = substr($write,0,strlen($write)-2).'</font><br /><br />';
		//		$thecontent = $write.$thecontent;
		//	}
		//}
		
		return $thecontent.$write;
    }
	

    
}

add_filter( 'the_content', 'after_content' );

function add_item($admin_bar)  {
$args = array(
    'id'        => 'My Content Manager', // Must be a unique name
    'title'     => 'My Content Manager', // Label for this item
    'href'      =>__ (get_site_url().'/wp-admin/admin.php?page=multi_posttags'),
    'meta'  => array(
        'target'=> '_blank', // Opens the link with a new tab
        'title' => __('View Mine'), // Text will be shown on hovering
    ),
);
$args2 = array(
    'id'        => 'Office 365', // Must be a unique name
    'title'     => 'Office 365', // Label for this item
    'href'      =>__ ('http://portal.office.com'),
    'meta'  => array(
        'target'=> '_blank', // Opens the link with a new tab
        'title' => __('Office 365'), // Text will be shown on hovering
    ),
);
$args3 = array(
    'id'        => 'Online Meeting Tools', // Must be a unique name
    'title'     => 'Online Meeting Tools', // Label for this item
    'href'      =>__ ('https://technology.yorkvilleu.ca/onlinecolllab-zoom/'),
    'meta'  => array(
        'target'=> '_blank', // Opens the link with a new tab
        'title' => __('Zoom'), // Text will be shown on hovering
    ),
);
$admin_bar->add_menu( $args);
$admin_bar->add_menu( $args2);
$admin_bar->add_menu( $args3);
}
add_action('admin_bar_menu', 'add_item', 90); // 10 = Position on the admin bar

function staff_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
	$current_site_id = get_current_blog_id();
	switch_to_blog($current_site_id);
    if (('post.php' == $hook) || ('post-new.php' == $hook)){
		global $wpdb;
		$query_current_review = "SELECT term_id FROM wp_".$current_site_id."_term_taxonomy WHERE taxonomy = 'reviewfrequency'";
			//var_dump($query_current_post_reviewfrequency);
		$current_review = $wpdb->get_results($query_current_review);
		// add css code to change check box to radio box	
		
	    echo '<style>.spinner{display:none !important;} #publishing-action{margin-top:30px !important;text-align:left !important;float:none !important;} #publishing-action::after{content:"Please note that you need to add one review frequency and one post owner in order to update or publish this post"; color: red;font-weight: 700;}</style>';
				
		foreach ($current_review as $per_current_review){
			echo "<style>#in-reviewfrequency-".$per_current_review->term_id."{border-radius: 15px;}</style>";  
		}
		// set a javascript function run every 1000
		echo "<script>";
		echo "var newinter = setInterval(function(){var ss=0;";
		foreach ($current_review as $per_current_review){
			echo 'if (document.getElementById("in-reviewfrequency-'.$per_current_review->term_id.'").checked){ss=ss+1;}';
		}
		echo 'if (ss>1){ ';
		foreach ($current_review as $per_current_review){
			echo 'document.getElementById("in-reviewfrequency-'.$per_current_review->term_id.'").checked=false;';	
		}
		echo 'document.getElementById("in-reviewfrequency-'.$current_review[0]->term_id.'").checked=true;';
		echo 'document.getElementById("publish").style.display = "block";';
		echo '}';
		
		echo 'if (ss==0){';
		echo 'document.getElementById("publish").style.display = "none";';
		
		echo '}';
		
		
		echo 'if (ss==1){';
		echo 'var ownerslst = document.getElementsByClassName("ntdelbutton");';
		//echo 'alert(ownerslst.length);';
		echo 'if (ownerslst.length>0) {document.getElementById("publish").style.display = "block";}';
		echo 'if (ownerslst.length==0) {document.getElementById("publish").style.display = "none";}';
		echo '}';
		
		// if tagchecklist class has child element

		// echo 'document.getElementById("publish").style.display = "block";';
		// if tagchecklist class doesnt have child element
		// echo 'document.getElementById("publish").style.display = "none";';
		
		
		echo "},500);</script>";
		//get how many is checked
		// if more than two is checked, uncheck all	
		
		$site = home_url();
		if ($site == 'http://communicator.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://communicator.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://success.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-success.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://success.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-success.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://library.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-library.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://library.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-library.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://myprogram.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-myprogram.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://myprogram.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-myprogram.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://alumni.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-alumni.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://alumni.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-alumni.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://askyu.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-askyu.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://askyu.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-askyu.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://my.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-my.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://my.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-my.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'http://cetl.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-cetl.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://cetl.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-cetl.js');
				//var_dump($current_site_id);
		}
        else if ($site == 'http://technology.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-technology.js');
				//var_dump($current_site_id);
		}
		else if ($site == 'https://technology.yorkvilleu.ca') {
				wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/staffcheckbox-technology.js');
				//var_dump($current_site_id);
		}
    }
	restore_current_blog();
	return;
    
}

add_action('admin_enqueue_scripts', 'staff_enqueue');

