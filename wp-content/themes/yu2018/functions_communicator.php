<?php

add_shortcode('check_mailpoet_subscribers', 'check_sub');

function check_sub(){
	
	global $wpdb;
	
	$query_all_emails = "SELECT substring(meta_value,position('\"Email\":\"' in meta_value)+9,POSITION('\",\"Second' IN meta_value)-position('\"Email\":\"' in meta_value)-9) as emailname, SUBSTRING(meta_value,POSITION('\"ProgramBase\":\"' IN meta_value)+15,POSITION('\",\"ProgramCore\":' IN meta_value)-POSITION('\"ProgramBase\":\"' IN meta_value)-15) AS groupname FROM wp_usermeta WHERE meta_key = 'ysis_data'";
	//var_dump($query_all_emails);
	$current_query_all_emails = $wpdb->get_results($query_all_emails);
	//var_dump($current_query_all_emails);
	
	foreach ($current_query_all_emails as $current_group_and_email) {
		
		$emailname = $current_group_and_email->emailname;
		$groupname = $current_group_and_email->groupname;
		
		//check if email name exist in mailpoet group
		$query_if_email_exist = "SELECT id, email FROM wp_16_mailpoet_subscribers WHERE email = '".$emailname."'";
		$current_query_if_email_exist = $wpdb->get_results($query_if_email_exist);
		
		//var_dump($current_query_if_email_exist);
		
		
		// if email doesnt exist
		// add email and group to corresponding place
		if (empty($current_query_if_email_exist)){
			
			$query_get_subscriber_id = "SELECT id FROM wp_16_mailpoet_subscribers WHERE email = '".$emailname."'";
			$current_query_get_subscriber_id = $wpdb->get_results($query_get_subscriber_id);
				
			$subscriber_id_current = $current_query_get_subscriber_id[0]->id;
			
			$query_get_segment_id = "SELECT id FROM wp_16_mailpoet_segments WHERE name = '".$groupname."'";
			$current_query_get_segment_id = $wpdb->get_results($query_get_segment_id);
				
			$segment_id_current = $current_query_get_segment_id[0]->id;
			
			$query_insert_group_rel = "INSERT INTO wp_16_mailpoet_subscriber_segment (subscriber_id, segment_id, wp_16_mailpoet_subscriber_segment.status, created_at, updated_at ) VALUES (".$subscriber_id_current.",".$segment_id_current.",'subscribed',NOW(), NOW());";
			$current_query_insert_group_rel = $wpdb->get_results($query_insert_group_rel);
		}
		// if email exist 
		else {
		// check if groupname is correct with what in mailpoet groups
			
			$query_if_group_correct = "SELECT wp_16_mailpoet_segments.name FROM wp_16_mailpoet_segments WHERE id IN (SELECT segment_id FROM wp_16_mailpoet_subscriber_segment WHERE subscriber_id = ".$current_query_if_email_exist[0]->id.")";
			$current_query_if_group_correct = $wpdb->get_results($query_if_group_correct);
			//var_dump($current_query_if_group_correct);
			//var_dump($groupname);
			//var_dump($current_query_if_group_correct);
			
			// if the group is correct
			// done
			if ($groupname == $current_query_if_group_correct[0]->name) {}
			else if ($groupname == $current_query_if_group_correct[1]->name) {}
			//if the group is not correct
			// update the current grouprelation
			else{
				$query_get_subscriber_id = "SELECT id FROM wp_16_mailpoet_subscribers WHERE email = '".$emailname."'";
				
				$current_query_get_subscriber_id = $wpdb->get_results($query_get_subscriber_id);
				
				$subscriber_id_current = $current_query_get_subscriber_id[0]->id;
				
				//var_dump($subscriber_id_current);
				
				
				$query_temp = "SELECT id FROM wp_16_mailpoet_segments WHERE wp_16_mailpoet_segments.name = '".$groupname."'";
				$current_query_temp = $wpdb->get_results($query_temp);
				
				
				$query_delete_current = "DELETE FROM wp_16_mailpoet_subscriber_segment WHERE subscriber_id = ".$subscriber_id_current;
				$current_query_delete_current = $wpdb->get_results($query_delete_current);

				$query_update_current_group_rel = "INSERT INTO wp_16_mailpoet_subscriber_segment (subscriber_id, segment_id, wp_16_mailpoet_subscriber_segment.status, created_at, updated_at) VALUES (".$subscriber_id_current.", ".$current_query_temp[0]->id.",'subscribed', NOW(),NOW())";
				//var_dump($query_update_current_group_rel);
				$current_query_update_current_group_rel = $wpdb->get_results($query_update_current_group_rel);
				$query_update_current_group_rel_all = "INSERT INTO wp_16_mailpoet_subscriber_segment (subscriber_id, segment_id, wp_16_mailpoet_subscriber_segment.status, created_at, updated_at) VALUES (".$subscriber_id_current.", 1,'subscribed', NOW(),NOW())";
				//var_dump($query_update_current_group_rel);
				$current_query_update_current_group_rel_all = $wpdb->get_results($query_update_current_group_rel_all);
			}
		
		
		
		}
		
	
	}
}


