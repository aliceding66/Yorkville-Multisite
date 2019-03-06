<?php
/*
Plugin Name: All Content Manager
Plugin URI: https://www.YorkvilleU.ca/
Description: Find and return all index posts
Version: 1.0
Author: www.YorkvilleU.ca
Author URI: https://www.YorkvilleU.ca/
License: MIT
*/

// ADMIN: Network Plugins Menu Link
// =========================

add_action('admin_menu', 'admin_menu_add_networkposts_page');
function admin_menu_add_networkposts_page() {

	//create new top-level menu
	add_menu_page('All Content', 'All Content', 'editor', 'network_posts', 'networkposts_plugin_settings_page' , plugins_url('/images/logo.png', __FILE__), 4 );
    add_submenu_page('network_posts', 'More Info', 'More Info','administrator', 'morepostinfo', 'moreinfo_settings_page');
	add_submenu_page('network_posts', 'Statistics', 'Statistics','administrator','statisticsinfo','statisticsinfo_page');
	add_submenu_page('network_posts', 'User Management','User Management', 'administrator', 'usermanage','usermanage_page');
}

function usermanage_page(){
	?>
	<?php 
	
	global $wpdb;
	
	$file = fopen(wp_upload_dir()->url.'network-posts.csv',"w");
	$single_post = array('Post Title', 'Post Link','Post/Page','Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hits');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
.btn {
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 12px;
    cursor: pointer;
    font-size: 15px;
}

.posttrackinfo {
	display:none;
}

/* Darker background on mouse-over */
.btn:hover {
    background-color: RoyalBlue;
}
</style>
	<h2 style="color:red;">
		<span id="network_search_results_shortcut"></span>
		<a href="<?php echo wp_upload_dir()->url.'network-posts-users.csv'; ?>"><button class="btn"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>
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

function statisticsinfo_page(){
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


function moreinfo_settings_page(){
	?>
	<?php 
	
	global $wpdb;
	
	$file = fopen(wp_upload_dir()->url.'network-posts.csv',"w");
	$single_post = array('Post Title', 'Post Link','Post/Page','Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hits');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
.btn {
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 12px;
    cursor: pointer;
    font-size: 15px;
}

.posttrackinfo {
	display:none;
}

/* Darker background on mouse-over */
.btn:hover {
    background-color: RoyalBlue;
}
</style>

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
		<a href="<?php echo wp_upload_dir()->url.'network-posts-more.csv'; ?>"><button class="btn"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>

	
	
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

// TinyMCE: Buttons
// =========================
function enqueue_plugin_scripts($plugin_array){    
	//enqueue TinyMCE plugin script with its ID.
    $plugin_array["networkpost_button_plugin"] =  plugin_dir_url(__FILE__) . "/assets/index.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");
function register_buttons_editor($buttons){
    //register buttons with their id.
	
    array_push($buttons, "networkpost");
    return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");


// ADMIN: Network Plugins
// =========================
function networkposts_plugin_settings_page() {

	global $wpdb;
	
	$file = fopen(wp_upload_dir()->url.'network-posts.csv',"w");
	$single_post = array('Post Title', 'Post Link','Post/Page','Post Categories', 'Domain', 'Original Author','Original Post date', 'last edited Author', 'Last Modified Date','Number of Times Accessed', 'Total Hit/Views', 'Comments');
				//var_dump($single_post);
	fputcsv($file,$single_post);
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
.btn {
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 12px;
    cursor: pointer;
    font-size: 15px;
}

.posttrackinfo {
	display:none;
}
.column-author img, .column-comment .comment-author img, .column-username img {
	width:50px !important;
	height:50px !important;
}

/* Darker background on mouse-over */
.btn:hover {
    background-color: RoyalBlue;
}
</style>

	<form action="#" method="post">
		
		<input type="hidden" name="page" value="network_posts" />
	
		Viewing Site:
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
		
		<input type="text" name="searchterms" placeholder="Search..." value="<?php echo $_GET['terms']; ?>" />
		
		<input type="submit" name="submit" value="Search" />
		
	</form>
	
	<?php
	if (isset($_POST['submit'])){
		$selected_val = $_POST['blog_id'];
		//var_dump($selected_val);
		$selected_term = $_POST['searchterms'];
		
	}
	else{
	}
	?>

					
	<h2 style="color:red;">
		<span id="network_search_results_shortcut"></span>
		<a href="<?php echo wp_upload_dir()->url.'network-posts.csv'; ?>"><button class="btn"><i class="fa fa-download"></i>&nbsp;Save as CSV</button></a>

	</h2>
	<?php 
	$allsites = get_sites();
	
	$sum_posts= 0;
	
	$posts_per_page =10;

	foreach($allsites as $allsite){
		switch_to_blog($allsite->id);
		$args = array(
			    
				'posts_per_page' => 10000 ,
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
		
			
		$posts = get_posts( $args );
		
		$sum_posts = $sum_posts + count($posts);
	}
	    restore_current_blog();
		//var_dump($sum_posts);
		echo 'Page &nbsp;<span id="pagenumber">1</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo "Page Pagination: &nbsp;";
		
		for ($ii = 1; $ii<=ceil($sum_posts/$posts_per_page);$ii++){
			echo '<button class="page_button" type="button" onclick="changepag('.$ii.')">'.$ii.'</button>&nbsp;';
		}
		
		echo "<br /><br />";
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
				<th scope="col" id="posts_website" class="manage-column column-author">
					Website
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Post(+categories) / Page
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Original Author
				</th>
				<th scope="col" id="date" class="manage-column column-date sortable asc">
					<!--<a href="http://communicator.yorkvilleu.test/wp-admin/admin.php?page=network_posts&amp;orderby=date&amp;order=desc">-->
						<span>
							Original Post Date
						</span>
						<span class="sorting-indicator">
						</span>
					<!--</a>-->
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
				<th scope="col" id="accesstime" class="manage-column column-author">
					# of Times Edited
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Total Hits/Views
				</th>
				<th scope="col" id="totalhit" class="manage-column column-author">
					Comments Counts
				</th>
			</tr>
		</thead>
		<tbody id="the-list">
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

				$single_post = array(strval($line->post_title), strval($line->guid), strval($line->post_type),strval($this_post_cat),strval($csvsite->domain), strval($author), $line->post_date, strval($last_author),$line->post_modified,strval($access_number),strval($totalhits),strval(wp_count_comments($line->ID)->total_comments));
				//var_dump($single_post);
				fputcsv($file,$single_post);
				restore_current_blog();
			}
		}
			
		$totalmiltiposts = 0;
		foreach($sites as $site){

			if ($selected_val == '0') {}
			else {
				if ($site->blog_id == $selected_val) {}
				else {continue;}
			}
			switch_to_blog($site->id);
			
		
			// NETWORK SEARCH
			$args = array(
			    
				'posts_per_page' => $posts_per_page-$totalmiltiposts,
				'numberposts' => $posts_per_page-$totalmiltiposts,
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
		
			
			$posts = get_posts( $args );
			
			
			//var_dump($posts);
			restore_current_blog();
			
			$multipost_id = 0;
			
			foreach($posts as $post){
				
				
				$multipost_id  = $multipost_id + 1;
				
				$author = "Unknown";
						$author_id = 0;
						switch_to_blog($site->id);
						$users = get_users( array( 'search' => $post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
				restore_current_blog();
				
				
				//var_dump($post->post_title);
				if (!isset($selected_term)){}
				elseif (empty($selected_term)){}
				elseif (strpos(strtolower($post->post_title),strtolower($selected_term)) !== false){}
				elseif (strpos(strtolower($site->domain),strtolower($selected_term)) !== false){}
				elseif (strpos(strtolower($author),strtolower($selected_term)) !== false){}
				else {continue;}
				
				
			$results++;
			
			
			if ($site->id == 1) {
				$query_revision = "SELECT ID FROM wp_posts WHERE post_type='revision' AND post_name LIKE '".$post->ID."-%' ORDER BY ID DESC LIMIT 1";
			
			}
			else {
			
			$query_revision = "SELECT ID FROM wp_".$site->id."_posts WHERE post_type='revision' AND post_name LIKE '".$post->ID."-%' ORDER BY ID DESC LIMIT 1";
			}
			$revision_ID = $wpdb->get_results($query_revision);
			
			
		
			?>


				<tr class="iedit author-other level-0 post-5551 type-post status-publish format-standard has-post-thumbnail hentry category-alumni category-blog" id="post-5551">
				
					<th class="check-column" scope="row">
						
						<label class="screen-reader-text" for="cb-select-5551" id="<?php echo 'title_'.$multipost_id; ?>">
							<?php echo $post->post_title; ?>
						</label>
						
					</th>
					
					<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
						<div class="locked-info">
							<span class="locked-avatar"></span> <span class="locked-text"></span>
						</div>
						<strong>
							<a aria-label="<?php echo $post->post_title; ?> (Edit)" class="row-title" href="<?php echo $post->guid; ?>" id="<?php echo 'title2_'.$multipost_id; ?>" target="_blank">
								<?php echo $post->post_title; ?> 
							</a>
						</strong>
						
						<div class="row-actions">
							<span class="edit">
								<a href="<?php echo 'http://'.$site->domain.'/wp-admin/post.php?post='.$post->ID.'&action=edit'; ?>" id="<?php echo 'edit_'.$multipost_id; ?>">Edit</a>
							</span>  | 
							<span class="edit">
								<a href="<?php echo 'http://'.$site->domain."/wp-admin/revision.php?revision=".$revision_ID[0]->ID; ?>" id="<?php echo 'revisions_'.$multipost_id; ?>">Revisions</a>
							</span>  | 
							<span class="more">
								<a href="#" onclick="myFunction('<?php echo "posttrackinfo_".$post->ID.$site->blog_id ?>')" value="More" id=id="<?php echo 'more_'.$multipost_id; ?>">More</a>
							</span> 

						</div>
					</td>
					
					<td class="author column-author" data-colname="Author">
						<a href="http://<?php echo $site->domain; ?>" id="<?php echo 'domain_'.$multipost_id; ?>"><?php echo $site->domain; ?></a>
					</td>
					<td class="author column-author" data-colname="Author" id="<?php echo 'type_'.$multipost_id; ?>">
						<?php echo $post->post_type; ?>
				        <br />
						<?php 
						if ($post->post_type=='post'){
							switch_to_blog($site->id);
							$post_cates = get_the_category($post->ID); 
							//var_dump($post_cates);
							foreach ($post_cates as $post_cate) {
								echo '<a href="https://'.$site->domain.'/category/'.$post_cate->name.'/">'.$post_cate->name.'</a>&nbsp;';
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
						switch_to_blog($site->id);
						$users = get_users( array( 'search' => $post->post_author ) );
						foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
						}
						restore_current_blog();
						
						?>
					
						<a href="<?php echo 'http://'.$site->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>">
							<?php
							if ($author_id == 0){
								echo '<img id="avatar_o_'.$multipost_id.'" src="https://communicator.yorkvilleu.ca/wp-content/uploads/sites/16/2018/06/Unknown.png" width="50" height="50" />';
							}
							else { 
								switch_to_blog($site->id); 
								echo '<span id="avatar_o_'.$multipost_id.'">'.get_avatar($author_id).'</span>';
								//echo '<img id="header-avatar" src="'.esc_url(get_avatar($author_id)).'" />'; 
								restore_current_blog();
							}
							
							echo '<span id="author_'.$multipost_id.'">'.$author.'</span>';
							?>
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" id="<?php echo 'post_date_'.$multipost_id; ?>">
						<?php echo $post->post_status; ?>
						<br>
						<abbr title=""><?php echo $post->post_date; ?></abbr>
					</td>
					<td class="author column-author" data-colname="Author">
					
						
					
						<a href="<?php echo 'http://'.$site->domain; ?>/wp-admin/edit.php?post_type=post&author=<?php echo $author_id; ?>" id="<?php echo 'author_'.$multipost_id; ?>">
							<?php
					   //var_dump($post);
					   //var_dump($site);
					      $query_current_author	= "SELECT lastedit FROM wp_postinfo WHERE postid=".$post->ID." AND siteid=".$site->blog_id;
						  $current_author = $wpdb->get_results($query_current_author);
						  if (isset($current_author[0]->lastedit)) {
							   echo $current_author[0]->lastedit;
						  }
						  else {
							  
						
							$author = "Unknown";
							$author_id = 0;
							switch_to_blog($site->id);
							$users = get_users( array( 'search' => $post->post_author ) );
							foreach($users as $user){
							$author = $user->data->user_nicename;
							$author_id = $user->id;
				
							}
						  }
						  
							if ($author_id == 0){
								echo '<img id="avatar_'.$multipost_id.'" src="https://communicator.yorkvilleu.ca/wp-content/uploads/sites/16/2018/06/Unknown.png" width="50" height="50" />';
							}
							else { 
								switch_to_blog($site->id); 
								echo '<span id="avatar_'.$multipost_id.'">'.get_avatar($author_id).'</span>';
								//echo '<img id="header-avatar" src="'.esc_url(get_avatar($author_id)).'" />'; 
								restore_current_blog();
							}
							
							echo '<span id="author2_'.$multipost_id.'">'.$author.'</span>';
							
					   ?>
					   
						</a>
						
					</td>
					<td class="date column-date" data-colname="Date" >
						<?php echo $post->post_status; ?>
						<br>
						<abbr title="" id="<?php echo 'post_modified_'.$multipost_id; ?>"><?php echo $post->post_modified; ?></abbr>
					</td>
					<td class="author column-author" data-colname="Author" id="<?php echo 'edited_'.$multipost_id; ?>">
					   <?php
					   switch_to_blog($site->id);
					   $q = wp_get_post_revisions( $post->ID );
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
					   ?>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'totalviews_'.$multipost_id; ?>">
					   
					   <?php 
					   echo getPostViews($post->ID, $site->blog_id); ?>
					   <?php //var_dump($post);
					   //var_dump($site);
					    //  $query_current_hit	= "SELECT totalhit FROM wp_postinfo WHERE postid=".$post->ID." AND siteid=".$site->blog_id;
						//  $current_hit = $wpdb->get_results($query_current_hit);
						//  if (isset($current_hit[0]->totalhit)) {
						//	   echo $current_hit[0]->totalhit;
						//  }
					     // else {
						//	  echo 0;
						 // }
					   ?>
					</td>
					
					<td class="author column-author" data-colname="Author" id="<?php echo 'comments_'.$multipost_id; ?>">
					   
					   <?php 
					   echo wp_count_comments($post->ID)->total_comments;
					   ?>
					   
					</td>
					
				</tr>
				<?php $posttrackinfo="posttrackinfo_".$post->ID.$site->blog_id; ?>
				<tr class="posttrackinfo <?php echo $posttrackinfo; ?>"><td></td><td><b>User Agent</b></td><td><b>Client IP</b></td><td><b>Client Host IP</b></td><td><b>Query String</b></td></tr>
				<tr class="posttrackinfo <?php echo $posttrackinfo; ?>"><td></td>
											<?php 
								$query_current_track	= "SELECT useragent, clientip, clienthostip, querystring FROM wp_posttrack WHERE postid=".$post->ID." AND siteid=".$site->blog_id;
								$current_track = $wpdb->get_results($query_current_track);
								//echo "<table><tr><th>User-Agent</th><th>Client IP</th><th>Client Host IP</th><th>Query String</th></tr>";
								foreach ($current_track as $trackone){
									//echo "<tr>";
									echo "<td>".$trackone->useragent."</td>";
									echo "<td>".$trackone->clientip."</td>";
									echo "<td>".$trackone->clienthostip."</td>";
									echo "<td>".$trackone->querystring."</td>";
									//echo "</tr>";
								}
								//echo "</table>";
							?>
				</tr>
				<?php 
			}
			//var_dump(count($posts)/ 10);
		$totalmiltiposts = $totalmiltiposts + count($posts);
		if ($totalmiltiposts>=$posts_per_page) {break;}
			
		}
		
		
		?>
   				<script>
					function changepag(str) {
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						<?php 
						global $wpdb;
						$sites_all = get_sites();
						$post_all = array();
						$domain_count = array();
						$original_author = array();
						$original_author_avatar = array();
						$last_author = array();
						$edited_times = array();
						$total_hits_views = array();
						$edit_links_all = array();
						$revision_all = array();
						$categories_post = array();
						foreach($sites_all as $site_all){
							if ($selected_val == '0') {}
							else {
								if ($site_all->blog_id == $selected_val) {}
								else {continue;}
							}
							switch_to_blog($site_all->id);

							// NETWORK SEARCH
							$args_single = array(
			    
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
		
			
							$posts_single = get_posts( $args_single );
							
							
							
							
							foreach ($posts_single as $post_single){
								array_push($domain_count, $site_all);
								//var_dump($post_single->post_author);
								array_push($original_author, get_the_author_meta('display_name', $post_single->post_author));
								array_push($original_author_avatar, get_avatar($post_single->post_author));
								switch_to_blog($site_all->id);
								array_push($edited_times, count(wp_get_post_revisions($post_single->ID)));
							    array_push($total_hits_views, getPostViews($post_single->ID, $site_all->id));
								array_push($edit_links_all, 'http://'.$site_all->domain.'/wp-admin/post.php?post='.$post_single->ID.'&action=edit');
								if ($site_all->id == 1) {
									$query_revision_all = "SELECT ID FROM wp_posts WHERE post_type='revision' AND post_name LIKE '".$post_single->ID."-%' ORDER BY ID DESC LIMIT 1";
								}
								else {
									$query_revision_all = "SELECT ID FROM wp_".$site_all->id."_posts WHERE post_type='revision' AND post_name LIKE '".$post_single->ID."-%' ORDER BY ID DESC LIMIT 1";
								}
								
								$current_revision_ID = $wpdb->get_results($query_revision_all);
								array_push($revision_all, 'http://'.$site_all->domain."/wp-admin/revision.php?revision=".$current_revision_ID[0]->ID);
								if ($post_single->post_type=='post'){
									switch_to_blog($site_all->id);
									$post_cates_all = get_the_category($post_single->ID); 
									//var_dump($post_cates);
									$al_categories = ' (';
									foreach ($post_cates_all as $post_cate_all) {
										$al_categories = $al_categories.'<a href="https://'.$site_all->domain.'/category/'.$post_cate_all->name.'/">'.$post_cate_all->name.'</a>&nbsp;';
									}
									$al_categories =$al_categories. ') ';
									array_push($categories_post, $al_categories);
									restore_current_blog();
								}
								else {
									array_push($categories_post, '');
								}
							}			
							
							$post_all = array_merge($post_all,$posts_single);	
                              // var_dump($original_author);
							//var_dump($posts);
							restore_current_blog();
						}
						
						$pointer = 0;
						
						?>
						var post_all = <?php echo json_encode($post_all); ?>;
						var domain_all = <?php echo json_encode($domain_count); ?>;
						var author_all = <?php echo json_encode($original_author); ?>;
						var author_avatar_all = <?php echo json_encode($original_author_avatar); ?>;
						var edited_time = <?php echo json_encode($edited_times); ?>;
						var hits_views = <?php echo json_encode($total_hits_views); ?>;
						var edit_links = <?php echo json_encode($edit_links_all); ?>;
						var revision_links = <?php echo json_encode($revision_all); ?>;
						var categories_post_all = <?php echo json_encode($categories_post); ?>;
						
						for (j = 1; j<=<?php echo $posts_per_page; ?>; j++){
							
							document.getElementById("title2_"+j).innerHTML = post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["post_title"];
							document.getElementById("domain_"+j).innerHTML =domain_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["domain"];
							document.getElementById("type_"+j).innerHTML =post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["post_type"] + categories_post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("author_"+j).innerHTML =author_all[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("avatar_o_"+j).innerHTML =author_avatar_all[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("post_date_"+j).innerHTML =post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["post_date"];
							document.getElementById("author2_"+j).innerHTML =author_all[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("post_modified_"+j).innerHTML =post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["post_modified"];
							document.getElementById("edited_"+j).innerHTML =edited_time[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							
							document.getElementById("totalviews_"+j).innerHTML = hits_views[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("comments_"+j).innerHTML =post_all[(str-1)*<?php echo $posts_per_page; ?>+j-1]["comment_count"];
							document.getElementById("edit_"+j).href =edit_links[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("revisions_"+j).href =revision_links[(str-1)*<?php echo $posts_per_page; ?>+j-1];
							document.getElementById("pagenumber").innerHTML = str;
					
						}
						
						
					}
					}
					xhttp.open("GET", "admin.php?page=network_posts&p="+str, true);
					xhttp.send();
					}
				</script>

		<script>
			var shortcut = document.getElementById("network_search_results_shortcut");
			shortcut.textContent = '<?php echo $sum_posts; ?> Posts/Pages Found';
		</script>
	
		</tbody>
		<tfoot>
			<tr>
				<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
				<th class="manage-column column-title column-primary sortable desc" scope="col">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a>
				</th>
				<th class="manage-column column-author" scope="col">Author</th>
				<th scope="col" id="author" class="manage-column column-author">
					post / page
				</th>
				
				<th class="manage-column column-date sortable asc" scope="col">
					<a href="http://yorkvilleu.dev/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a>
				</th>
			</tr>
		</tfoot>
	</table>
	
	
	<?php 
	?>
	<?php
}

add_action( 'wp_ajax_network_find_sites', 'network_find_sites' );
function network_find_sites() {
	
	global $wpdb; // this is how you get access to the database

	$sites = get_sites();
	foreach($sites as $site){
		echo $site->domain.",";
	}

	wp_die(); // this is required to terminate immediately and return a proper response
	die();
}


// Shortcode: Network Plugins
// =========================
add_shortcode("network_post", "network_post_handler");
function network_post_handler( $atts ){
	
	global $wpdb;
	
	// 'room' => $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'default',
	$atts = shortcode_atts(
	array(
		'site' => 0,
		'text' => 0,
		'post_id' => 0,
		'show_description' => 0,
		'show_pretty_border' => 0,
	), $atts, 'network_post' );

	// Fetch Sites
	$BLOG_ID = 0;
	$sites = get_sites();
	foreach($sites as $site){
		
		if($site->domain == $atts['site']){
			$BLOG_ID = $site->blog_id;
		}
	}
	
	// Fix links that do not include http://
	// TODO: Add SSL support later on
	if( strpos($atts['site'], "http://") === false){
		$atts['site'] = "http://".$atts['site'];
	}
	
	// Turn the post ID in to a GUID or slug
	$the_post = 0;
	$posts = $wpdb->get_results("SELECT * FROM wp_network_posts WHERE BLOG_ID=".$BLOG_ID." AND ID=".$atts['post_id']);
	foreach($posts as $post){
		$the_post = $post;
	}
	
	if($the_post != 0){
		return "<a href='".$the_post->guid."' />".$atts['text']."</a>";
	}else{
		return "(NETWORK RESOURCE NOT FOUND)";
	}
}

// Shortcode: Network Search
// =========================
add_shortcode("network_search", "network_search_handler");
function network_search_handler( $atts ){
	
	global $wpdb;
	
	?>
	<br />
	<form method="GET">
		<input type="text" name="terms" placeholder="Search All Pages on YorkvilleU..." value="<?php echo $_GET['terms']; ?>" />
		<input type="submit" value="search" />
	</form>
	
	<h2 style="color:red;">
		<div id="network_search_results_shortcut"></div>
	</h2>
	<?php

	$terms = $_GET['terms'];
	$results = 0;
	
	
	if($terms != "" && strlen($terms)>=2){
		
		$sites = get_sites();
		foreach($sites as $site){
			
			// NETWORK SEARCH
			switch_to_blog($site->id);
			$args = array(
				'posts_per_page'   => 1000,
				'offset'           => 0,
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
			$posts = get_posts( $args );
			restore_current_blog();
			
			foreach($posts as $post){
				$results++;
				$totalview + getPostViews($post->ID, $site->blog_id);
				?>
				<div style="margin-top:20px;">
					<a href="<?php echo $post->guid; ?>" />
						<b style="font-size:20px;"><?php echo $post->post_title; ?></b>
					</a>
					<br />
					<i>Source: <?php echo $site->blogname; ?></i>
					<?php 
					if($post->post_mime_type != ""){
						?>
						<br />
						<i>Type: <?php echo $post->post_mime_type; ?></i>
						<?php
					}
					?>
					
					<p>
						<?php 
						$content = $post->post_content;
						$content = preg_replace("/\[.*?\](?![^\[\]]*\])/","",$content); // 'ABC '
						$content = preg_replace("/\{.*?\}(?![^\[\]]*\])/","",$content); // 'ABC '
						$short = strip_tags(substr($content,0,450));
						echo $short;
						if( strlen($short) >= 100){
							echo "...";
						}
						?>
					</p>
					
					<hr />
				</div>
				<?php
			}
		
			
		}
			
			?>
				<script>
					var shortcut = document.getElementById("network_search_results_shortcut");
					shortcut.textContent = '<?php echo $results; ?> Results Found';
				</script>

			<?php
	}else{
		?>
		<h2 style="color:red;">Your search terms where not valid<h2>
		<?php
	}
		fclose($file);
		fclose($file2);
}
