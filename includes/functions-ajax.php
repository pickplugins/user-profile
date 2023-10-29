<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/* --- */
/* User Profile add post reaction */
/* --- */

function user_profile_ajax_get_post_content(){
    
	$post_id    = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : ''; 
    $post       = get_post( $post_id );
    
	echo json_encode( array(
		'status'	    => true,
		'html'	 	    => apply_filters( 'the_content', wpautop( $post->post_content ) ),
    ) );
    
	die();
}
add_action('wp_ajax_user_profile_ajax_get_post_content', 'user_profile_ajax_get_post_content');
add_action('wp_ajax_nopriv_user_profile_ajax_get_post_content', 'user_profile_ajax_get_post_content');



/* --- */
/* User Profile add post reaction */
/* --- */

function user_profile_ajax_add_post_reaction(){
    
    global $userprofile;

	$post_id    = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : ''; 
    $reaction   = isset( $_POST['reaction'] ) ? sanitize_text_field( $_POST['reaction'] ) : ''; 
    
    $return     = $userprofile->add_post_reaction( $post_id, $reaction );

    if( is_wp_error( $return ) ){

        echo json_encode( array(
            'status'	    => false,
            'html'	 	    => $return->get_error_message(),
        ) );
        die();
    }

    do_action( 'user_profile_action_after_reaction_added', $post_id, $user_id );

    $User_profile_feed = new User_profile_feed();

	echo json_encode( array(
		'status'	    => true,
		'html'	 	    => $User_profile_feed->generate_single_feed_item( $post_id ),
	) );
	die();
}
add_action('wp_ajax_user_profile_ajax_add_post_reaction', 'user_profile_ajax_add_post_reaction');
add_action('wp_ajax_nopriv_user_profile_ajax_add_post_reaction', 'user_profile_ajax_add_post_reaction');



/* --- */
/* User Profile change post status from front end */
/* --- */

function user_profile_ajax_change_post_status(){
	
	$post_id        = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : ''; 
	$post_status    = isset( $_POST['post_status'] ) ? sanitize_text_field( $_POST['post_status'] ) : ''; 

    $return = wp_update_post( array(
        'ID'            => $post_id,
        'post_status'   => $post_status,
    ) );
    
    if( is_wp_error( $return ) ){

        echo json_encode( array(
            'status'	    => false,
            'html'	 	    => $return->get_error_message(),
            'post_status'   => $post_status,
        ) );
        die();
    }

    $User_profile_feed = new User_profile_feed();

	echo json_encode( array(
		'status'	    => true,
		'html'	 	    => $User_profile_feed->generate_single_feed_item( $post_id ),
		'post_status'   => $post_status,
	) );
	die();
}
add_action('wp_ajax_user_profile_ajax_change_post_status', 'user_profile_ajax_change_post_status');



/* --- */
/* User Profile feed load more */
/* --- */

function user_profile_ajax_feed_refresh(){
	
	
	$user_profile_feed  = new User_profile_feed();
	
	$feed_data = $user_profile_feed->generate_feed();

	if( ! $feed_data ) {
		
		echo json_encode( array( 'status' => false ) );
		die();
	}

	echo json_encode( array(
		'status'	=> true,
		'html'	 	=> $feed_data,
	) );
	die();
}
add_action('wp_ajax_user_profile_ajax_feed_refresh', 'user_profile_ajax_feed_refresh');

function user_profile_ajax_feed_load_more(){
	
	$paged 			= isset( $_POST['paged'] ) ? sanitize_text_field( $_POST['paged'] ) + 1 : 1;
	$postsperpage	= isset( $_POST['postsperpage'] ) ? sanitize_text_field( $_POST['postsperpage'] ) : 10;
	$feedforuser	= isset( $_POST['feedforuser'] ) ? sanitize_text_field( $_POST['feedforuser'] ) : get_current_user_id();
	
	$user_profile_feed  = new User_profile_feed();
	$user_profile_feed->set_feed_for_user( (int)$feedforuser );
	$user_profile_feed->set_posts_per_page( (int)$postsperpage );
	$user_profile_feed->set_paged( (int)$paged );
	
	$feed_data = $user_profile_feed->generate_feed();

	if( ! $feed_data ) {
		
		echo json_encode( array( 'status' => false ) );
		die();
	}

	echo json_encode( array(
		'status'	=> true,
		'html'	 	=> $feed_data,
		'paged'		=> $paged
	) );
	die();
}
add_action('wp_ajax_user_profile_ajax_feed_load_more', 'user_profile_ajax_feed_load_more');


function user_profile_ajax_new_feed_post(){
	
	$response 	= array( 'status' => false );
	$form_data 	= isset( $_POST['form_data'] ) ? user_profile_recursive_sanitize_arr($_POST['form_data']) : "";

	if( empty( $form_data ) ) {
		echo json_encode( $response );
		die();
	}

	parse_str( $_POST['form_data'] );

	$form_data = user_profile_recursive_sanitize_arr($form_data);

	// echo "<pre>"; print_r( $post_content ); echo "</pre>";

    $post_content = isset($form_data['post_content']) ? $form_data['post_content'] : '';

	$post_content 	= wp_kses_post( $post_content );
	$post_title 	= user_profile_shorten_string( $post_content, 2, '' );
	$thumbnail_id	= isset( $post_image[0] ) ? $post_image[0] : 0;

	// foreach( $post_image as $attachment_id ){
	// 	if( $thumbnail_id == 0 ) $thumbnail_id = $attachment_id;
	// 	else $post_content .= wp_get_attachment_image( $attachment_id, 'full' );		
	// }

    if( ! empty( $post_image ) ) $post_content .= sprintf( "[gallery ids='%s']", implode( ",", $post_image ) );


	$post_id = wp_insert_post( array(
		'post_content' 	=> $post_content,
		'post_title'	=> $post_title,
		'post_status'	=> 'publish',
	), true );
	
	if( is_wp_error( $post_id ) ) {
		
		$response['message'] = $post_id->get_error_message();
	}
	else {

		set_post_thumbnail( $post_id, $thumbnail_id );
		$response[ 'status' ] = true;
	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_user_profile_ajax_new_feed_post', 'user_profile_ajax_new_feed_post');



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
	


function user_profile_ajax_follow(){
	
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