add_shortcode( 'current_author_posts', 'current_author_posts_shortcode_func' );

function current_author_posts_shortcode_func() {
	
	global $wpdb;
	
	$sites = get_sites();
	foreach($sites as $site){
			// Get the new draft post ID
			if ($site->domain == 'communicator.yorkvilleu.ca') {
				$current_site_id = $site->blog_id;
				//var_dump($current_site_id);
			}
			if ($site->domain == 'communicator.yorkvilleu.test') {
				$current_site_id = $site->blog_id;
			}
	}
	
	
	$current_author_name = get_the_author_meta('display_name');
	
	$current_author_email = get_the_author_meta('user_email');
	
	$query_current_author_post = "SELECT * FROM wp_".$current_site_id."_mailpoet_newsletters WHERE TYPE='notification_history' AND reply_to_name='".$current_author_name."'";
	
	$current_author_posts = $wpdb->get_results($query_current_author_post);
	
	
	
	?>
	
	<table style="text-align: center;">
		<tr>
			<th>Sender</th>
			<th>Subject</th>
			<th>Status</th>
			<th>Program Groups</th>
			<th>Opend, Clicked</th>
			<th>Sent on</th>
		</tr>
		
	
	<?php
	
	foreach($current_author_posts as $current_author_post){
		
		$query_get_program_group = "SELECT description FROM wp_".$current_site_id."_mailpoet_segments WHERE  id IN (SELECT segment_id FROM wp_".$current_site_id."_mailpoet_newsletter_segment WHERE newsletter_id = ".$current_author_post->id.")";
		$current_program_groups = $wpdb->get_results($query_get_program_group);
		$programs = '';
		foreach ($current_program_groups as $current_program_group) {
			$programs = $programs.$current_program_group->description.', ';
		}
		$programs = substr($programs, 0, strlen($programs)-2);
		
		
		$query_get_open = "SELECT COUNT(*) as open_rate FROM wp_".$current_site_id."_mailpoet_statistics_opens WHERE newsletter_id = ".$current_author_post->id;
		
		$current_open = $wpdb->get_results($query_get_open);
		
		$query_total_receiver = "SELECT COUNT(*) as total_receivers FROM wp_".$current_site_id."_mailpoet_subscriber_segment WHERE segment_id IN (SELECT segment_id FROM wp_".$current_site_id."_mailpoet_newsletter_segment WHERE newsletter_id = ".$current_author_post->id.")";
		
		$current_receivers = $wpdb->get_results($query_total_receiver);
		
		
		$query_get_clicked = "SELECT COUNT(*) as click_rate FROM wp_".$current_site_id."_mailpoet_statistics_clicks WHERE newsletter_id = ".$current_author_post->id;
		
		$current_clicked = $wpdb->get_results($query_get_clicked);
		
		// var_dump($current_clicked);
		
		?>
		<tr>
			<td><?php echo $current_author_post->reply_to_name; ?></td>
			<td><?php echo $current_author_post->subject; ?></td>
			<td><?php echo $current_author_post->status; ?></td>
			<td><?php echo $programs; ?></td>
			<td><?php echo $current_open[0]->open_rate/$current_receivers[0]->total_receivers; ?>%, <?php echo $current_clicked[0]->click_rate/$current_receivers[0]->total_receivers; ?>%</td>
			<td><?php echo $current_author_post->updated_at; ?></td>
		</tr>
	<?php
	}
	?> 
	
	</table>
	<?php
	return null;
	
}
	
