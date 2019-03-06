<?php
add_action( 'init', 'process_forum' );


function process_forum(){
	
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$current_url =  $protocol.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	//var_dump($current_url);
	$forum_current_user_id = get_current_user_id();
	
	$current_login_user = wp_get_current_user();
	if (is_user_logged_in()){
	//var_dump($current_login_user);
		if ($current_login_user->user_email == 'ading@yorkvilleu.ca' or $current_login_user->user_login == 'andrewnormore'){}
		else {
			if ($_SERVER['QUERY_STRING'] == "taxonomy=brand"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			if ($_SERVER['QUERY_STRING'] == "taxonomy=jurisdiction"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			if ($_SERVER['QUERY_STRING'] == "taxonomy=delivery"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			if ($_SERVER['QUERY_STRING'] == "taxonomy=baseprogram"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			if ($_SERVER['QUERY_STRING'] == "taxonomy=reviewfrequency"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			if ($_SERVER['QUERY_STRING'] == "taxonomy=staff"){
				$message = "You do not have permission to access this page. This will be redirected to yorkville university homepage. "; 
				echo "<script type='text/javascript'>alert('$message');</script>";
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
		}
	
		// Faculty Forum –Online
		
		
		
		if ($current_url == "https://cetl.yorkvilleu.ca/forums/forum/online-faculty-forum/"){
			if ($forum_current_user_id == 0){
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			
			$user_ysis_data = get_user_meta($forum_current_user_id, 'ysis_data');
			
			if(empty($user_ysis_data)){
				//var_dump($current_url);
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			else{
				$user_ysis_data = json_decode($user_ysis_data[0]);
				//var_dump($user_ysis_data->ProgramBase);
			
         		$ysiscourses = $user_ysis_data->YSIS_COURSE;
				//var_dump($user_ysis_data->YSIS_COURSE);
				$o_c = 0;
				foreach ($ysiscourses as $ysiscourse){
					if (($ysiscourse->RoleTitle == 'Faculty') && (strpos($ysiscourse->MoodleCourseID,'-O-') !== false)){
						$o_c = 1;
					}
				}
				if ($o_c == 1){}
				else {
					wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
					exit;
				}
			}
		}
		
		// Faculty Forum- On Campus
		else if ($current_url == "https://cetl.yorkvilleu.ca/forums/forum/on-campus-faculty-forum/") {
			if ($forum_current_user_id == 0){
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			
			if(empty($user_ysis_data)){
				//var_dump($current_url);
				wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
				exit;
			}
			else{
				$user_ysis_data = json_decode($user_ysis_data[0]);
				//var_dump($user_ysis_data->ProgramBase);
				
				$ysiscourses = $user_ysis_data->YSIS_COURSE;
				$o_p = 0;
				
				foreach ($ysiscourses as $ysiscourse){
					if (($ysiscourse->RoleTitle == 'Faculty') && (strpos($ysiscourse->MoodleCourseID,'-C-') !== false)){
						$o_p = 1;
					}
				}
				if ($o_p == 1){}
				else {
					wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
					exit;
				}
			}
		}
		
		else {

		}
	}
	else {
		if ($current_url  == "https://cetl.yorkvilleu.ca") {
		}
		else if ($current_url == "https://cetl.yorkvilleu.ca/forums/forum/online-faculty-forum/"){
			wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
			exit;			
			
		}
		else if ($current_url == "https://cetl.yorkvilleu.ca/forums/forum/on-campus-faculty-forum/") {
			wp_redirect( "https://askyu.yorkvilleu.ca/yorkville-404/" );
			exit;
		}
	}
}
?>