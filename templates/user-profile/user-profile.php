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
	if(is_author()){
		$user_id =get_the_author_meta( 'ID' );
		}
	else{
		$user_id = get_current_user_id();
		}
	 
	}


if(empty($user_id)){
	
	return;
	}

//echo get_query_var( 'nav');




?>





<div class="user-profile">
	<?php do_action('user_profile_action_before_user_profile'); ?>
    
	<?php do_action('user_profile_action_user_profile_main'); ?>
        
    <?php do_action('user_profile_action_after_user_profile'); ?>
 
</div>