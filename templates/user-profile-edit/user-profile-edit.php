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
	
	$user_id = get_current_user_id(); 
	}


?>


<div class="user-profile-edit">

<?php

if(is_user_logged_in()):

	do_action('user_profile_action_before_user_profile_edit'); 
	do_action('user_profile_action_user_profile_edit_main');
	do_action('user_profile_action_after_user_profile_edit'); 
 
else:
?>
	<div class=""><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo __('Please login to access.', 'user-profile'); ?></div>
<?php
	
	
endif;
?>
    
</div>