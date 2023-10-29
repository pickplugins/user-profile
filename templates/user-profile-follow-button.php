<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$user_id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : get_current_user_id();


$logged_in_user_id      = get_current_user_id();

//var_dump($atts);

$follow_user_id = isset($atts['user_id']) ? $atts['user_id'] : '';

if(!empty($follow_user_id)){

	$follow_user_id = $follow_user_id;
}
else{
	$thisuser = new user_profile_user_data( $user_id );

	if( $thisuser->ID == 0 ) {

		$userprofile->print_error( new WP_Error( 'login_required', sprintf( __( 'No or Invalid user found !', 'user-profile' ) ) ) );
		return;
	}

	$follow_user_id = $thisuser->ID;
}



if( is_user_logged_in() && $logged_in_user_id != $thisuser->ID ){

	global $wpdb;
	$table = $wpdb->prefix . "user_profile_follow";
	$follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$thisuser->ID' AND follower_id = '$logged_in_user_id'", ARRAY_A);

	$follow_text    = $wpdb->num_rows > 0 ? __('<i class="icofont icofont-tick-mark"></i> Following', 'user-profile') : __('Follow', 'user-profile');
	$follow_class   = $wpdb->num_rows > 0 ? 'following' : '';

	?>
	<div user_id='<?php echo $follow_user_id; ?>' class='follow <?php echo $follow_class; ?>'><?php echo $follow_text; ?></div>
	<?php

	//printf( "<div user_id='%d' class='follow %s'>%s</div>", $follow_user_id, $follow_class, $follow_text );
}
?>