function after_submission_handler( $entry, $form) {
		
		global $wpdb;
		
		// Gravity form Program Field ID: 6
		$field = GFFormsModel::get_field( $form, 6 );
		
		// Get Selected Programs from communicator webpage
		$field_value = is_object( $field ) ? $field->get_value_export($entry ) : '';
		
		//get communicator site id
		$sites = get_sites();
		foreach($sites as $site){
			// Get the new draft post ID
		$query_new_post = "SELECT ID FROM wp_".$current_site_id."_posts WHERE post_status = 'draft' ORDER BY ID DESC LIMIT 0,1";
		//var_dump($query_new_post);
		$new_post_ID = $wpdb->get_results($query_new_post);
			//var_dump($site->blog_id);
			//var_dump($site->domain);
			if ($site->domain == 'communicator.yorkvilleu.ca') {
				$current_site_id = $site->blog_id;
				//var_dump($current_site_id);
			}
			if ($site->domain == 'communicator.yorkvilleu.test') {
				$current_site_id = $site->blog_id;
			}
		}
	
		
		//$current_site_id=get_current_blog_id();
		//$current_site_id=16;
		
		switch_to_blog($current_site_id);
		
		
		// Get the new draft post ID
		$query_new_post = "SELECT ID FROM wp_".$current_site_id."_posts WHERE post_status = 'draft' ORDER BY ID DESC LIMIT 0,1";
		//var_dump($query_new_post);
		$new_post_ID = $wpdb->get_results($query_new_post);
		//var_dump($new_post_ID);
	
		//add programs to wp_post_meta, meta_key: _gform_programs
		$query_update = "  INSERT INTO wp_".$current_site_id."_postmeta (post_id, meta_key, meta_value) 
							VALUES ('".$new_post_ID[0]->ID."', '_gform_programs','".$field_value."')";
	    //var_dump($query_update);
		$wpdb->query($query_update);
		
		// get forum id
		// Gravity form Forum Field ID: 7
		$forum_field = GFFormsModel::get_field( $form, 7 );
		$forum_id = is_object( $forum_field ) ? $forum_field->get_value_export($entry ) : '';
		//var_dump($forum_id);
		
		if ($forum_id == 0) {		
		}
		else {
		
		// get topic name
		// Gravity form Forum Field ID:4 
		$title_field = GFFormsModel::get_field( $form, 4 );
		$title_topic = is_object( $title_field ) ? $title_field->get_value_export($entry ) : '';
		$title_topic_dash = str_replace(' ', '-', strtolower($title_topic));
		//var_dump($title_topic);
		//var_dump($title_topic_dash);
		
		// get topic content 
		$content_field = GFFormsModel::get_field( $form, 5 );
		
		$content_topic = is_object( $content_field ) ? $content_field->get_value_export($entry ) : '';
		//var_dump($content_topic);
		
		$new_post = array(
            'post_title'    => $title_topic,
            'post_content'  => $content_topic,
            'post_parent' => $forum_id,
            'post_status'   => 'publish',
            'post_type' => 'topic'
        );
        $topic_meta = array(
            'forum_id'       => $new_post['post_parent']
        );
		
		// insert to forum
		switch_to_blog(17);
        $topic_id = bbp_insert_topic($new_post, $topic_meta);	
		restore_current_blog();
		
		// get forum post link
		$forum_post_link = "SELECT guid FROM wp_17_posts WHERE post_title ='".$title_topic."' AND post_parent = ".$forum_id." AND comment_status='closed' ORDER BY post_date DESC LIMIT 0,1";
		$post_link_result = $wpdb->get_results($forum_post_link);
		$post_link_result = $post_link_result[0];
		//var_dump($forum_post_link);
		//var_dump($post_link_result);
		

	     // add to post content
		 $new_post_content = "SELECT post_content FROM wp_".$current_site_id."_posts WHERE post_status = 'draft' AND post_title = '".$title_topic."' ORDER BY ID DESC LIMIT 0,1";
		 $post_content_result = $wpdb->get_results($new_post_content);
		 //var_dump($post_content_result);
		 $post_content_result = $post_content_result[0];
		 $post_content_result = 'Forum Link: <a href="'.$post_link_result->guid.'">'.$post_link_result->guid.'</a>&nbsp;&nbsp;&nbsp;<p></p>'. $post_content_result->post_content;
		 //var_dump($post_content_result);
		 $add_to_post_content = "UPDATE wp_".$current_site_id."_posts SET post_content ='".$post_content_result."' WHERE ID=".$new_post_ID[0]->ID;
		 //var_dump($add_to_post_content);
		 $wpdb->query($add_to_post_content);
	}	 
		 
	    //var_dump($query_update);
		$news_content = $wpdb->get_results($query_news_content);
		$news_content = $news_content[0];
	
		
		//add forum link to wp_post_meta, meta_key: _forum_link
		$query_update = "  INSERT INTO wp_".$current_site_id."_postmeta (post_id, meta_key, meta_value) 
							VALUES ('".$new_post_ID[0]->ID."', '_forum_link','".$forum_post_link."')";
	    //var_dump($query_update);
		$wpdb->query($query_update);
		
		

		//$query_result = "SELECT meta_value FROM wp_".$current_site_id."_postmeta WHERE meta_key = '_gform_programs' and post_id=".$new_post_ID[0]->ID;
		//$new_result = $wpdb->get_results($query_result);
		//var_dump($query_result);
		//var_dump($new_result);
		
		// set to publish after 180 seconds (3 minutes)
		//var_dump(time()+180);
		//wp_publish_post($new_post_ID[0]->ID);
		
		wp_schedule_single_event(time() + 180, 'draft_publish_event', array($new_post_ID[0]->ID, $current_site_id));

	
	}
	
	
	
	add_action('draft_publish_event', 'post_draft_to_publish',10,3);		
	function  post_draft_to_publish($publish_id, $current_site_id) {
			switch_to_blog($current_site_id);
			wp_publish_post($publish_id);
	}

	add_action( 'gform_after_submission', 'after_submission_handler',10,2 );	
	


	// grform_after_submission is the action hook for something happen after clicking the submit button from Gravity Forms
		
	function post_published_notification($ID, $post) {
		
		global $wpdb;
		
		//get communicator site id
		$sites = get_sites();
		foreach($sites as $site){
			//var_dump($site->blog_id);
			//var_dump($site->domain);
			if ($site->domain == 'communicator.yorkvilleu.ca') {
				$communicator_blog_id = $site->blog_id;
			}
			if ($site->domain == 'communicator.yorkvilleu.test') {
				$communicator_blog_id = $site->blog_id;
			}
		}
		
		// Get corresponding user email and display name
		$query_reply_info = "SELECT user_email, display_name FROM wp_users WHERE ID = (SELECT post_author FROM wp_".$communicator_blog_id."_posts WHERE ID = ".$ID.")";
		//var_dump($query_reply_info);
		$query_programs_results =  $wpdb->get_results($query_reply_info);
		//var_dump($query_programs_results);
		
		$user_email = $query_programs_results[0]->user_email;
		$user_name = $query_programs_results[0]->display_name;
		
		// put the name and user email into commmunicator form reply user settings
		$communicator_newsid = 1;
		
		$query_reply_update = "UPDATE wp_".$communicator_blog_id."_mailpoet_newsletters SET reply_to_address = '".$user_email."', reply_to_name = '".$user_name."' WHERE id = ".$communicator_newsid;
		//var_dump($query_reply_update);			
		$wpdb->query($query_reply_update);

		//var_dump($communicator_blog_id);
		
		// Get corresponding selected program names with this post
		$query_programs = "SELECT meta_value FROM wp_".$communicator_blog_id."_postmeta WHERE post_id = ".$ID." AND meta_key = '_gform_programs'";
		$query_programs_results =  $wpdb->get_results($query_programs);
		//var_dump($query_programs_results);
		
		// switch_to_blog($communicator_blog_id);
		// to make sure the post is from communicator side. If it is, then $query_programs_results should have result
		
			
			$programs = explode(",", $query_programs_results[0]->meta_value);
			//var_dump($programs);
			$Query_program_names = "";
			for ($i = 0; $i < count($programs); $i++){
				$programs[$i]=str_replace(' ', '', $programs[$i]);
				//var_dump($programs[$i]);
				$Query_program_names .= "'".$programs[$i]."',";
			}
			
			$Query_program_names = substr($Query_program_names, 0, strlen($Query_program_names)-1);
			//var_dump($Query_program_names);
		
		
			//extract the selected segment_id from wp_16_mailpoet_segments
			$query = "SELECT id
						FROM wp_".$communicator_blog_id."_mailpoet_segments
						WHERE NAME IN (".$Query_program_names.")"; 
			//var_dump($query);
			$segment_ids= $wpdb->get_results($query);
			
			//var_dump($segment_ids);
		
			// extract the mailpoet newsletter ID, which is 2 for now 
			$newsletter_id = 1;
		
			// Delete the previous program group relationship from the mailpoet database table
			$query_delete_original = "DELETE FROM wp_".$communicator_blog_id."_mailpoet_newsletter_segment WHERE newsletter_id = ".$newsletter_id;
		
			//var_dump($query_delete_original);
			$wpdb->query($query_delete_original);
		
			// insert new program group relationship to wp_16_mailpoet_newsletter_segment
			for ($i = 0; $i < count($programs); $i++){
				$query_update = "  INSERT INTO wp_".$communicator_blog_id."_mailpoet_newsletter_segment (newsletter_id, segment_id, created_at, updated_at) 
							VALUES ('".$newsletter_id."', '".$segment_ids[$i]->id."', CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP())";
				//var_dump($query_update);
				$wpdb->query($query_update);
		
			}
	}
	
	add_action( 'publish_post', 'post_published_notification', 10, 2 );
	// publish_post is the action hook for something happen when publishing post

	//function communicator_process_posts_shortcode_func($attr,$content){
		
	//		global $wpdb;
			
	//		$current_site_id = 16;
			//$current_site_id=get_current_blog_id();
			
	//		switch_to_blog($current_site_id);
			
	//		$query = array(
	//			'post_type' => 'post',
	//			'post_status' => array('draft'),
	//		);
	//		$loop = new WP_Query($query);
	//		$communicator_site_id = 16;
    //        $query_get_subscriber_id = "SELECT DISTINCT wp_".$communicator_site_id."_mailpoet_subscriber_segment.id FROM wp_".$communicator_site_id."_mailpoet_subscriber_segment JOIN wp_".$communicator_site_id."_mailpoet_subscribers ON wp_".$communicator_site_id."_mailpoet_subscribers.id = wp_".$communicator_site_id."_mailpoet_subscriber_segment.subscriber_id WHERE wp_user_id=5511";
	//	    $subscriber_id = $wpdb->get_results($query_get_subscriber_id);
	//		 $subscriber_id = $subscriber_id[0]->id; 
	//		var_dump($subscriber_id);
	//		
	//		while ( $loop->have_posts()) : $loop->the_post();
				
	//			wp_publish_post(get_the_ID());
				
				// $my_post = array(
				//     'ID' => get_the_ID(),
				//     'post_status' => 'future',
				//     'post_date' => current_time( 'timestamp')+300 
				// );
				
				//wp_update_psot($my_post)
			
				//$form_ID = get_post_meta(the_ID(), '_gform-form-id');
				//$lead_ID = get_post_meta(the_ID(), '_gform-entry-id'); 
				
				//$querystr = "SELECT TOP 1 $wpdb->rg_lead_detail.value FROM $wpdb->rg_lead_detail WHERE $wpdb->rg_lead_detail.lead_id = ".$lead_ID." AND $wpdb->rg_lead_detail.form_id = ".$form_ID;
				
				//$communicator_group = $wpdb->get_results($querystr, OBJECT);
			
				// get user email lists from JSON and email these users
				
				
				

	//		endwhile;
	//}
	
	
			
