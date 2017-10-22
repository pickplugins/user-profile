<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



if(is_user_logged_in()){
	
	$logged_user_id = get_current_user_id(); 
	
	//var_dump($logged_user_id);
	}


if(isset($_GET['id'])){
	
	$user_id = sanitize_text_field($_GET['id']);
	//var_dump($user_id);
	}
else{
	
	$user_id = get_current_user_id(); 
	}


if(empty($user_id)){
	
	return;
	}

echo get_query_var( 'nav');

?>





<div class="user-profile-feed">
	<?php do_action('user_profile_action_user_feed_before'); ?>
    
	<?php do_action('user_profile_action_user_feed_main'); ?>
        
    <?php do_action('user_profile_action_user_feed_after'); ?>
 
</div>