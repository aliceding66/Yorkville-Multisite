<?php

// [get_info_from_email_api]
// 

function get_info_from_email_api_function(){
	
	global $wpdb;
	
	//var_dump( $_GET['email'] );
	//var_dump( strpos( $_GET['email'],'@') );
	
	if(isset( $_GET['email'])){
	}
	else{
		//echo "Unauthorized";
		$test='Unauthorized-Invalid';
		var_dump($test);
		return;
		die;
		exit;
	}
	
	
	if( strpos($_GET['email'],'@') !== false){
		
		/*
	    this piece of code would work well for an EXISTING user, but some times the user will not exist, 
		so we will store a token anyway based on that email */
		
		$query_current_info = "SELECT * FROM wp_usermeta WHERE meta_key='ysis_data' AND meta_value LIKE '%".$_GET['email']."%' order by umeta_id desc";
	
		$current_info = $wpdb->get_results($query_current_info);
		
		//var_dump($current_info);

		if (isset($current_info[0]->meta_value)){
			$verified_ysis = json_decode($current_info[0]->meta_value);
			//var_dump($verified_ysis);
			if ((isset($verified_ysis->Email)) && (strtolower($_GET['email']) == strtolower($verified_ysis->Email))){
			    
				if ( !is_object( $myStudent ) ) {
					$myStudent = new stdClass(); 
				}         

				$myStudent->ID = $verified_ysis->StudentID;
				$myStudent->FirstName = $verified_ysis->FirstName;
				$myStudent->LastName = $verified_ysis->LastName;
				$myStudent->ProgramBase = $verified_ysis->ProgramBase;
				$myStudent->ProgramCore = $verified_ysis->ProgramCore;
				$myStudent->Campus = $verified_ysis->Campus;
				$myStudent->Status = $verified_ysis->Status;
				

				$StudentInfoJSON = json_encode($myStudent);
				
				echo $StudentInfoJSON;
				
				exit;
			}
			else if ((isset($verified_ysis->SecondEmail)) && (strtolower($_GET['email']) == strtolower($verified_ysis->SecondEmail))){
				//var_dump($verified_ysis);
			
				if ( !is_object( $myStudent ) ) {
					$myStudent = new stdClass(); 
				}   
				
				$myStudent->ID = $verified_ysis->StudentID;
				$myStudent->FirstName = $verified_ysis->FirstName;
				$myStudent->LastName = $verified_ysis->LastName;
				$myStudent->ProgramBase = $verified_ysis->ProgramBase;
				$myStudent->ProgramCore = $verified_ysis->ProgramCore;
				$myStudent->Campus = $verified_ysis->Campus;
				$myStudent->Status = $verified_ysis->Status;
				

				$StudentInfoJSON = json_encode($myStudent);
				
				echo $StudentInfoJSON;
				
				exit;
			}
			else if (isset($verified_ysis->YSIS_COURSE[0])){
				//var_dump($verified_ysis->YSIS_COURSE); 
				
				foreach ($verified_ysis->YSIS_COURSE as $ysis_course_list){
					if (strtolower($_GET['email']) == strtolower($ysis_course_list->LoginID)){
						
						if ( !is_object( $myStudent ) ) {
							$myStudent = new stdClass(); 
						}  
						
						$myStudent->ID = $ysis_course_list->StudentID;
						$myStudent->FirstName = $ysis_course_list->FirstName;
						$myStudent->LastName = $ysis_course_list->LastName;
						$myStudent->ProgramBase = $ysis_course_list->ProgramBase;
						$myStudent->ProgramCore = $ysis_course_list->ProgramCore;
						$myStudent->Campus = $ysis_course_list->Campus;
						$myStudent->Status = $ysis_course_list->Status;
				

						$StudentInfoJSON = json_encode($myStudent);
				
						echo $StudentInfoJSON;
						
						exit;
					}
					else if (strtolower($_GET['email']) == strtolower($ysis_course_list->Email)){
						
						if ( !is_object( $myStudent ) ) {
							$myStudent = new stdClass(); 
						}  
						
						$myStudent->ID = $ysis_course_list->StudentID;
						$myStudent->FirstName = $ysis_course_list->FirstName;
						$myStudent->LastName = $ysis_course_list->LastName;
						$myStudent->ProgramBase = $ysis_course_list->ProgramBase;
						$myStudent->ProgramCore = $ysis_course_list->ProgramCore;
						$myStudent->Campus = $ysis_course_list->Campus;
						$myStudent->Status = $ysis_course_list->Status;
				

						$StudentInfoJSON = json_encode($myStudent);
				
						echo $StudentInfoJSON;
						
						exit;
					}
					else if (strtolower($_GET['email']) == strtolower($ysis_course_list->Secondary_Email)){
						
						if ( !is_object( $myStudent ) ) {
							$myStudent = new stdClass(); 
						}  
						
						$myStudent->ID = $ysis_course_list->StudentID;
						$myStudent->FirstName = $ysis_course_list->FirstName;
						$myStudent->LastName = $ysis_course_list->LastName;
						$myStudent->ProgramBase = $ysis_course_list->ProgramBase;
						$myStudent->ProgramCore = $ysis_course_list->ProgramCore;
						$myStudent->Campus = $ysis_course_list->Campus;
						$myStudent->Status = $ysis_course_list->Status;
				

						$StudentInfoJSON = json_encode($myStudent);
				
						echo $StudentInfoJSON;
						
						exit;
					}
				}
			}
			else {
				//echo "Not Found";
				$test='Not Found';
				echo $test;
				//var_dump($test);
				return;
				die;
				exit;
			}
		}
		else {
			//echo "Not Found";
			$test='Not Found';
			echo $test;
			//var_dump($test);
			return;
			die;
			exit;
			
		}
	
	}
	
	$test='Unauthorized-InvalidEmail';
	var_dump($test);
	return;
	die;
	exit;
	
}

add_shortcode( 'get_info_from_email_api', 'get_info_from_email_api_function' );


?>