//add_shortcode( 'communicator_process_posts', 'communicator_process_posts_shortcode_func' );


add_action( 'post_submitbox_start', function() {
	// add a button on the post edit page, before the submit button on the post edit page
    print '<div><a class="button button-secondary" href="http://communicator.yorkvilleu.ca/home/?post_id='.get_the_ID().'%2C'.get_current_blog_id().'&title_id='.get_the_ID().'%2C'.get_current_blog_id().'" target="_blank" >Communicator</a></div>';
});

// gform_field_value_post_id is the filter hook for passing prameter post_id
add_filter( 'gform_field_value_post_id', 'populate_content' );

function populate_content( $post_id ) {
	if ($post_id == null) {return null;}
	$post_id = (string)$post_id;
	//$post_id = explode(",", $field_value);
	$post_id_now = 0;
	$site_id_now = 0;
	//var_dump($post_id);
	for ($i = 0; $i < strlen($post_id); $i++){
		//var_dump(substr($post_id,$i,1));
		if (substr($post_id,$i,1)==',') {
			$post_id_now = (int)substr($post_id,0,$i);
			$site_id_now = (int) substr($post_id,$i+1,strlen($post_id)-$i-1);
		}
	
	}
	switch_to_blog($site_id_now);
	//var_dump($post_id_now);	
	//var_dump($site_id_now);
	$content_post = get_post($post_id_now);
	$content = $content_post->post_content.'<br><br>Discuss more?Please go to: <a href="'.$content_post->guid.'">'.$content_post->post_title."</a>";
	//$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;	
}

