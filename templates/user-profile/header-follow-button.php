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
	
	
	
$is_following = '';
$follow_text = __('Follow', 'user-profile');
$follow_class = '';
		

if(is_user_logged_in()){
	
	$logged_user_id = get_current_user_id(); 
	
	
	global $wpdb;
	$table = $wpdb->prefix . "user_profile_follow";
	$follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$user_id' AND follower_id = '$logged_user_id'", ARRAY_A);
	//var_dump($logged_user_id);
	
	$already_insert = $wpdb->num_rows;
	if($already_insert > 0 ){
		
		$is_following = 'yes';
		$follow_text = __('Following', 'user-profile');
		$follow_class = 'following';			
		
		}
	else{
		$is_following = 'yes';
		$follow_text = __('Follow', 'user-profile');
		$follow_class = '';
		}
	
	
	
	
	}







	$user_avatar = get_avatar($user_id, 200);
	$user = get_user_by('ID', $user_id);
	
	
	//var_export($user);
	
	$display_name = $user->display_name;


?>
   
    <div user_id="<?php echo $user_id; ?>" class="follow <?php echo $follow_class; ?>">
        <i class="fa fa-user-plus" aria-hidden="true"></i>
    <?php
    
	echo $follow_text;	
	?>
    
    </div>    

