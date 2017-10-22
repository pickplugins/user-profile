<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$class_user_profile_functions = new class_user_profile_functions();

$profile_navs = $class_user_profile_functions->profile_navs();

if(isset($_GET['nav'])){
	
	$nav = $_GET['nav'];
	
	}
else{$nav='post';}



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






$user_profile_page_id = get_option('user_profile_page_id');
$user_profile_page_url = get_permalink($user_profile_page_id);

?>





<div class="profile-header-navs">
    <?php do_action('user_profile_action_before_profile_navs'); ?>
    <?php
    
	foreach($profile_navs as $nav_key=>$navs){
		
		//if(empty($nav))
		
		
		
		$title = $navs['title'];
		?><a class="<?php if($nav==$nav_key) echo 'active';?>" href="<?php echo $user_profile_page_url.'?id='.$user_id.'&nav='.$nav_key;?>"><?php echo $title; ?></a><?php
		}
	?>   
	<?php do_action('user_profile_action_after_profile_navs'); ?>
</div>