// gform_field_value_post_id is the filter hook for passing prameter title_id
add_filter( 'gform_field_value_title_id', 'populate_title' );

function populate_title( $title_id ) {
	if ($title_id == null) {return null;}
	$title_id = (string)$title_id;
	//$post_id = explode(",", $field_value);
	$post_id_now = 0;
	$site_id_now = 0;
	//var_dump($title_id);
	for ($i = 0; $i < strlen($title_id); $i++){
		//var_dump(substr($title_id,$i,1));
		if (substr($title_id,$i,1)==',') {
			$post_id_now = (int) substr($title_id,0,$i);
			$site_id_now = (int) substr($title_id,$i+1,strlen($title_id)-$i-1);
		}
	
	}
	switch_to_blog($site_id_now);
	//var_dump($post_id_now);	
	//var_dump($site_id_now);
	$content_post = get_post($post_id_now);
	$content = $content_post->post_title;
	//var_dump($content);
	//$content = apply_filters('the_title', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;	
}

//add media to rich editor
function show_media_button( $editor_settings, $field_object, $form, $entry ) {
    $editor_settings['media_buttons'] = true;
	$editor_settings['editor_height'] = 400;
    return $editor_settings;
}
add_filter( 'gform_rich_text_editor_options', 'show_media_button', 10, 4 );

