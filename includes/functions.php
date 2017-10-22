<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 









//add_query_arg( $param1, $param2, 'http://localhost/wordpress-support/user-profile/user/' );
 
// Parameters as array of key => value pairs

	



add_action('wp_ajax_user_profile_upload_cover_img', function(){

		check_ajax_referer('upload_cover_img');
		
		// you can use WP's wp_handle_upload() function:
		$file = $_FILES['async-upload'];
		
		$status = wp_handle_upload($file, array('action' => 'user_profile_upload_cover_img'));

		$file_loc = $status['file'];
		$file_name = basename($status['name']);
		$file_type = wp_check_filetype($file_name);
	
		$attachment = array(
			'post_mime_type' => $status['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
			'post_content' => '',
			'post_status' => 'inherit'
		);
	
		$attach_id = wp_insert_attachment($attachment, $file_loc);
		$attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
		wp_update_attachment_metadata($attach_id, $attach_data);
		//echo $attach_id;
	
	
		$user_id = get_current_user_id();
		
		update_user_meta( $user_id, 'user_profile_cover', $attach_id );
		//$attach_title = get_the_title($attach_id);
	
		$html['attach_url'] = wp_get_attachment_url($attach_id);
		$html['attach_id'] = $attach_id;
		$html['attach_title'] = get_the_title($attach_id);	
	
		$response = array(
							'status'=>'ok',
							'html'=>$html,
							
							
							);
	
		echo json_encode($response);

  exit;
});

	


add_action('wp_ajax_user_profile_upload_profile_img', function(){

		check_ajax_referer('upload_profile_img');
		
		// you can use WP's wp_handle_upload() function:
		$file = $_FILES['async-upload'];
		
		$status = wp_handle_upload($file, array('action' => 'user_profile_upload_profile_img'));

		$file_loc = $status['file'];
		$file_name = basename($status['name']);
		$file_type = wp_check_filetype($file_name);
	
		$attachment = array(
			'post_mime_type' => $status['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
			'post_content' => '',
			'post_status' => 'inherit'
		);
	
		$attach_id = wp_insert_attachment($attachment, $file_loc);
		$attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
		wp_update_attachment_metadata($attach_id, $attach_data);
		//echo $attach_id;
	
	
		$user_id = get_current_user_id();
		
		update_user_meta( $user_id, 'user_profile_img', $attach_id );
		//$attach_title = get_the_title($attach_id);
	
		$html['attach_url'] = wp_get_attachment_url($attach_id);
		$html['attach_id'] = $attach_id;
		$html['attach_title'] = get_the_title($attach_id);	
	
		$response = array(
							'status'=>'ok',
							'html'=>$html,
							
							
							);
	
		echo json_encode($response);

  exit;
});


	



	
	
	

	
	
	
	
	
	

function user_profile_ajax_follow() {
	
	$user_id = sanitize_text_field($_POST['user_id']);
	$response 	= array();
	$user_info = get_userdata( $user_id );
	

	
	
	$gmt_offset = get_option('gmt_offset');
	$datetime = date('Y-m-d h:i:s', strtotime('+'.$gmt_offset.' hour'));
	
	
	if(is_user_logged_in()):
		
		$logged_user_id = get_current_user_id();
		
		$total_follower = (int)get_the_author_meta( 'total_follower', $user_id );	
		$total_following = (int)get_the_author_meta( 'total_following', $logged_user_id );	
		
		
		if($logged_user_id==$user_id):
			$response['toast_html'] = __("You can not follow yourself.", 'user-profile');

		else:
		
			global $wpdb;
			$table = $wpdb->prefix . "user_profile_follow";
			
			$follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$user_id' AND follower_id = '$logged_user_id'", ARRAY_A);
			
			$already_insert = $wpdb->num_rows;
			if($already_insert > 0 ):
						
					$wpdb->delete( $table, array( 'author_id' => $user_id, 'follower_id' => $logged_user_id), array( '%d','%d' ) );
					//$wpdb->query("UPDATE $table SET followed = '$followed' WHERE author_id = '$authorid' AND follower_id = '$follower_id'");
	
					$response['toast_html'] = 'You are not following <strong>'. $user_info->display_name.'</strong>';
					$response['action'] = 'unfollow';
					$response['follower_id'] = $logged_user_id;
					
					$total_follower -=1; 
					
					if($total_follower<0){$total_follower = 0; }
					update_user_meta( $user_id, 'total_follower', $total_follower );
	
					$total_following -=1; 
					
					if($total_following<0){$total_following = 0; }
					update_user_meta( $logged_user_id, 'total_following', $total_following );	
	
	
			else:
				
					$wpdb->query( $wpdb->prepare("INSERT INTO $table 
												( id, author_id, follower_id, datetime)
										VALUES	( %d, %d, %d, %s)",
										array	( '', $user_id, $logged_user_id,  $datetime )
												));
												
					$response['toast_html'] = 'Thanks for following <strong>'.$user_info->display_name.'</strong>';
					$response['action'] = 'following';
					$response['follower_id'] = $logged_user_id;
					//$html['html'] = '<div class="follower follower-'.$logged_user_id.'">'.get_avatar( $logged_user_id, 32 ).'</div>';
	
					$total_follower +=1; 
					update_user_meta( $user_id, 'total_follower', $total_follower );
	
					$total_following +=1; 
					update_user_meta( $logged_user_id, 'total_following', $total_following );	
	
	
			endif;
			
		endif;
		
	else:
			$response['toast_html'] = __('Please login first.', 'user-profile');
		
	endif;
	

	
	echo json_encode($response);
	die();
}

add_action('wp_ajax_user_profile_ajax_follow', 'user_profile_ajax_follow');
add_action('wp_ajax_nopriv_user_profile_ajax_follow', 'user_profile_ajax_follow');	







	
	function user_profile_admin_notices()
		{
			$accordions_license_key = get_option('accordions_license_key');
			
			$html= '';


					$admin_url = get_admin_url();
					
					$html.= '<div class="update-nag">';
					
					//$html.= sprintf(__('Please activate your license for <b>%s &raquo; <a href="%sedit.php?post_type=accordions&page=license">License</a></b>',accordions_textdomain), accordions_plugin_name, $admin_url);
					
					
					$html.= '</div>';	


			echo $html;
		}




	//add_action('admin_notices', 'user_profile_admin_notices');




