<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 





if(isset($_GET['id'])){
	
	$user_id = sanitize_text_field($_GET['id']);
	//var_dump($user_id);
	}
else{
	
	if(is_author()){
		$user_id =get_the_author_meta( 'ID' );
		}
	else{
		$user_id = get_current_user_id();
		}
	}



	$user_avatar = get_avatar($user_id, 200);
	$user = get_user_by('ID', $user_id);
	
	
	//var_export($user);
	
	$display_name = $user->display_name;



?>





<div class="profile-header">
	<?php do_action('user_profile_action_before_profile_header'); ?>
	<?php do_action('user_profile_action_profile_header'); ?>    
	<?php do_action('user_profile_action_after_profile_header'); ?>
</div>