add_filter( 'gform_rich_text_editor_buttons', 'my_function', 10, 2 );
function my_function( $mce_buttons ) {
    $mce_buttons = array('fontselect','fontsizeselect','styleselect','cut','copy','backcolor','bold','italic','underline','separator','alignleft','aligncenter','alignright','separator','formatselect', 'bullist', 'numlist', 'blockquote', 'link', 'unlink', 'spellchecker');
    return $mce_buttons;
}


function changeMceDefaults($in) {


    // Keep the "kitchen sink" open
    $in[ 'wordpress_adv_hidden' ] = FALSE;
    return $in;
}
add_filter( 'tiny_mce_before_init', 'changeMceDefaults' );

add_shortcode( 'AllStudents', 'all_students_shortcode_func' );

function all_students_shortcode_func() {
	
	global $wpdb;
	
	$sites = get_sites();
	foreach($sites as $site){
			// Get the new draft post ID
			if ($site->domain == 'communicator.yorkvilleu.ca') {
				$current_site_id = $site->blog_id;
				//var_dump($current_site_id);
			}
			if ($site->domain == 'communicator.yorkvilleu.test') {
				$current_site_id = $site->blog_id;
			}
	}
	$query_current_program_names = "SELECT distinct id, name,description FROM wp_".$current_site_id."_mailpoet_segments where id <>1";
	$current_program_names = $wpdb->get_results($query_current_program_names);
	?>
	<table>
		<tr>
		<th>Program Name</th>
		<th>Description</th>
		<th>Enrolled Students</th>
		</tr>
	<?php
	foreach ($current_program_names as $st_program) {
		?>
		
		<tr>
		<td>
		<?php
		
		echo $st_program->name;
		?>  </td><td>
		<?php
		echo $st_program->description;
		?></td><td>
		<?php
		$query_current_student_numbers = "SELECT count(*) as st_number FROM wp_".$current_site_id."_mailpoet_subscribers where id in (select subscriber_id from wp_".$current_site_id."_mailpoet_subscriber_segment where segment_id=".$st_program->id.")";
		$current_student_numbers = $wpdb->get_results($query_current_student_numbers);
		//var_dump($current_student_numbers);
		echo $current_student_numbers[0]->st_number;
		?>
		</td></tr>
		<?php
		
		
	}
	?>
	</table>
	<?php
}

?>

