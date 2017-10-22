<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/* Profile Header */

add_action('user_profile_action_user_feed_main','user_profile_action_user_feed_main');



function user_profile_action_user_feed_main(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-feed/feed-items.php');
	
	}

